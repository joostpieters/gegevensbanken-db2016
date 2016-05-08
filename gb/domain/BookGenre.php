<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class bookGenre extends DomainObject {

    private $uri;
    private $name;
    private $description;


    function __construct( $id=null ) {
        parent::__construct( $id );
    }

    function setUri( $uri ) {
        $this->uri = $uri;
    }

    function getUri( ) {
        return $this->uri;
    }

    function setGenreName ( $name ) {
        $this->name = $name;
    }

    function getGenreName () {
        return $this->name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function getDescription() {
        return $this->description;
    }

}

?>
