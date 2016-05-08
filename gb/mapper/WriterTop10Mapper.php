<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once("gb/mapper/WriterMapper.php" );


class WriterTop10Mapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT a.*, b.* from person a, writer b where a.uri = b.writer_uri and a.uri = ?";
        $this->selectAllStmt = "SELECT a.*, b.* from person a, writer b where a.uri = b.writer_uri";
    }

    function getCollection( array $raw ) {

        $writerTop10Collection = array();
        for($i=0; $i<10 && $i<count($raw); $i++){
            array_push($writerTop10Collection, $this->doCreateObject($raw[$i]));
        }

        return $writerTop10Collection;
    }

    protected function doCreateObject( array $array ) {

        $obj = null;
        if (count($array) > 0) {
            $writerMapper = new \gb\mapper\WriterMapper();
            $obj = $writerMapper->getWriterByUri($array['writer_uri'])[0];

            $obj->setRank($array['COUNT(*)']);
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

    function getWritersTop10ByGenreAndNbAwards ($genre) {
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.writer_uri, COUNT(*) FROM writes a, award b Where (a.book_uri, b.uri) 
                        IN (SELECT book_uri, award_uri FROM wins_award WHERE genre_uri=\"".$genre."\") 
                          GROUP BY a.writer_uri ORDER BY COUNT(*) DESC";
        $writers = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($writers);
    }

    function getWritersTop10ByGenreAndNbAwardsFromCountry($genre, $country){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.writer_uri, COUNT(*) FROM writes a, award b Where (a.book_uri, b.uri) IN (SELECT book_uri, award_uri FROM wins_award WHERE genre_uri=\"".$genre."\") AND a.writer_uri IN (SELECT person_uri FROM has_citizenship WHERE country_iso_code=\"".$country."\") GROUP BY a.writer_uri ORDER BY COUNT(*) DESC";
        $writers = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($writers);
    }

    function getWriterTop10TotalBooksWritten(){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.writer_uri, COUNT(*) FROM writes a GROUP BY a.writer_uri ORDER BY COUNT(*) DESC";
        $writers = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($writers);
    }

}

?>