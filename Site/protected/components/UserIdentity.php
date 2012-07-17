<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    private $id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {

        if( trim( $this->username ) == "" ) {

            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return false;

        } else if ( trim( $this->password ) == "" ) {

            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            return false;

        }

        $adulte = Adulte::model()->findByAttributes(
            array(
                'NOM_UTILISATEUR'   => $this->username,
                'COMPTE_ACTIF'      => true,
            )
        );

        if( $adulte === null ) {

            $this->errorCode = self::ERROR_USERNAME_INVALID;

        } else if ( crypt( $this->password, $adulte->MOT_DE_PASSE ) != $adulte->MOT_DE_PASSE ) {

            $this->errorCode = self::ERROR_PASSWORD_INVALID;

        } else {

            $this->id = $adulte->ID_ADULTE;

            $this->setState( 'idFamille', $adulte->familles[0]->ID_FAMILLE );
            $this->setState( 'nomComplet', $adulte->nomComplet );
            $this->setState( 'roles', $this->findRoles( $adulte->ID_ADULTE ) );
            $this->setState( 'isAllowedAdmin', $this->isAllowedAdmin );

            $this->errorCode = self::ERROR_NONE;

        }

        return !$this->errorCode;

    }

    private function findRoles( $idAdulte )
    {

        $roles = Role::model()
            ->with('typeImplications.implications')
            ->findAll(
                'implications.ID_ADULTE = :idAdulte AND ACCORDE = TRUE',
                array(
                    'idAdulte' => $idAdulte,
                )
            );

        $roleNames = array();
        foreach( $roles as $role ) {
            if( !in_array( $role->NOM_ROLE, $roleNames ) ) {
                $roleNames[] = $role->NOM_ROLE;
            }
        }

        return $roleNames;

    }

    public function getId()
    {

        return $this->id;

    }

    public function getIdFamille()
    {

        return $this->getState( 'idFamille' );

    }

    public function getNomComplet()
    {

        return $this->getState( 'nomComplet' );

    }

    public function getRoles()
    {

        return $this->getState( 'roles' );

    }

    public function getIsAllowedAdmin()
    {

        $authorisedRoles = array(
            'Administrateur'
        );

        $granted = array_intersect( $authorisedRoles, $this->roles );

        return ( count( $granted ) > 0 );

    }

}
