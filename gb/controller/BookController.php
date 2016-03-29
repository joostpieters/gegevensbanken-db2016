<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");


class BookController extends PageController {
    private $selectedBookUri;
    
    function process() {
        if (isset($_POST["search"])) {
            print "Please provide some piece of code here to search books by genres!";
        }
        
        if (isset($_POST["update"])) {
            $this->updateBookChapter();
        }
        
        if (isset($_POST["add_chapter"])) {
            $this->addBookChapter();
        }
        
        if (isset($_GET["book_uri"])) {
            $this->selectedBookUri = $_GET["book_uri"];
        }
    }
    
    function updateBookChapter() {
        print "Please provide some piece of code to update the book chapter here!";
    }
    function addBookChapter() {
        print "Please provide some piece of code to add a new chapter for the selected books here!";
    }
    
    function getSelectedBookUri() {
        return $this->selectedBookUri;
    }
}

?>