<?php

class PaypalException extends Exception {

}

class ConnectionException extends PaypalException
{

}

class ResponseException extends PaypalException
{

}

class PaypalParser
{
    static public $timeout = 30;

    private $pdtToken;

    /* either 'socket' or 'curl' */
    private $connectMode;

    private $apiUrl;

    public function __construct( $pdtToken, $apiUrl = 'https://www.paypal.com/cgi-bin/webscr', $connectMode = 'curl' )
    {

        $this->pdtToken = $pdtToken;
        $this->connectMode = $connectMode;
        $this->apiUrl = $apiUrl;

    }

    private function curlRequest( $post ) {

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, $this->apiUrl );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_POST, 1 );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
        curl_setopt( $ch, CURLOPT_FRESH_CONNECT, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, self::$timeout );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        $response = curl_exec( $ch );

        if( $response === false ) {
            throw new ConnectionException( curl_error( $ch ), curl_errno( $ch ) );
        }

        return $response;

    }

    private function socketRequest( $post ) {

        $url = parse_url( $this->apiUrl );

        if( $url['scheme'] == "https" ) {
            $port = 443;
            $protocol = "ssl://";
        } else {
            $port = 80;
            $protocol = "";
        }

        $header  = "POST " . $url['path'] . " HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen( $post ) . "\r\n\r\n";

        $fp = fsockopen(
            $protocol . $url['host'],
            $port,
            $errno,
            $errstr,
            self::$timeout
        );

        if( !$fp ) {
            throw new ConnectionException( $errno, $errstr );
        }

        fputs( $fp, $header . $post );

        $headers = array();
        $response = "";

        $headerdone = false;

        while( !feof( $fp ) && !$headerdone ) {

            $line = fgets( $fp, 1024 );

            if( trim( $line ) == "" ) {
                $headerdone = true;
            } else {
                $headers[] = $line;
            }

        }

        while( !feof( $fp ) ) {

            $line = fgets( $fp, 1024 );
            $response .= $line;

        }

        return $response;

    }

    public function getTransactionInfo( $transactionId ) {

        $post = "cmd=_notify-synch" 
            . "&tx=" . $transactionId
            . "&at=" . $this->pdtToken;

        if( $this->connectMode == 'curl' ) {
            $response = $this->curlRequest( $post );
        } else {
            $response = $this->socketRequest( $post );
        }

        $lines = explode( "\n", $response );

        $status = array_shift( $lines );

        if( $status != "SUCCESS" ) {
            throw new ResponseException( $response );
        }

        $transaction = array();

        foreach( $lines as $line ) {

            $line = trim( $line );
            if( $line != "" ) {

                $parts = explode( "=", $line );
                $key = $parts[0];
                $value = null;

                if(  count( $parts ) > 1 ) {
                    $value = $parts[1];
                }

                $transaction[ urldecode( $key ) ] = urldecode( $value );

            }
        }

        return $transaction;

    }

}

?>
