<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/ChapterMapper.php");


class ChapterController extends PageController {
    private $searchResult;

    function process() {
        if (isset($_GET["book_uri"])) {
            $this->searchResult = $this->searchChapters($_GET["book_uri"]);
        }
    }

    function searchChapters($book_uri){
        $mapper = new \gb\mapper\ChapterMapper();
        return $mapper->getChaptersFromBook($book_uri);
    }

    function getSearchResult() {
        return $this->searchResult;
    }

    function getTextFromChapter($chapterNumber){
        foreach($this->searchResult as $chapter){
            if($chapter->getChapterNumber() == $chapterNumber){
                return $chapter->getText();
            }
        }
        return "";
    }
}

?>