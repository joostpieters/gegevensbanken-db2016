<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Country.php" );


class CountryMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT * FROM country where iso_code = ?";
        $this->selectAllStmt = "SELECT * FROM country order by name";        
    } 
    
    function getCollection( array $raw ) {
        
        $customerCollection = array();
        foreach($raw as $row) {
            array_push($customerCollection, $this->doCreateObject($row));
        }
        
        return $customerCollection;
    }

    protected function doCreateObject( array $array ) {
        
        $obj = null;        
        if (count($array) > 0) {
            $obj = new \gb\domain\Country( $array['iso_code'] );

            $obj->setIsoCode($array['iso_code']);
            $obj->setCountryName($array["name"]);
            $obj->setDescription($array['description']);            
        } 
        
        return $obj;
    }

    protected function doInsert( \gb\domain\DomainObject $object ) {
        /*$values = array( $object->getName() ); 
        $this->insertStmt->execute( $values );
        $id = self::$PDO->lastInsertId();
        $object->setId( $id );*/
    }
    
    function update( \gb\domain\DomainObject $object ) {
        //$values = array( $object->getName(), $object->getId(), $object->getId() ); 
        //$this->updateStmt->execute( $values );
    }

    function selectStmt() {
        return $this->selectStmt;
    }
    
    function selectAllStmt() {
        return $this->selectAllStmt;
    }

    function findCountrysThatHaveAnAward(){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.* FROM country a WHERE a.iso_code IN (SELECT a.country_iso_code from award a WHERE a.country_iso_code IS NOT NULL GROUP BY a.country_iso_code) ORDER BY a.iso_code";
        $countrys = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($countrys);
    }
    
}


?>
