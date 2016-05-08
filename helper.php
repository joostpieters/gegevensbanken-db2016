<?php

$title = "Update chapters of books";

require("template/top.tpl.php");
require_once("gb/mapper/BookGenreMapper.php");
require_once("gb/mapper/WriterMapper.php");
require_once("gb/connection/ConnectionManager.php");
require_once("gb/mapper/CountryMapper.php");

$bookGenreMapper = new gb\mapper\BookGenreMapper();
$allBookGenres = $bookGenreMapper->findAll();

$writerMapper = new gb\mapper\WriterMapper();
$allWriters = $writerMapper->findAll();

$countryMapper = new gb\mapper\CountryMapper();
$allCountries = $countryMapper->findAll();

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if (!isset($_POST["insert"])) {
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
                                    <option value="">--------Book genres ----------</option>
                                    <?php
                                    foreach ($allBookGenres as $bookGenre) {
                                        echo "<option value=\"", $bookGenre->getUri(), "\">", $bookGenre->getGenreName(), "</option>";
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Writer</td>
                            <td colspan="3" style="width: 85%">
                                <select style="width: 50%" name="writer">
                                    <option value="">--------Writers ----------</option>
                                    <?php
                                    foreach ($allWriters as $writer) {
                                        echo "<option value=\"", $writer->getUri(), "\">", $writer->getFullName(), "</option>";
                                    }

                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>book_uri</td>
                            <td><input type="text" name="book_uri" value="<?php echo generateRandomString(15);?>"></td>
                        </tr>
                        <tr>
                            <td>book name</td>
                            <td><input type="text" name="book_name" value="<?php echo generateRandomString(10);?>"></td>
                        </tr>
                        <tr>
                            <td>award_uri</td>
                            <td><input type="text" name="award_uri" value="<?php echo generateRandomString(15);?>"></td>
                        </tr>
                        <tr>
                            <td>award name</td>
                            </td>
                            <td><input type="text" name="award_name"  value="<?php echo generateRandomString(10);?>"></td>
                        </tr>
                        <tr><td></td><td>Fill this in to creae a new writer: </td></tr>
                            <tr>
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
                        <tr>
                            <td>writer name</td>
                            </td>
                            <td><input type="text" name="writer_name"  value="<?php echo generateRandomString(10);?>"></td>
                        </tr>
                        <tr>
                            <td>writer uri</td>
                            </td>
                            <td><input type="text" name="writer_uri"  value="<?php echo generateRandomString(10);?>"></td>
                        </tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td><input type="submit" name="insert" value="Insert"></td>
                            <td>&nbsp;</td>

                        </tr>
                    </table>
                </td>
        </table>
    </form>

    <?php
}
else{
    if($_POST["genre"] != "" && ($_POST["writer"] || ($_POST["writer"] == "" && isset($_POST["country"]) && isset($_POST["writer_name"]) && isset($_POST["writer_uri"])) ) != "" && $_POST["book_uri"] != "" && $_POST["book_name"] != "" && $_POST["award_uri"] != "" && $_POST["award_name"] != ""){
        echo "start insertion...<br />";
        $writer_uri = $_POST["writer"];
        $con = new \gb\connection\ConnectionManager();

        if($_POST["writer"] == "" && isset($_POST["country"]) && isset($_POST["writer_name"]) && isset($_POST["writer_uri"])){
            $statement6 = "INSERT INTO person (uri, full_name) VALUES (\"".$_POST["writer_uri"]."\", \"".$_POST["writer_name"]."\")";
            $statement7 = "INSERT INTO writer (writer_uri) VALUES (\"".$_POST["writer_uri"]."\")";
            $statement8 = "INSERT INTO has_citizenship (person_uri, country_iso_code) VALUES (\"".$_POST["writer_uri"]."\", \"".$_POST["country"]."\")";

            $writer_uri = $_POST["writer_uri"];
        }
        $statement1 = "INSERT INTO book (uri, name) VALUES (\"".$_POST["book_uri"]."\", \"".$_POST["book_name"]."\")";
        $statement2 = "INSERT INTO has_genre (genre_uri, book_uri) VALUES (\"".$_POST["genre"]."\", \"".$_POST["book_uri"]."\")";
        $statement3 = "INSERT INTO writes (writer_uri, book_uri) VALUES (\"".$writer_uri."\", \"".$_POST["book_uri"]."\")";
        $statement4 = "INSERT INTO award (uri, name) VALUES (\"".$_POST["award_uri"]."\",\"".$_POST["award_name"]."\")";
        $statement5 = "INSERT INTO wins_award (book_uri, genre_uri, award_uri) VALUES (\"".$_POST["book_uri"]."\", \"".$_POST["genre"]."\", \"".$_POST["award_uri"]."\")";

        $con->executeInsertStatement($statement1, array());
        $con->executeInsertStatement($statement2, array());
        $con->executeInsertStatement($statement4, array());
        $con->executeInsertStatement($statement5, array());
        if($_POST["writer"] == "" && isset($_POST["country"]) && isset($_POST["writer_name"]) && isset($_POST["writer_uri"])){
            echo "Create writer";
            $con->executeInsertStatement($statement6, array());
            $con->executeInsertStatement($statement8, array());
            $con->executeInsertStatement($statement7, array());
        }
        $con->executeInsertStatement($statement3, array());

        echo "Insertion done!  <a href='helper.php'>do again...</a>";

    }
    else{
        echo "Something wasn't filled in, <a href='helper.php'>try again...</a>";
    }
}
?>

<?php
require("template/bottom.tpl.php");
?>