<?php
namespace gb\mapper;

$EG_DISABLE_INCLUDES=true;
require_once( "gb/mapper/Mapper.php" );
require_once( "gb/domain/Chapter.php" );


class ChapterMapper extends Mapper {

    function __construct() {
        parent::__construct();
        $this->selectStmt = "SELECT a.* from chapter a where a.book_uri = ? and a.chapter_number + ?";
    }

    function getCollection( array $raw ) {

        $chapterCollection = array();
        foreach($raw as $row) {
            array_push($chapterCollection, $this->doCreateObject($row));
        }

        return $chapterCollection;
    }

    protected function doCreateObject( array $array ) {

        $obj = null;
        if (count($array) > 0) {
            $obj = new \gb\domain\Chapter( $array['book_uri'].$array['chapter_number'] );

            $obj->setBookUri($array['book_uri']);
            $obj->setChapterNumber($array['chapter_number']);
            $obj->setText($array['text']);
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

    function getChaptersFromBook ($book_uri) {
        $con = $this->getConnectionManager();
        $selectStmt = "SELECT a.* from chapter a where a.book_uri = " ."\"" .$book_uri ."\"";
        $chapters = $con->executeSelectStatement($selectStmt, array());
        return $this->getCollection($chapters);
    }

}


?>
