<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/StudioModel.php';

// Callback for HTTP GET /studios
//-- Supported filtering operation: by studio name.

//create studio handler
function handleCreateStudio(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $studio_model = new StudioModel();
    $data_string = "Successfully Created Studio";
    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }
    foreach ($data as $key => $value) {
        $data_single = $value;
        $new_studio_record = array(
            "studio_id" => $data_single["studio_id"],
            'name' => $data_single['name'],
            'address' => $data_single['address'],
            'country' => $data_single['country'],
        );
        $studio_model->createStudio($new_studio_record);
    }

    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response;
}

//handles updating a specficic studio
function handleUpdateStudio(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();
    $data_string = "";

    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }

    foreach ($data as $key => $value) {
        $data_single = $value;
        $updated_studio_id = array(
            "studio_id" => $data_single["studio_id"]
        );
        $updated_studio_data = array(
            'name' => $data_single['name'],
            'address' => $data_single['address'],
            'country' => $data_single['country'],
        );
        $data_string .= "Succesful Put Request:  " . $data_single["studio_id"] . " -> " . $data_single["name"] . "\n";
        $studio_model->updateStudio($updated_studio_data, $updated_studio_id);
    }
    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response->withStatus($response_code);
}

//handles deleting a specficic studio
function handleDeleteStudio(Request $request, Response $response, array $args)
{
    $response_data = array();
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();
    $studio_id = $args['studio_id'];

    $studio_model->deleteStudio($studio_id);
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($studio_model->getAll(), JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
//handles getting all studios
//accepts a parameter of name
function handleGetAllStudios(Request $request, Response $response, array $args)
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
    $isFiltered = false;
    $studios = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();
    $filter_params = $request->getQueryParams();
    $studio_model->setPaginationOptions($input_page_number, $input_per_page);
    if (isset($filter_params['name'])) {
        $studios = $studio_model->getWhereLike($filter_params['name']);
        $isFiltered = true;
    }
    if (isset($filter_params['country'])) {
        $studios = $studio_model->getDirectorByCountry($filter_params['country']);
        $isFiltered = true;
    }
    if ($isFiltered == false)
        $studios = $studio_model->getAll();
    unset($filter_params);
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($studios, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles getting an studio by their id
function handleGetStudioById(Request $request, Response $response, array $args)
{
    $studios = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();

    $studio_id = $args["studio_id"];
    if (isset($studio_id)) {
        // Fetch the info about the specified studio.
        $studio_info = $studio_model->getStudioById($studio_id);
        if (!$studio_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified studio.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($studio_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
