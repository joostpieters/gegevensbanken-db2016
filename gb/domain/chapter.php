<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class chapter extends DomainObject {

    private $chapter_number;
    private $book_uri;
    private $text;


    function __construct( $id=null ) {
        parent::__construct( $id );
    }

    function setChapterNumber( $nb ) {
        $this->chapter_number = $nb;
    }

    function getChapterNumber( ) {
        return $this->chapter_number;
    }

    function setBookUri ( $uri ) {
        $this->book_uri = $uri;
    }

    function getBookUri () {
        return $this->book_uri;
    }

    function setText($text) {
        $this->text = $text;
    }

    function getText() {
        return $this->text;
    }

}

?>
