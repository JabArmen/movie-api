<?php
require_once __DIR__ . './../helpers/WebServiceInvoker.php';

/**
 * A class for consuming the Ice and Fire API.
 *
 * @author Sleiman Rabah
 */
class wikiApiController extends WebServiceInvoker {

    private $request_options = Array(
        'headers' => Array('Accept' => 'application/json')
    );

    public function __construct() {
        parent::__construct($this->request_options);
    }

    /**
     * Fetches and parses a list of director biography from wikipedia api.
     * 
     * @return array containing some information about biography. 
     */
    function getAllDirectorInfo($input_page_number, $input_per_page) {
        $biography = Array();
        $director = new DirectorModel();
        $director->setPaginationOptions($input_page_number, $input_per_page);
        $names = $director->getAllNames();
        $i = 0;
        foreach($names["data"] as $value) {
            $name = $value["name"]; 
            $resource_uri = "https://en.wikipedia.org/w/api.php?action=query&format=json&titles=${name}&prop=extracts&exintro=True&explaintext=True";
            $directorData = $this->invoke($resource_uri);

            if (!empty($directorData)) {
                // Parse the fetched list of books.   
                $directorData = json_decode($directorData, true);
                //var_dump($directorData);exit;

                // Parse the list of books and retreive some  
                // of the contained information.
                // foreach ($directorData as $key => $director) {
                $page = array_values($directorData['query']['pages']);
                    #var_dump($page[0]["extract"]);
                $biography[$i]["name"] = $name;
                $biography[$i]["bio"] = $page[0]["extract"];
                    #$biography["bio"] = $directorData["query"]["pages"][""];
                // }
            }

            $i++;
        }
        return $biography;
    }

    /**
     * Fetches and parses a list of director biography from wikipedia api.
     * 
     * @return array containing some information about biography. 
     */
    function getCountryDirectorInfo($country, $input_page_number, $input_per_page) {
        $biography = Array();
        $director = new DirectorModel();
        $director->setPaginationOptions($input_page_number, $input_per_page);
        $names = $director->getDirectorByCountryName($country);
        $i = 0;
        foreach($names["data"] as $value) {
            $name = $value["name"];
            $resource_uri = "https://en.wikipedia.org/w/api.php?action=query&format=json&titles=${name}&prop=extracts&exintro=True&explaintext=True";
            $directorData = $this->invoke($resource_uri);

            if (!empty($directorData)) {
                // Parse the fetched list of books.   
                $directorData = json_decode($directorData, true);
                //var_dump($directorData);exit;

                // Parse the list of books and retreive some  
                // of the contained information.
                
                // foreach ($directorData as $key => $director) {
                $page = array_values($directorData['query']['pages']);
                    #var_dump($page[0]["extract"]);
                $biography[$i]["name"] = $value["name"];
                $biography[$i]["bio"] = $page[0]["extract"];
                    #$biography["bio"] = $directorData["query"]["pages"][""];
                // }
            }

            $i++;
        }
        return $biography;
    }

    /**
     * Fetches and parses a list of director biography from wikipedia api.
     * 
     * @return array containing some information about biography. 
     */
    function getNameDirectorInfo($directorName, $input_page_number, $input_per_page) {
        $biography = Array();
        $director = new DirectorModel();
        $director->setPaginationOptions($input_page_number, $input_per_page);
        $names = $director->getWhereLikeName($directorName);
        $i = 0;
        foreach($names["data"] as $value) {
            $name = $value["name"];
            $resource_uri = "https://en.wikipedia.org/w/api.php?action=query&format=json&titles=${name}&prop=extracts&exintro=True&explaintext=True";
            $directorData = $this->invoke($resource_uri);

            if (!empty($directorData)) {
                // Parse the fetched list of books.   
                $directorData = json_decode($directorData, true);
                //var_dump($directorData);exit;

                // Parse the list of books and retreive some  
                // of the contained information.
                
                // foreach ($directorData as $key => $director) {
                $page = array_values($directorData['query']['pages']);
                    #var_dump($page[0]["extract"]);
                $biography[$i]["name"] = $value["name"];
                $biography[$i]["bio"] = $page[0]["extract"];
                    #$biography["bio"] = $directorData["query"]["pages"][""];
                // }
            }

            $i++;
        }
        return $biography;
    }

    /**
     * Fetches and parses a list of director biography from wikipedia api.
     * 
     * @return array containing some information about biography. 
     */
    function getIdDirectorInfo($director_id) {
        $biography = Array();
        $director = new DirectorModel();
        $names = $director->getDirectorNameById($director_id);
        $i = 0;
        foreach($names["data"] as $value) {
            $name = $value["name"];
            $resource_uri = "https://en.wikipedia.org/w/api.php?action=query&format=json&titles=${name}&prop=extracts&exintro=True&explaintext=True";
            $directorData = $this->invoke($resource_uri);

            if (!empty($directorData)) {
                // Parse the fetched list of books.   
                $directorData = json_decode($directorData, true);
                //var_dump($directorData);exit;

                // Parse the list of books and retreive some  
                // of the contained information.
                
                // foreach ($directorData as $key => $director) {
                $page = array_values($directorData['query']['pages']);
                    #var_dump($page[0]["extract"]);
                $biography[$i]["name"] = $value["name"];
                $biography[$i]["bio"] = $page[0]["extract"];
                    #$biography["bio"] = $directorData["query"]["pages"][""];
                // }
            }

            $i++;
        }
        return $biography;
    }

}
