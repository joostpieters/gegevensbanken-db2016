<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/BookGenre.php" );


class BookGenreMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT * FROM genre where uri = ?";
        $this->selectAllStmt = "SELECT * FROM genre order by name";
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
            $obj = new \gb\domain\BookGenre( $array['uri'] );

            $obj->setUri($array['uri']);
            $obj->setGenreName($array["name"]);
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

    function findGenresFromCountry($country){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.* from genre a WHERE a.uri IN (SELECT a.genre_uri FROM has_genre a WHERE a.book_uri IN (SELECT a.book_uri FROM writes a WHERE a.writer_uri IN (SELECT a.person_uri FROM has_citizenship a WHERE a.country_iso_code = \"".$country."\")))";
        $genres = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($genres);
    }

}


?>
