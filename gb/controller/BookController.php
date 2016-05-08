<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/mapper/BookMapper.php" );


class BookController extends PageController {
    private $searchResult;
    private $selectedBookUri;
    
    function process() {
        if (isset($_POST["search"])) {

            if ((strlen($_POST["genre"]) > 0)){
                $this->searchResult = $this->searchBooksByGenre($_POST["genre"]);
            }

        }
        
        if (isset($_POST["update"])) {
            $this->updateBookChapter($_GET["book_uri"], $_POST["chapter"], $_POST["new_text"]);
        }
        
        if (isset($_POST["add_chapter"])) {
            $this->addBookChapter($_GET["book_uri"], $_POST["chapter_number"], $_POST["new_text"]);
        }
        
        if (isset($_GET["book_uri"])) {
            $this->selectedBookUri = $_GET["book_uri"];
        }
    }
    
    function updateBookChapter($bookUri, $chapterNumber, $text) {
        $mapper = new \gb\mapper\BookMapper();
        if($mapper->updateChapter($bookUri, $chapterNumber, $text) == 1){
            echo "Chapter updated!";
        }
        else {
            print "Something went wrong!";
        }
    }
    
    function addBookChapter($bookUri, $chapterNumber, $text) {
        $mapper = new \gb\mapper\BookMapper();
        if(!$mapper->bookHasChapterWithNumber($bookUri, $chapterNumber)) {
            $result = $mapper->insertChapter($bookUri, $chapterNumber, $text);
            if (!$result) {
                echo "Chapter NOT added";
            }
        }
        else{
            echo "This chapter number already exists!";
        }
    }
    
    function getSelectedBookUri() {
        return $this->selectedBookUri;
    }

    function searchBooksByGenre($genre){
        $mapper = new \gb\mapper\BookMapper();
        return $mapper->getBooksByGenre($genre);
    }

    function searchBookFromTimeWithAwardInGenreAndWriterFromCountry($minDate, $maxDate, $genre, $country){
        $mapper = new \gb\mapper\BookMapper();
        return $mapper->searchBookFromTimeWithAwardInGenreAndWriterFromCountry($minDate, $maxDate, $genre, $country);
    }

    function getSearchResult() {
        return $this->searchResult;
    }
}

?>