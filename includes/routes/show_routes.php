<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/ShowModel.php';
require_once __DIR__ . './../controllers/showController.php';


// Callback for HTTP GET /shows
//-- Supported filtering operation: by show name.

//create show handler
function handleCreateShow(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $show_model = new ShowModel();
    $data_string = "Successfully Created Show";
    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }
    foreach ($data as $key => $value) {
        $data_single = $value;
        $new_show_record = array(
            "show_id" => $data_single["show_id"],
            'title' => $data_single['title'],
            'release_date' => $data_single['release_date'],
            'budget' => $data_single['budget'],
            'genre' => $data_single['genre'],
            'director_id' => $data_single['director_id'],
            'studio_id' => $data_single['studio_id']
        );
        $show_model->createShow($new_show_record);
    }

    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response;
}

//handles updating a specficic show
function handleUpdateShow(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $response_code = HTTP_OK;
    $show_model = new ShowModel();
    $data_string = "";

    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }

    foreach ($data as $key => $value) {
        $data_single = $value;
        $updated_show_id = array(
            "show_id" => $data_single["show_id"]
        );
        $updated_show_data = array(
            'title' => $data_single['title'],
            'release_date' => $data_single['release_date'],
            'budget' => $data_single['budget'],
            'genre' => $data_single['genre'],
            'director_id' => $data_single['director_id'],
            'studio_id' => $data_single['studio_id']
        );
        $data_string .= "Succesful Put Request:  " . $data_single["show_id"] . " -> " . $data_single["title"] . "\n";
        $show_model->updateShow($updated_show_data, $updated_show_id);
    }
    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response->withStatus($response_code);
}

//handles deleting a specficic show
function handleDeleteShow(Request $request, Response $response, array $args)
{
    $response_data = array();
    $response_code = 202;
    $show_model = new ShowModel();
    $show_id = $args['show_id'];

    if(!$show_model->getShowById($args['show_id'])['data']){
        $response_data = makeCustomJSONError("resourceNotFound", "Wrong ID used");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }
    $show_model->deleteShow($show_id);
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = makeCustomJSONSuccess("202", "Successfully deleted resource");
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
//handles getting all shows
//accepts a parameter of name
function handleGetAllShows(Request $request, Response $response, array $args)
{
    //new
    $table = "shows";
    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    //new
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);
    if ($input_page_number == null) {
        $input_page_number = 1;
    }
    if ($input_per_page == null) {
        $input_per_page = 10;
    }
    $shows_and_summary = array();
    $showComposite = new showController();
    $shows = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $show_model = new ShowModel();
    $filter_params = $request->getQueryParams();
    $isFiltered = false;
    $show_model->setPaginationOptions($input_page_number, $input_per_page);
    $base_model = new BaseModel();

    $filter_params = $request->getQueryParams();
    $sql = null;
    // Fetch the list of artists matching the provided name.
    try {
        foreach ($filter_params as $param => $val) {
            if ($param == "page" || $param == "per_page")
                break;
            if ($sql != null) {
                $sql .= ' AND ' . $param . ' LIKE "' . $val . '"';
            } else
                $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $param . ' LIKE "' . $val . '"';
            $isFiltered = true;
        }
        // No filtering by artist name detected.
        if (!$isFiltered) {
            $shows = $show_model->getAll();
            $summary = $showComposite->getAllShowInfo($input_page_number, $input_per_page);
        } else {
            $shows = $base_model->paginate($sql);
            $summary = $showComposite->getAllShowInfoWithData($input_page_number, $input_per_page, $shows);
        }
        unset($filter_params);
    } catch (PDOException $e) {
        // No matches found?
        $response_data = makeCustomJSONError("resourceNotFound", "Wrong filters used on this table.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }
    unset($filter_params);

    $shows_and_summary["shows"] = $shows;
    $i = 0;
    foreach ($shows["data"] as $key => $data) {
        if ($data["title"] == $summary[$i]["title"]) {
            // var_dump($bio[$i]["name"]);
            $shows_and_summary["shows"]["data"][$i]["summary"] = $summary[$i]["sum"];
        }
        $i++;
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($i == 0) {
        // No matches found?
        $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified show.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($shows_and_summary, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles getting an show by their id
function handleGetShowById(Request $request, Response $response, array $args)
{
    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    //new
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);
    if ($input_page_number == null) {
        $input_page_number = 1;
    }
    if ($input_per_page == null) {
        $input_per_page = 10;
    }
    $shows = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $show_model = new ShowModel();

    $show_model->setPaginationOptions($input_page_number, $input_per_page);


    $show_id = $args["show_id"];
    if (isset($show_id)) {
        // Fetch the info about the specified show.
        $show_info = $show_model->getShowById($show_id);
        if (!$show_info['data']) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified show.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($show_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles getting a show by their directorid or studio
function handleGetShowByRequestId(Request $request, Response $response, array $args)
{
    //new
    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    //new
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);
    if ($input_page_number == null) {
        $input_page_number = 1;
    }
    if ($input_per_page == null) {
        $input_per_page = 10;
    }
    $movies = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $show_model = new ShowModel();
    $is_director = false;
    $show_model->setPaginationOptions($input_page_number, $input_per_page);
    if (isset($args["director_id"])) {
        $request_id = $args["director_id"];
        $is_director = true;
    } else
        $request_id = $args["studio_id"];
    if (isset($request_id)) {
        // Fetch the info about the specified movie.
        if ($is_director)
            $movie_info = $show_model->getShowByDirectorId($request_id);
        else
            $movie_info = $show_model->getShowByStudioId($request_id);
        if ($movie_info['data'] == null) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified movie.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($movie_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
