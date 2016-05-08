<?php
namespace gb\controller;

require_once("gb/controller/PageController.php");
require_once("gb/controller/BookController.php");
require_once("gb/mapper/BookGenreMapper.php");
require_once("gb/mapper/CountryMapper.php");


class WinAwardController extends PageController {
    private $result = [];

    function process() {
        if (isset($_POST["search"])) {
            echo "start processing";
            $bookController = new \gb\controller\BookController();

            $countryMapper = new \gb\mapper\CountryMapper();
            $CountriesWithAward = $countryMapper->findCountrysThatHaveAnAward();

            foreach($CountriesWithAward as $country){
                $bookGenreMapper = new \gb\mapper\BookGenreMapper();
                $bookGenresWithCountry = $bookGenreMapper->findGenresFromCountry($country->getIsoCode());
                $this->result[$country->getCountryName()] = [];
                foreach($bookGenresWithCountry as $genre){
                    $nb = count($bookController->searchBookFromTimeWithAwardInGenreAndWriterFromCountry($_POST["from_time"], $_POST["to_time"], $genre->getUri(), $country->getIsoCode()));
                    if ($nb>0){
                        array_push($this->result[$country->getCountryName()], [$genre->getGenreName(), $nb]);
                    }
                }
                if(count($this->result[$country->getCountryName()]) == 0){
                    unset($this->result[$country->getCountryName()]);
                }
            }
        }
    }

    function getResult(){
        return $this->result;
    }
}

?>