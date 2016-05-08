<?php

$title = "Search writers";

require("template/top.tpl.php");
require_once("gb/controller/WriterTop10Controller.php");
require_once("gb/domain/Writer.php");
require_once("gb/mapper/BookGenreMapper.php");
require_once("gb/mapper/CountryMapper.php");

$WriterTop10Controller = new gb\controller\WriterTop10Controller();

$bookGenreMapper = new gb\mapper\BookGenreMapper();
$allBookGenres = $bookGenreMapper->findAll();

$countryMapper = new gb\mapper\CountryMapper();
$allCountries = $countryMapper->findAll();

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
                            <td>Select country:</td>
                            <td colspan="3" style="width: 85%">
                                <select style="width: 50%" name="country">
                                    <option value="">--------Select country ---------- </option>
                                    <?php
                                    foreach($allCountries as $country) {
                                        echo "<option value=\"", $country->getIsoCode(), "\">", $country->getCountryName(), "</option>" ;
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
if(isset($_POST["genre"])){
    $writerTop10 = $WriterTop10Controller->searchTop10ByGenreAndNbAwards($_POST["genre"]);
    echo "<u><b>Top 10 writers according to the number of awards from the selected genre.</b></u><br />";
    if (count($writerTop10) > 0) {
        ?>
        <table style="width: 100%">
            <tr>
                <td><b>Writer</b></td>
                <td><b>Count</b></td>
            </tr>
            <?php
            foreach($writerTop10 as $writer) {
                ?>
                <tr>
                    <td><?php echo $writer->getFullName(); ?></td>
                    <td><?php echo $writer->getRank(); ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
    else{
        echo "No writters found for the selected genre<br />";
    }

    if($_POST["country"] != ""){
        $writerTop10 = $WriterTop10Controller->searchTop10ByGenreAndNbAwardsFromCountry($_POST["genre"], $_POST["country"]);

        if (count($writerTop10) > 0) {
            echo "<br /><u><b>Top 10 like above buth only writers from the specified country. </b></u><br />";
            ?>
            <table style="width: 100%">
                <tr>
                    <td><b>Writer</b></td>
                    <td><b>Count</b></td>
                </tr>
                <?php
                foreach($writerTop10 as $writer) {
                    ?>
                    <tr>
                        <td><?php echo $writer->getFullName(); ?></td>
                        <td><?php echo $writer->getRank(); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
        else{
            echo "No writters found for the genre/country combination.<br />";
        }

    }
    else{
        echo "Select a country to finetune your search! <br />";
    }
}
else{
    echo "Please select a genre.<br />";
}
echo "<br /><u><b>Top 10 writers with the most written books.</b></u><br />";
$writerTop10 = $WriterTop10Controller->searchTop10ByNbBooks();
if (count($writerTop10) > 0) {
        ?>
        <table style="width: 100%">
            <tr>
                <td><b>Writer</b></td>
                <td><b>Count</b></td>
            </tr>
            <?php
            foreach($writerTop10 as $writer) {
                ?>
                <tr>
                    <td><?php echo $writer->getFullName(); ?></td>
                    <td><?php echo $writer->getRank(); ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
?>
<br /><br />click <a href="helper.php">here</a> to generate a book-wins-award-in-genre-written-by combination
<?php
require("template/bottom.tpl.php");
?>