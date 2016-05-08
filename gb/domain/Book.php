<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );
require_once("gb/mapper/BookMapper.php" );

class Book extends DomainObject {

    private $uri;
    private $name;
    private $description;
    private $original_language;
    private $first_publication_date;


    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }

    function setUri( $uri ) {
        $this->uri = $uri;
    }

    function getUri( ) {
        return $this->uri;
    }

    function setName ( $name ) {
        $this->name = $name;
    }

    function getName () {
        return $this->name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function getDescription() {
        return $this->description;
    }

    function setOriginalLanguage($language) {
        $this->original_language = $language;
    }

    function getOriginalLanguage() {
        return $this->original_language;
    }

    function setFirstPublicationDate($date) {
        $this->first_publication_date = $date;
    }

    function getFirstPublicationDate() {
        return $this->first_publication_date;
    }

    function getNbAwards(){
        $mapper = new \gb\mapper\BookMapper();
        return $mapper->getNbAwards($this->uri);
    }

    function getNbChapters(){
        $mapper = new \gb\mapper\BookMapper();
        return $mapper->getNbChapters($this->uri);
    }

}

?>
