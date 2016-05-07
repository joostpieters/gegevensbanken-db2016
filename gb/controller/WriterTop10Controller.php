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
    private $writers;

    function process() {
        if (isset($_POST["genre"])) {
            $this->writers = $this->searchTop10ByGenre($_POST["genre"]);
        }
    }

    function searchTop10ByGenre($genre)
    {
        print "Genre = " . $genre;
        $mapper = new \gb\mapper\WriterTop10Mapper();
        return $mapper->getWritersTop10ByGenre($genre);
    }

    function getSearchResult() {
        return $this->writers;
    }
}

?>