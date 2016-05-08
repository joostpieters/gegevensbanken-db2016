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

    /**
     * @param array $raw
     * @return array        an array which contains the first (up to 10) elements from the given array raw
     */
    function getCollection(array $raw ) {

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

    /**
     * @param $genre        parameter containing the genre in which the books of the writers are written
     * @return array        An array which contains writer_uri's and the number of awarded books the writer has written in the given genre.
     *                      The array will not contain writers who have won zero awards by books written in the given genre.
     *                      The array is sorted by the number of books for which the writer has received (an) award(s), from most to least awarded books.
     */
    function getWritersTop10ByGenreAndNbAwards ($genre) {
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.writer_uri, COUNT(*) FROM writes a, award b Where (a.book_uri, b.uri) 
                        IN (SELECT book_uri, award_uri FROM wins_award WHERE genre_uri=\"".$genre."\") 
                         GROUP BY a.writer_uri ORDER BY COUNT(*) DESC";
        $writers = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($writers);
    }

    /**
     * @param $genre        parameter containing the genre in which the books of the writers are written
     * @param $country      parameter containing the country in which the author was born
     * @return array        An array which contains writer_uri's and the number of awarded books the writer has written in the given genre.
     *                      The array will only contain writers who were born in the given country
     *                      The array will not contain writers who have won zero awards by books written in the given genre.
     *                      The array is sorted by the number of books for which the writer has received (an) award(s), from most to least awarded books.
     */
    function getWritersTop10ByGenreAndNbAwardsFromCountry($genre, $country){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.writer_uri, COUNT(*) FROM writes a, award b Where (a.book_uri, b.uri) 
                        IN (SELECT book_uri, award_uri FROM wins_award WHERE genre_uri=\"".$genre."\") 
                         AND a.writer_uri IN (SELECT person_uri FROM has_citizenship WHERE country_iso_code=\"".$country."\") 
                          GROUP BY a.writer_uri ORDER BY COUNT(*) DESC";
        $writers = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($writers);
    }

    /**
     * @return array        An array which contains every writer_uri and the number of books the writer has written.
     *                      The array is sorted by the number of books the writer has written up till now, from most to least written books.
     */
    function getWriterTop10TotalBooksWritten(){
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.writer_uri, COUNT(*) FROM writes a GROUP BY a.writer_uri ORDER BY COUNT(*) DESC";
        $writers = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($writers);
    }

}

?>