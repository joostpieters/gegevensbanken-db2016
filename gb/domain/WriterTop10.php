<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class WriterTop10 extends DomainObject {

    private $writerTop10;

    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }

    function addWriter($writer_uri, $count) {
        if (count($this->writerTop10) < 10) {
            $this->writerTop10[$writer_uri] = $count;
            arsort($this->writerTop10);
        } elseif ($count > $this->writerTop10[9]) {
            array_pop($this->writerTop10);
            $this->writerTop10[$writer_uri] = $count;
        }

    }

}

?>
