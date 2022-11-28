<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/DirectorModel.php';

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

//handles updating a specficic director
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
        $data_string .= "Succesful Put Request:  " . $data_single["director_id"] . " -> " . $data_single["name"] . "\n";
        $director_model->updateDirector($updated_director_data, $updated_director_id);
    }
    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response->withStatus($response_code);
}

//handles deleting a specficic director
function handleDeleteDirector(Request $request, Response $response, array $args)
{
    $response_data = array();
    $response_code = HTTP_OK;
    $director_model = new DirectorModel();
    $director_id = $args['director_id'];

    $director_model->deleteDirector($director_id);
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($director_model->getAll(), JSON_INVALID_UTF8_SUBSTITUTE);
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
    $directors = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $director_model = new DirectorModel();
    $filter_params = $request->getQueryParams();

    $directors = $director_model->getAll();
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($directors, JSON_INVALID_UTF8_SUBSTITUTE);
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

    $director_id = $args["director_id"];
    if (isset($director_id)) {
        // Fetch the info about the specified director.
        $director_info = $director_model->getDirectorById($director_id);
        if (!$director_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified director.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($director_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
