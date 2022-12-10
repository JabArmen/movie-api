<?php
require_once __DIR__ . './../helpers/WebServiceInvoker.php';

/**
 * A class for consuming the Ice and Fire API.
 *
 * @author Sleiman Rabah
 */
class showController extends WebServiceInvoker
{

    private $request_options = array(
        'headers' => array('Accept' => 'application/json')
    );

    public function __construct()
    {
        parent::__construct($this->request_options);
    }

    /**
     * Fetches and parses a list of director biography from wikipedia api.
     * 
     * @return array containing some information about biography. 
     */
    function getAllShowInfo($input_page_number, $input_per_page)
    {
        $summary = array();
        $show_model = new ShowModel();
        $show_model->setPaginationOptions($input_page_number, $input_per_page);
        $titles = $show_model->getAllTitles();
        $i = 0;
        foreach ($titles["data"] as $value) {
            $title = $value["title"];
            $resource_uri = "https://api.tvmaze.com/singlesearch/shows?q=${title}";
            $showData = $this->invoke($resource_uri);

            if (!empty($showData)) {
                // Parse the fetched list of books.   
                $showData = json_decode($showData, true);

                // Parse the list of books and retreive some  
                // of the contained information.
                $summary[$i]["title"] = $title;
                $summary[$i]["sum"] = $showData["summary"];
            }

            $i++;
        }
        return $summary;
    }

    /**
     * Fetches and parses a list of director biography from wikipedia api.
     * 
     * @return array containing some information about biography. 
     */
    function getAllShowInfoWithData($input_page_number, $input_per_page, $data)
    {
        $summary = array();
        $show_model = new ShowModel();
        $show_model->setPaginationOptions($input_page_number, $input_per_page);
        $titles = $data;
        $i = 0;
        foreach ($titles["data"] as $value) {
            $title = $value["title"];
            $resource_uri = "https://api.tvmaze.com/singlesearch/shows?q=${title}";
            $showData = $this->invoke($resource_uri);

            if (!empty($showData)) {
                // Parse the fetched list of books.   
                $showData = json_decode($showData, true);

                // Parse the list of books and retreive some  
                // of the contained information.
                $summary[$i]["title"] = $title;
                $summary[$i]["sum"] = $showData["summary"];
            }

            $i++;
        }
        return $summary;
    }

    function getTitleShowInfo($showTitle, $input_page_number, $input_per_page)
    {
        $summary = array();
        $show_model = new ShowModel();
        $show_model->setPaginationOptions($input_page_number, $input_per_page);
        $titles = $show_model->getTitleWhereLike($showTitle);
        $i = 0;
        foreach ($titles["data"] as $value) {
            $title = $value["title"];
            $resource_uri = "https://api.tvmaze.com/singlesearch/shows?q=${title}";
            $showData = $this->invoke($resource_uri);

            if (!empty($showData)) {
                // Parse the fetched list of books.   
                $showData = json_decode($showData, true);

                // Parse the list of books and retreive some  
                // of the contained information.
                $summary[$i]["title"] = $title;
                $summary[$i]["sum"] = $showData["summary"];
            }

            $i++;
        }
        return $summary;
    }

    function getReleaseShowInfo($release_date, $input_page_number, $input_per_page)
    {
        $summary = array();
        $show_model = new ShowModel();
        $show_model->setPaginationOptions($input_page_number, $input_per_page);
        $titles = $show_model->getShowTitleByReleaseDate($release_date);
        $i = 0;
        foreach ($titles["data"] as $value) {
            $title = $value["title"];
            $resource_uri = "https://api.tvmaze.com/singlesearch/shows?q=${title}";
            $showData = $this->invoke($resource_uri);

            if (!empty($showData)) {
                // Parse the fetched list of books.   
                $showData = json_decode($showData, true);

                // Parse the list of books and retreive some  
                // of the contained information.
                $summary[$i]["title"] = $title;
                $summary[$i]["sum"] = $showData["summary"];
            }

            $i++;
        }
        return $summary;
    }

    function getGenreShowInfo($genre, $input_page_number, $input_per_page)
    {
        $summary = array();
        $show_model = new ShowModel();
        $show_model->setPaginationOptions($input_page_number, $input_per_page);
        $titles = $show_model->getShowTitleByGenre($genre);
        $i = 0;
        foreach ($titles["data"] as $value) {
            $title = $value["title"];
            $resource_uri = "https://api.tvmaze.com/singlesearch/shows?q=${title}";
            $showData = $this->invoke($resource_uri);

            if (!empty($showData)) {
                // Parse the fetched list of books.   
                $showData = json_decode($showData, true);

                // Parse the list of books and retreive some  
                // of the contained information.
                $summary[$i]["title"] = $title;
                $summary[$i]["sum"] = $showData["summary"];
            }

            $i++;
        }
        return $summary;
    }


    /**
     * Fetches and parses a list of director biography from wikipedia api.
     * 
     * @return array containing some information about biography. 
     */
    function getIdDirectorInfo($director_id)
    {
        $biography = array();
        $director = new DirectorModel();
        $names = $director->getDirectorNameById($director_id);
        $i = 0;
        foreach ($names["data"] as $value) {
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
