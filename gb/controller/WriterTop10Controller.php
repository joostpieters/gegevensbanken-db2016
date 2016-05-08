<?php
/**
 * Created by PhpStorm.
 * User: KoenG
 * Date: 4/05/2016
 * Time: 15:23
 */

namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/WriterTop10Mapper.php" );

class WriterTop10Controller extends PageController {

    function process() {
    }

    function searchTop10ByGenreAndNbAwards($genre)
    {
        $mapper = new \gb\mapper\WriterTop10Mapper();
        $writers = $mapper->getWritersTop10ByGenreAndNbAwards($genre);
        return $writers;
    }

    function searchTop10ByGenreAndNbAwardsFromCountry($genre, $country)
    {
        $mapper = new \gb\mapper\WriterTop10Mapper();
        $writers = $mapper->getWritersTop10ByGenreAndNbAwardsFromCountry($genre, $country);
        return $writers;
    }

    function searchTop10ByNbBooks()
    {
        $mapper = new \gb\mapper\WriterTop10Mapper();
        $writers = $mapper->getWriterTop10TotalBooksWritten();
        return $writers;
    }
}

?>