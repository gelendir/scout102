<?php

class PdfGenerator
{

    private $pdf;

    public function __construct( $title, $author )
    {

        $pdf = Yii::createComponent(
            'application.extensions.tcpdf.ETcPdf',
            'P', 'cm', 'Letter', true, 'UTF-8'
        );

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor( $author );
        $pdf->SetTitle( $title );
        $pdf->SetSubject( $title );
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AliasNbPages();

        $this->pdf = $pdf;

    }

    public function getPdfHandle()
    {
        return $this->pdf;
    }

    public function addHTMLPage( $html )
    {

        $this->pdf->AddPage();
        //$pdf->writeHTML($html, true, false, false, false, '');
        //$pdf->writeHTML( $html, true, false, true, true, 'L' );
        $this->pdf->writeHTML( $html );

    }

    public function closeAndGenerate( $fullFilePath )
    {
        $this->pdf->LastPage();
        $this->pdf->Output( $fullFilePath, "F" );

    }

}

?>
