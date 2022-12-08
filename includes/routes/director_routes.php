<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/DirectorModel.php';
require_once __DIR__ . './../controllers/wikiApiController.php';


// Callback for HTTP GET /directors
//-- Supported filtering operation: by director name.

//create director handler
function handleCreateDirector(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $director_model = new DirectorModel();
    $data_string = "Successfully Created Director";
    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }
    foreach ($data as $key => $value) {
        $data_single = $value;
        $new_director_record = array(
            "director_id" => $data_single["director_id"],
            'name' => $data_single['name'],
            'biography' => $data_single['biography'],
            'country' => $data_single['country'],
            'image' => $data_single['image']
        );
        $director_model->createDirector($new_director_record);
    }

    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response;
}

//handles updating a specific director
function handleUpdateDirector(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $response_code = HTTP_OK;
    $director_model = new DirectorModel();
    $data_string = "";

    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }

    foreach ($data as $key => $value) {
        $data_single = $value;
        $updated_director_id = array(
            "director_id" => $data_single["director_id"]
        );
        $updated_director_data = array(
            'name' => $data_single['name'],
            'biography' => $data_single['biography'],
            'country' => $data_single['country'],
            'image' => $data_single['image']
        );
        $data_string .= "Successful Put Request:  " . $data_single["director_id"] . " -> " . $data_single["name"] . "\n";
        $director_model->updateDirector($updated_director_data, $updated_director_id);
    }
    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response->withStatus($response_code);
}

//handles deleting a specific director
function handleDeleteDirector(Request $request, Response $response, array $args)
{
    $response_data = array();
    $response_code = 202;
    $director_model = new DirectorModel();
    $director_id = $args['director_id'];

    if(!$director_model->getDirectorById($args['director_id'])['data']){
        $response_data = makeCustomJSONError("resourceNotFound", "Wrong ID used");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }
    $director_model->deleteDirector($director_id);
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
//handles getting all directors
//accepts a parameter of name
function handleGetAllDirectors(Request $request, Response $response, array $args)
{
    //new
    $table = "directors";
    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    //new
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);
    if ($input_page_number == null) {
        $input_page_number = 1;
    }
    if ($input_per_page == null) {
        $input_per_page = 10;
    }
    $directors_and_biography = Array();
    $wiki = new wikiApiController();

    $directors = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $director_model = new DirectorModel();
    $base_model = new BaseModel();
    $director_model->setPaginationOptions($input_page_number, $input_per_page);
    $filter_params = $request->getQueryParams();
    $isFiltered = false;
    $sql = null;
    // Fetch the list of artists matching the provided name.
    try {
        foreach ($filter_params as $param => $val) {
            if ($sql != null) {
                $sql .= ' AND ' . $param . ' LIKE "' . $val . '"';
            } else
                $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $param . ' LIKE "' . $val . '"';
            $isFiltered = true;
        }
        // No filtering by artist name detected.
        if (!$isFiltered) {
            $directors = $director_model->getAll();
            $bio = $wiki->getAllDirectorInfo($input_page_number, $input_per_page);
        } else {
            $directors = $base_model->paginate($sql);
            $bio = $wiki->getAllDirectorInfoWithData($input_page_number, $input_per_page, $directors);
        }
        unset($filter_params);
    } catch (PDOException $e) {
        // No matches found?
        $response_data = makeCustomJSONError("resourceNotFound", "Wrong filters used on this table.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }
    unset($filter_params);

    // $directors_and_biography["biography"] = $bio;
    $directors_and_biography["directors"] = $directors;
    $i = 0;
    foreach ($directors["data"] as $key => $data) {
        if ($param == "page" || $param == "per_page")
                break;
        if ($data["name"] == $bio[$i]["name"]) {
            // var_dump($bio[$i]["name"]);
            $directors_and_biography["directors"]["data"][$i]["biography"] = $bio[$i]["bio"];
        }
        $i++;
    }
    if ($i == 0) {
        // No matches found?
        $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified director.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($directors_and_biography, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles getting an director by their id
function handleGetDirectorById(Request $request, Response $response, array $args)
{
    $directors = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $director_model = new DirectorModel();

    $directors_and_biography = Array();
    $wiki = new wikiApiController();

    $director_id = $args["director_id"];
    if (isset($director_id)) {
        // Fetch the info about the specified director.
        $director_info = $director_model->getDirectorById($director_id);
        $bio = $wiki->getIdDirectorInfo($director_id);
        if (!$director_info['data']) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified director.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    $directors_and_biography["directors"] = $director_info;
    $i = 0;
    foreach ($director_info["data"] as $key => $data) {
        if ($data["name"] == $bio[$i]["name"]) {
            // var_dump($bio[$i]["name"]);
            $directors_and_biography["directors"]["data"][$i]["biography"] = $bio[$i]["bio"];
        }
        $i++;
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($directors_and_biography, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
