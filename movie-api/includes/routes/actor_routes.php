<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/ActorModel.php';

// Callback for HTTP GET /actors
//-- Supported filtering operation: by actor name.

//create actor handler
function handleCreateActor(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $actor_model = new ActorModel();
    $data_string = "Successfully Created Actor";
    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }
    foreach ($data as $key => $value) {
        $data_single = $value;
        $new_actor_record = array(
            "actor_id" => $data_single["actor_id"],
            'name' => $data_single['name'],
            'biography' => $data_single['biography'],
            'country' => $data_single['country']
        );
        $actor_model->createActor($new_actor_record);
    }

    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response;
}

//handles updating a specficic actor
function handleUpdateActor(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $response_code = HTTP_OK;
    $actor_model = new ActorModel();
    $data_string = "";

    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }

    foreach ($data as $key => $value) {
        $data_single = $value;
        $updated_actor_id = array(
            "actor_id" => $data_single["actor_id"]
        );
        $updated_actor_data = array(
            'name' => $data_single['name'],
            'biography' => $data_single['biography'],
            'country' => $data_single['country']
        );
        $data_string .= "Succesful Put Request:  " . $data_single["actor_id"] . " -> " . $data_single["name"] . "\n";
        $actor_model->updateActor($updated_actor_data, $updated_actor_id);
    }
    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response->withStatus($response_code);
}

//handles deleting a specficic actor
function handleDeleteActor(Request $request, Response $response, array $args)
{
    $response_data = array();
    $response_code = HTTP_OK;
    $actor_model = new ActorModel();
    $actor_id = $args['actor_id'];

    $actor_model->deleteactor($actor_id);
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($actor_model->getAll(), JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
//handles getting all actors
//accepts a parameter of name
function handleGetAllActors(Request $request, Response $response, array $args)
{
    $actors = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $actor_model = new ActorModel();

    $actors = $actor_model->getAll();
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($actors, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles getting an actor by their id
function handleGetActorById(Request $request, Response $response, array $args)
{
    $actors = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $actor_model = new ActorModel();

    $actor_id = $args["actor_id"];
    if (isset($actor_id)) {
        // Fetch the info about the specified actor.
        $actor_info = $actor_model->getActorById($actor_id);
        if (!$actor_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified actor.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($actor_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
