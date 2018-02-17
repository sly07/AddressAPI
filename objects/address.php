<?php

class Address {
 
    private $m_intId;
    private $m_strName;
    private $m_strStreetNumber;
    private $m_strCity;
    private $m_strState;
    private $m_objDatabase;
 
    public function __construct( $objDatabase ) {
        $this->m_objDatabase = $objDatabase;
    }

    public function fetch() {
     
        $strSql = '
            SELECT *
            FROM
                addresses
        ';
     
        $objDataset = $this->m_objDatabase->prepare( $strSql );
     
        $objDataset->execute();
     
        return $this->prepareGETOutput( $objDataset );
    }

    public function fetchAddressesByName( $strName ) {
        $strSql = '
            SELECT a.*
            FROM
                addresses a
            WHERE a.name ILIKE \'%' . $strName . '%\'';

        $objDataset = $this->m_objDatabase->prepare( $strSql );

        $objDataset->execute();

        return $this->prepareGETOutput( $objDataset );
    }

    public function fetchAddressesByZipCode( $intZipCode ) {
        $strSql = '
            SELECT a.*
            FROM
                addresses a
            WHERE a.zip_code = ' . ( int ) $intZipCode;

        $objDataset = $this->m_objDatabase->prepare( $strSql );

        $objDataset->execute();

        return $this->prepareGETOutput( $objDataset );
    }

    public function insert() {
     
        $strSql = '
            INSERT INTO addresses ( name, street_number, city, state, zip_code )
            VALUES ( \'' . $this->getName() . '\', \'' . $this->getStreetNumber() . '\', \'' . $this->getCity() . '\', \'' . $this->getState() . '\', \'' . $this->getZipCode() . '\' )
        ';
                    
        $objDataset = $this->m_objDatabase->prepare( $strSql );
     
        if( true == $objDataset->execute() ) {
            return json_encode( 
                [ "message" => "Address inserted successfully." ]
            );
        }
     
        return json_encode(
            [ "message" => "Address insertion was not successful." ]
        );
    }

    private function prepareGETOutput( $objDataset ) {

        $intRowCount = $objDataset->rowCount();
         
        if( 0 < $intRowCount ) {
         
            $arrmixAddresses = [];
         
            while ( $arrmixRow = $objDataset->fetch( PDO::FETCH_ASSOC ) ) {
         
                $arrmixAddresses[] = [
                    "id" => $arrmixRow['id'],
                    "name" => $arrmixRow['name'],
                    "street_number" => $arrmixRow['street_number'],
                    "city" => $arrmixRow['city'],
                    "state" => $arrmixRow['state'],
                    "zip_code" => $arrmixRow['zip_code']
                ]; 
            }
         
            return json_encode( $arrmixAddresses );
        } else {
            return json_encode(
                [ "message" => "No addresses found." ]
            );
        }
    }

    public function getId() {
        return $this->m_intId;
    }

    public function getName() {
        return $this->m_strName();
    }

    public function getStreetNumber() {
        return $this->m_strStreetNumber;
    }

    public function getCity() {
        return $this->m_strCity;
    }

    public function getState() {
        return $this->m_strState;
    }

    public function getZipCode() {
        return $this->m_intZipCode;
    }

    public function setId( $intId ) {
        $this->m_intId = $intId;
    }

    public function setName( $strName ) {
        $this->m_strName = $strName;
    }

    public function setStreetNumber( $strStreetNumber ) {
        $this->m_strStreetNumber = $strStreetNumber;
    }

    public function setCity( $strCity ) {
        $this->m_strCity = $strCity;
    }

    public function setState( $strState ) {
        $this->m_strState = $strState;
    }

    public function setZipCode( $intZipCode ) {
        $this->m_intZipCode;
    }
}