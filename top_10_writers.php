<?php

$title = "Search writers";

require("template/top.tpl.php");
require_once("gb/controller/WriterTop10Controller.php");
require_once("gb/controller/BookController.php");
require_once("gb/domain/Writer.php");
require_once("gb/mapper/CountryMapper.php");
require_once("gb/mapper/BookGenreMapper.php");

$searchWriterController = new gb\controller\WriterTop10Controller();
$searchWriterController->process();

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
                                    <option value="">-------- Book genres ---------- </option>
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
                            <td><input type ="submit" name="search_writer" value="Search" ></td>
                            <td >&nbsp;</td>
                        </tr>
                    </table>
                </td>
        </table>
    </form>


<?php
$writers = $searchWriterController->getSearchResult();
print count($writers) . " writers found";
if (count($writers) > 0) {
    ?>
    <table style="width: 100%">
        <tr>
            <td>Full name</td>
            <td>Birth date</td>
            <td>Death date</td>
            <td>Description</td>
        </tr>
        <?php
        foreach($writers as $writer) {
            ?>
            <tr>
                <td><?php echo $writer->getFullName(); ?></td>
                <td><?php echo $writer->getDateOfBirth(); ?></td>
                <td><?php echo $writer->getDateOfDeath(); ?></td>
                <td><?php echo $writer->getDescription(); ?></td>

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