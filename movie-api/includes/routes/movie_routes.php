<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/MovieModel.php';

// Callback for HTTP GET /movies
//-- Supported filtering operation: by movie name.

//create movie handler
function handleCreateMovie(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $movie_model = new MovieModel();
    $data_string = "Successfully Created Movie";
    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }
    foreach ($data as $key => $value) {
        $data_single = $value;
        $new_movie_record = array(
            "movie_id" => $data_single["movie_id"],
            'title' => $data_single['title'],
            'poster' => $data_single['poster'],
            'release_date' => $data_single['release_date'],
            'budget' => $data_single['budget'],
            'genre' => $data_single['genre'],
            'director_id' => $data_single['director_id'],
            'studio_id' => $data_single['studio_id']
        );
        $movie_model->createMovie($new_movie_record);
    }

    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response;
}

//handles updating a specficic movie
function handleUpdateMovie(Request $request, Response $response, array $args)
{
    $data = $request->getParsedBody();
    $response_code = HTTP_OK;
    $movie_model = new MovieModel();
    $data_string = "";

    if ($data == null) {
        $response_data = makeCustomJSONError("405", "Invalid Values");
        $response_code = HTTP_METHOD_NOT_ALLOWED;
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }

    foreach ($data as $key => $value) {
        $data_single = $value;
        $updated_movie_id = array(
            "movie_id" => $data_single["movie_id"]
        );
        $updated_movie_data = array(
            'title' => $data_single['title'],
            'poster' => $data_single['poster'],
            'release_date' => $data_single['release_date'],
            'budget' => $data_single['budget'],
            'genre' => $data_single['genre'],
            'director_id' => $data_single['director_id'],
            'studio_id' => $data_single['studio_id']
        );
        $data_string .= "Succesful Put Request:  " . $data_single["movie_id"] . " -> " . $data_single["title"] . "\n";
        $movie_model->updateMovie($updated_movie_data, $updated_movie_id);
    }
    $html = var_export($data_string, true);
    $response->getBody()->write($html);
    return $response->withStatus($response_code);
}

//handles deleting a specficic movie
function handleDeleteMovie(Request $request, Response $response, array $args)
{
    $response_data = array();
    $response_code = HTTP_OK;
    $movie_model = new MovieModel();
    $movie_id = $args['movie_id'];

    $movie_model->deleteMovie($movie_id);
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($movie_model->getAll(), JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
//handles getting all movies
//accepts a parameter of name
function handleGetAllMovies(Request $request, Response $response, array $args)
{
    //new
    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    //new
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);
    $movies = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $movie_model = new MovieModel();
<<<<<<< Updated upstream
    $filter_params = $request->getQueryParams();
    if ($filter_params) {
        // Fetch the list of artists matching the provided name.
        if (isset($filter_params['title']))
            $movies = $movie_model->getWhereLike($filter_params["title"]);
        if (isset($filter_params['budget']))
            $movies = $movie_model->getMovieByBudget($filter_params["budget"]);
        if (isset($filter_params['release_date']))
            $movies = $movie_model->getMovieByReleaseDate($filter_params["release_date"]);
        if (isset($filter_params['genre']))
            $movies = $movie_model->getMovieByGenre($filter_params["genre"]);
    } else {
        // No filtering by artist name detected.
        $movies = $movie_model->getAll();
    }
=======
    //new
    $movie_model->setPaginationOptions($input_page_number, $input_per_page);

    $movies = $movie_model->getAll();
>>>>>>> Stashed changes
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    //--
    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($movies, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//handles getting an movie by their id
function handleGetMovieById(Request $request, Response $response, array $args)
{
    //new
    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    //new
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);
    $movies = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $movie_model = new MovieModel();

    $movie_model->setPaginationOptions($input_page_number, $input_per_page);

    $movie_id = $args["movie_id"];
    if (isset($movie_id)) {
        // Fetch the info about the specified movie.
        $movie_info = $movie_model->getMovieById($movie_id);
        if (!$movie_info) {
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
