<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/ReviewModel.php';

// Callback for HTTP GET /reviews
//-- Supported filtering operation: by review name.

//create review handler
function handleCreateReview(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $review_model = new ReviewModel();
    $data_string = "Successfully Created Review";
    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }
    foreach ($data as $key => $value) {
        $data_single = $value;
        $new_review_record = array(
            "review_id" => $data_single["review_id"],
            'username' => $data_single['username'],
            'stars' => $data_single['stars'],
            'review_description' => $data_single['review_description'],
            'movie_id' => $data_single['movie_id'],
            'show_id' => $data_single['show_id']

        );
        try{
            $review_model->createReview($new_review_record);
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

//handles updating a specficic review
function handleUpdateReview(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $response_code = HTTP_OK;
    $review_model = new ReviewModel();
    $data_string = "";

    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }

    foreach ($data as $key => $value) {
        $data_single = $value;
        $updated_review_id = array(
            "review_id" => $data_single["review_id"]
        );
        $updated_review_data = array(
            'username' => $data_single['username'],
            'stars' => $data_single['stars'],
            'review_description' => $data_single['review_description'],
            'movie_id' => $data_single['movie_id'],
            'show_id' => $data_single['show_id']
        );
        $data_string .= "Succesful Put Request:  " . $data_single["review_id"] . " -> " . $data_single["username"] . "\n";
        $review_model->updateReview($updated_review_data, $updated_review_id);
    }
    $response_data = makeCustomJSONSuccess("202", $data_string);
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles deleting a specficic review
function handleDeleteReview(Request $request, Response $response, array $args)
{
    $response_data = array();
    $response_code = 202;
    $review_model = new ReviewModel();
    $review_id = $args['review_id'];

    if(!$review_model->getReviewById($args['review_id'])['data']){
        $response_data = makeCustomJSONError("resourceNotFound", "Wrong ID used");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }
    $review_model->deleteReview($review_id);
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
//handles getting all reviews
//accepts a parameter of name
function handleGetAllReviews(Request $request, Response $response, array $args)
{
    //new
    $table = 'reviews';
    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    //new
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);
    if ($input_page_number == null) {
        $input_page_number = 1;
    }
    if ($input_per_page == null) {
        $input_per_page = 10;
    }
    $reviews = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $review_model = new ReviewModel();
    $base_model = new BaseModel();

    $review_model->setPaginationOptions($input_page_number, $input_per_page);
    $filter_params = $request->getQueryParams();
    $isFiltered = false;
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
            $reviews = $review_model->getAll();
        } else {
            $reviews = $base_model->paginate($sql);
        }
    } catch (PDOException $e) {
        // No matches found?
        $response_data = makeCustomJSONError("resourceNotFound", "Wrong filters used on this table");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }

    unset($filter_params);
    if (!$reviews['data']){
        $response_data = makeCustomJSONError("resourceNotFound", "No reviews in databse");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($reviews, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles getting an review by their id
function handleGetReviewById(Request $request, Response $response, array $args)
{
    $reviews = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $review_model = new ReviewModel();

    $review_id = $args["review_id"];
    if (isset($review_id)) {
        // Fetch the info about the specified review.
        $review_info = $review_model->getReviewById($review_id);
        if (!$review_info['data']) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified review.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($review_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
