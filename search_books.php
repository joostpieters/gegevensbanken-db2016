<?php
	
$title = "Search books by genres";

require("template/top.tpl.php");
require_once("gb/controller/BookController.php");
require_once("gb/mapper/BookGenreMapper.php");

$bookController = new gb\controller\BookController();
$bookController->process();

$bookGenreMapper = new gb\mapper\BookGenreMapper();
$allBookGenres = $bookGenreMapper->findAll();
 
?>    
<form method="post">
<table style="width: 100%">

<tr>
    <td colspan="4">
    <table style="width: 100%">        
        <tr>
            <td>Genre</td>            
            <td colspan="3" style="width: 85%">
                <select style="width: 50%" name="genre">
                    <option value="">--------Book genres ---------- </option>
                    <?php
                    foreach($allBookGenres as $bookGenre) {
                        echo "<option value=\"", $bookGenre->getUri(), "\">", $bookGenre->getGenreName(), "</option>" ;
                    }

                    ?>
                </select>
            </td>          
        </tr>
        <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td><input type ="submit" name="search" value="Search" ></td>
            <td >&nbsp;</td>
    
        </tr>
    </table>
    </td>
</table>
</form>

<?php
    $books = $bookController->getSearchResult();
    print count($books) . " books found";
    if (count($books) > 0) {
?>
<table style="width: 100%">
    <tr>
        <td>Book name</td>        
        <td>Awards</td>
        <td>Description</td>
    </tr>
    <?php
        foreach($books as $book) {
    ?>
        <tr>
            <td><?php echo $book->getName(); ?></td>
            <td><?php echo $book->getNbAwards(); ?></td>
            <td><?php echo $book->getDescription(); ?></td>

        </tr>
<?php
        }
?>
</table>
 <?php
    }
?>

<?php
	require("template/bottom.tpl.php");
?>