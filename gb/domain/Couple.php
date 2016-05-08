<?php
namespace gb\domain;

require_once( "gb/domain/DomainObject.php" );

class Couple extends DomainObject {

    private $person;
    private $spouse;
    private $from;
    private $to;

    function __construct( $id=null ) {
        //$this->name = $name;
        parent::__construct( $id );
    }

    function setPerson($person) {
        $this->person = $person;
    }
    function getPerson(  ) {
        return $this->person;
    }

    function setSpouse ( $spouse ) {
        $this->spouse = $spouse;
    }

    function getSpouse () {
        return $this->spouse;
    }

    function setFromTime( $time) {
        $this->from = $time;
    }

    function getFromTime () {
        return $this->from;
    }

    function setToTime ($time) {
        $this->to = $time;
    }

    function getToTime() {
        return $this->to;
    }

}

?>
