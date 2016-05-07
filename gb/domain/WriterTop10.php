<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class WriterTop10 extends DomainObject {

    private $uri;
    private $count;

    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }
    
    function setUri($uri) {
        $this->writer = $uri;
    }

    function getUri() {
        return $this->uri;
    }

    function setCount($count) {
        $this->count = $count;
    }
    
    function getCount() {
        return $this->count;
    }
    
}

?>
