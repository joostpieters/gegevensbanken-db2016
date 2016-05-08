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

    /**
     * Is empty because we chose to display more than one top10 at the same time.
     */
    function process() {
    }

    /**
     * @param $genre        parameter containing the genre in which the books of the writers are written
     * @return array        An array which contains writer_uri's and the number of awarded books the writer has written in the given genre.
     *                      The array will not contain writers who have won zero awards by books written in the given genre.
     *                      The array is sorted by the number of books for which the writer has received (an) award(s), from most to least awarded books.
     *                      Only the top ten writers will be returned.
     */
    function searchTop10ByGenreAndNbAwards($genre)
    {
        $mapper = new \gb\mapper\WriterTop10Mapper();
        $writers = $mapper->getWritersTop10ByGenreAndNbAwards($genre);
        return $writers;
    }

    /**
     * @param $genre        parameter containing the genre in which the books of the writers are written
     * @param $country      parameter containing the country in which the author was born
     * @return array        An array which contains writer_uri's and the number of awarded books the writer has written in the given genre.
     *                      The array will only contain writers who were born in the given country
     *                      The array will not contain writers who have won zero awards by books written in the given genre.
     *                      The array is sorted by the number of books for which the writer has received (an) award(s), from most to least awarded books.
     *                      Only the top ten writers will be returned.
     */
    function searchTop10ByGenreAndNbAwardsFromCountry($genre, $country)
    {
        $mapper = new \gb\mapper\WriterTop10Mapper();
        $writers = $mapper->getWritersTop10ByGenreAndNbAwardsFromCountry($genre, $country);
        return $writers;
    }

    /**
     * @return array        An array which contains every writer_uri and the number of books the writer has written.
     *                      The array is sorted by the number of books the writer has written up till now, from most to least written books.
     *                      Only the top ten writers will be returned.
     */
    function searchTop10ByNbBooks()
    {
        $mapper = new \gb\mapper\WriterTop10Mapper();
        $writers = $mapper->getWriterTop10TotalBooksWritten();
        return $writers;
    }
}

?>