<?php

$title = "Search writers";

require("template/top.tpl.php");
require_once("gb/controller/WriterTop10Controller.php");
require_once("gb/controller/BookController.php");
require_once("gb/domain/Writer.php");
require_once("gb/domain/WriterTop10.php");
require_once("gb/mapper/CountryMapper.php");
require_once("gb/mapper/BookGenreMapper.php");

$WriterTop10Controller = new gb\controller\WriterTop10Controller();
$WriterTop10Controller->process();

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
$writerTop10 = $WriterTop10Controller->getSearchResult();
print count($writerTop10) . " writers found";
if (count($writerTop10) > 0) {
    ?>
    <table style="width: 100%">
        <tr>
            <td>Writer Uri</td>
            <td>Count</td>
            <!--            <td>Full name</td>-->
<!--            <td>Birth date</td>-->
<!--            <td>Death date</td>-->
<!--            <td>Description</td>-->
        </tr>
        <?php
        foreach($writerTop10 as $writer) {
            ?>
            <tr>
                <td><?php echo $writer->getUri(); ?></td>
                <td><?php echo $writer->getCount(); ?></td>
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