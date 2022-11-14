<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require_once './includes/app_constants.php';
require_once './includes/helpers/helper_functions.php';

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

//-- Step 5) Include the files containing the definitions of the callbacks.
require_once './includes/routes/movie_routes.php';
require_once './includes/routes/actor_routes.php';
require_once './includes/routes/character_routes.php';
require_once './includes/routes/director_routes.php';
require_once './includes/routes/review_routes.php';
require_once './includes/routes/show_routes.php';
require_once './includes/routes/studio_routes.php';

//-- Step 6)
// movie requests
$app->get("/movies", "handleGetAllMovies");
$app->get("/movies/{movie_id}", "handleGetMovieById");

$app->delete("/movies/{movie_id}","handleDeleteMovie");

$app->post("/movies", "handleCreateMovie");

$app->put("/movies", "handleUpdateMovie");

//actor requests
$app->get("/actors", "handleGetAllActors");
$app->get("/actors/{actor_id}", "handleGetActorById");

$app->delete("/actors/{actor_id}","handleDeleteActor");

$app->post("/actors", "handleCreateActor");

$app->put("/actors", "handleUpdateActor");

//character requests
$app->get("/characters", "handleGetAllCharacters");
$app->get("/characters/{character_id}", "handleGetCharacterById");

$app->delete("/characters/{character_id}","handleDeleteCharacter");

$app->post("/characters", "handleCreateCharacter");

$app->put("/characters", "handleUpdateCharacter");

//director requests
$app->get("/directors", "handleGetAllDirectors");
$app->get("/directors/{director_id}", "handleGetDirectorById");

$app->delete("/directors/{director_id}","handleDeleteDirector");

$app->post("/directors", "handleCreateDirector");

$app->put("/directors", "handleUpdateDirector");

//review requests
$app->get("/reviews", "handleGetAllReviews");
$app->get("/reviews/{review_id}", "handleGetReviewById");

$app->delete("/reviews/{review_id}","handleDeleteReview");

$app->post("/reviews", "handleCreateReview");

$app->put("/reviews", "handleUpdateReview");

//show requests
$app->get("/shows", "handleGetAllShows");
$app->get("/shows/{show_id}", "handleGetShowById");

$app->delete("/shows/{show_id}","handleDeleteShow");

$app->post("/shows", "handleCreateShow");

$app->put("/shows", "handleUpdateShow");

//studio requests
$app->get("/studios", "handleGetAllStudios");
$app->get("/studios/{studio_id}", "handleGetStudioById");

$app->delete("/studios/{studio_id}","handleDeleteStudio");

$app->post("/studios", "handleCreateStudio");

$app->put("/studios", "handleUpdateStudio");

// Run the app.
$app->run();
