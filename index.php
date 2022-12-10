<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require_once './includes/app_constants.php';
require_once './includes/helpers/helper_functions.php';
require_once './includes/helpers/Paginator.php';
require_once './includes/helpers/composite.php';
require_once './includes/helpers/JWTManager.php';

define('APP_BASE_DIR', __DIR__);
// IMPORTANT: This file must be added to your .ignore file. 
define('APP_ENV_CONFIG', 'config.env');

//--Step 1) Instantiate App.
$app = AppFactory::create();
//-- Step 2) Add routing middleware.
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
//-- Step 3) Add error handling middleware.
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
//-- Step 4)
// TODO: change the name of the sub directory here. You also need to change it in .htaccess
$app->setBasePath("/movie-api");

$jwt_secret = JWTManager::getSecretKey();
$api_base_path = "/movie-api";
$app->add(new Tuupola\Middleware\JwtAuthentication([
    'secret' => $jwt_secret,
    'algorithm' => 'HS256',
    'secure' => false, // only for localhost for prod and test env set true            
    "path" => $api_base_path, // the base path of the API
    "attribute" => "decoded_token_data",
    "ignore" => ["$api_base_path/token", "$api_base_path/account"],
    "error" => function ($response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        $response->getBody()->write(
            json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
        );
        return $response->withHeader("Content-Type", "application/json;charset=utf-8");
    }
]));


//-- Step 5) Include the files containing the definitions of the callbacks.
require_once './includes/routes/movie_routes.php';
require_once './includes/routes/actor_routes.php';
require_once './includes/routes/character_routes.php';
require_once './includes/routes/director_routes.php';
require_once './includes/routes/review_routes.php';
require_once './includes/routes/show_routes.php';
require_once './includes/routes/studio_routes.php';
require_once './includes/routes/token_routes.php';

// Routes for user account, loggin in and token generation.
$app->post("/token", "handleGetToken");
$app->post("/account", "handleCreateUserAccount");
//-- Step 6)
// movie 
$app->get("/movies", "handleGetAllMovies");
$app->get("/movies/{movie_id}", "handleGetMovieById");
$app->get("/directors/{director_id}/movies", "handleGetMovieByRequestId");
$app->get("/studios/{studio_id}/movies", "handleGetMovieByRequestId");


$app->delete("/movies/{movie_id}", "handleDeleteMovie");

$app->post("/movies", "handleCreateMovie");

$app->put("/movies", "handleUpdateMovie");

//actor requests
$app->get("/actors", "handleGetAllActors");
$app->get("/actors/{actor_id}", "handleGetActorById");

$app->delete("/actors/{actor_id}", "handleDeleteActor");

$app->post("/actors", "handleCreateActor");

$app->put("/actors", "handleUpdateActor");

//character requests
$app->get("/characters", "handleGetAllCharacters");
$app->get("/characters/{character_id}", "handleGetCharacterById");

$app->delete("/characters/{character_id}", "handleDeleteCharacter");

$app->post("/characters", "handleCreateCharacter");

$app->put("/characters", "handleUpdateCharacter");

//director requests
$app->get("/directors", "handleGetAllDirectors");
$app->get("/directors/{director_id}", "handleGetDirectorById");

$app->delete("/directors/{director_id}", "handleDeleteDirector");

$app->post("/directors", "handleCreateDirector");

$app->put("/directors", "handleUpdateDirector");

//review requests
$app->get("/reviews", "handleGetAllReviews");
$app->get("/reviews/{review_id}", "handleGetReviewById");

$app->delete("/reviews/{review_id}", "handleDeleteReview");

$app->post("/reviews", "handleCreateReview");

$app->put("/reviews", "handleUpdateReview");

//show requests
$app->get("/shows", "handleGetAllShows");
$app->get("/shows/{show_id}", "handleGetShowById");
$app->get("/directors/{director_id}/shows", "handleGetShowByRequestId");
$app->get("/studios/{studio_id}/shows", "handleGetShowByRequestId");

$app->delete("/shows/{show_id}", "handleDeleteShow");

$app->post("/shows", "handleCreateShow");

$app->put("/shows", "handleUpdateShow");

//studio requests
$app->get("/studios", "handleGetAllStudios");
$app->get("/studios/{studio_id}", "handleGetStudioById");

$app->delete("/studios/{studio_id}", "handleDeleteStudio");

$app->post("/studios", "handleCreateStudio");

$app->put("/studios", "handleUpdateStudio");

// Run the app.
$app->run();
