<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/CoupleMapper.php" );

class SearchCoupleController extends PageController {
    private $couples;

    function process() {
        
    }

    function findWritersWhoseSpouseAlsoWrites(){
        $mapper = new \gb\mapper\CoupleMapper();
        return $mapper->getWritersWhoseSpouseAlsoWrites();
    }
}

?>