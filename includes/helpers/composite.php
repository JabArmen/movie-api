<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/MovieModel.php';
require_once __DIR__ . './../models/ShowModel.php';
require_once __DIR__ . './../models/StudioModel.php';
require_once __DIR__ . './../models/DirectorModel.php';

use GuzzleHttp\Client;

// $movie_model = new MovieModel();
// $show_model = new ShowModel();


// if (count($movie_model->getAll()['data']) == 0) {
//     $client = new GuzzleHttp\Client();

//     $max = 550 + 16;
//     $y = 0;
//     for ($i = 550; $i < $max; $i++) {
//         try {
//             $y++;
//             $uri_api = "https://api.themoviedb.org/3/movie/" . $i . "%7Bmovie_id%7D?api_key=3d95b2e2eb80aade533ec63b88c8f998&language=en-US";
//             $response = $client->get($uri_api);
//             $data = $response->getBody()->getContents();
//             $movie = json_decode($data, true);

//             $new_movie = array(
//                 "movie_id" => $i,
//                 "title" => $movie["original_title"],
//                 "poster" => $movie["poster_path"],
//                 "release_date" => $movie["release_date"],
//                 "budget" => $movie["budget"],
//                 "release_date" => $movie["release_date"],
//                 "genre" => $movie["genres"][0]["name"],
//                 "director_id" => $y,
//                 "studio_id" => $y
//             );

//             $movie_model->createMovie($new_movie);
//         } catch (Exception $e) {
//             $max++;
//         }
//     }
// }

// if (count($show_model->getAll()['data']) == 0) {
//     $client = new GuzzleHttp\Client();
//     $uri_api = "https://api.tvmaze.com/shows";
//     $response = $client->get($uri_api);
//     $data = $response->getBody()->getContents();
//     $shows = json_decode($data, true);
//     $y = 1;
//     foreach($shows as $key => $value) {
//         $new_show = array(
//             "show_id" => $value["id"],
//             "title" => $value["name"],
//             "release_date" => $value["premiered"],
//             "end_date" => $value["ended"],
//             "genre" => $value["genres"][0],
//             "network" => $value["network"]["name"],
//             "image" => $value["image"]["original"],
//             "director_id" => $y,
//             "studio_id" => $y
//         );

//         if ($y > 15) {
//             break;
//         }
//         $y++;
//         $show_model->createShow($new_show);
//     }

    
        
    
// }
