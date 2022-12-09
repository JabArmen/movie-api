<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/CharacterModel.php';

// Callback for HTTP GET /characters
//-- Supported filtering operation: by character name.

//create character handler
function handleCreateCharacter(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $character_model = new CharacterModel();
    $data_string = "Successfully Created Character";
    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }
    foreach ($data as $key => $value) {
        $data_single = $value;
        $new_character_record = array(
            "character_id" => $data_single["character_id"],
            'name' => $data_single['name'],
            'appearsIn' => $data_single['appearsIn'],
            'type' => $data_single['type'],
            'actor_id' => $data_single['actor_id']
        );
        try{
            $character_model->createCharacter($new_character_record);
        }
        catch (Exception $e){
            $response_data = makeCustomJSONSuccess("500", "This resource already exists (may be a primary key)");
            $response->getBody()->write($response_data);
            return $response;
        }
    }

    $response_data = makeCustomJSONSuccess("201", "Succesfully created resource");
    $response->getBody()->write($response_data);
    return $response;
}

//handles updating a specficic character
function handleUpdateCharacter(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $response_code = HTTP_OK;
    $character_model = new CharacterModel();
    $data_string = "";

    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }

    foreach ($data as $key => $value) {
        $data_single = $value;
        $updated_character_id = array(
            "character_id" => $data_single["character_id"]
        );
        $updated_character_data = array(
            'name' => $data_single['name'],
            'appearsIn' => $data_single['appearsIn'],
            'type' => $data_single['type'],
            'actor_id' => $data_single['actor_id']
        );
        $data_string .= "Succesful Put Request:  " . $data_single["character_id"] . " -> " . $data_single["name"] . "\n";
        $character_model->updateCharacter($updated_character_data, $updated_character_id);
    }
    $response_data = makeCustomJSONSuccess("202", $data_string);
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles deleting a specficic character
function handleDeleteCharacter(Request $request, Response $response, array $args)
{
    $response_data = array();
    $response_code = 202;
    $character_model = new CharacterModel();
    $character_id = $args['character_id'];

    if(!$character_model->getCharacterById($args['character_id'])['data']){
        $response_data = makeCustomJSONError("resourceNotFound", "Wrong ID used");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }
    $character_model->deleteCharacter($character_id);
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
//handles getting all characters
//accepts a parameter of name
function handleGetAllCharacters(Request $request, Response $response, array $args)
{
    $table = 'characters';
    $table = 'characters';
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
    $characters = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $character_model = new CharacterModel();
    $base_model = new BaseModel();
    $isFiltered = false;
    $character_model->setPaginationOptions($input_page_number, $input_per_page);
    $filter_params = $request->getQueryParams();
    $sql = null;
    // Fetch the list of artists matching the provided name.

    try {
        foreach ($filter_params as $param => $val) {
            if ($param == "page" || $param == "per_page") {
            } else {
                if ($sql != null) {
                    $sql .= ' AND ' . $param . ' LIKE "' . $val . '"';
                } else
                    $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $param . ' LIKE "' . $val . '"';
                $isFiltered = true;
            }
        }
        // No filtering by artist name detected.
        if (!$isFiltered) {
            $characters = $character_model->getAll();
        } else {
            $characters = $base_model->paginate($sql);
        }
    } catch (PDOException $e) {
        // No matches found?
        $response_data = makeCustomJSONError("resourceNotFound", "Wrong filters used on this table");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }

    unset($filter_params);
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($characters, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles getting an character by their id
function handleGetCharacterById(Request $request, Response $response, array $args)
{
    $characters = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $character_model = new CharacterModel();

    $character_id = $args["character_id"];
    if (isset($character_id)) {
        // Fetch the info about the specified character.
        $character_info = $character_model->getCharacterById($character_id);
        if (!$character_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified character.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($character_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
