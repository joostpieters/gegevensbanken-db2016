<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Couple.php" );


class CoupleMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT writer_uri, person_uri FROM is_spouse_of WHERE writer_uri = ?";
        $this->selectAllStmt = "SELECT writer_uri, person_uri FROM is_spouse_of";
    }

    function getCollection( array $raw ) {

        $coupleCollection = array();
        foreach($raw as $row) {
            array_push($coupleCollection, $this->doCreateObject($row));
        }

        return $coupleCollection;
    }

    protected function doCreateObject( array $array ) {

        $obj = null;
        if (count($array) > 0) {
            $obj = new \gb\domain\Couple( $array['writer_uri']+$array['person_uri'] );

            $obj->setPerson($array['writer_uri']);
            $obj->setSpouse($array['person_uri']);
            $obj->setFromTime($array['from_time']);
            $obj->setToTime($array['to_time']);
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

    function getWritersWhoseSpouseAlsoWrites(){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT * FROM is_spouse_of WHERE person_uri IN (SELECT writer_uri FROM writer)";
        $couples = $con->executeSelectStatement($selectStmt, array());
        #print $selectStmt;
        return $this->getCollection($couples);
    }


}


?>
