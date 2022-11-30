<?php

class MovieModel extends BaseModel
{

    private $table_name = "movies";

    /**
     * A model class for the `movies` database table.
     * It exposes operations that can be performed on movies records.
     */
    function __construct()
    {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
    }

    /**
     * Retrieve all movies from the `movies` table.
     * @return array A list of movies. 
     */
    public function getAll()
    {
        $sql = "SELECT * FROM movies";
        $data = $this->paginate($sql);
        return $data;
    }

    /**
     * Get a list of movies whose name matches or contains the provided value.       
     * @param string $movieTitle 
     * @return array An array containing the matches found.
     */
    public function getWhereLike($movieTitle)
    {
        $sql = "SELECT * FROM movies WHERE title LIKE :title";
        $data = $this->paginate($sql, [":title" => $movieTitle . "%"]);
        return $data;
    }
    /**
     * Get a list of movies whose name matches or contains the provided value.       
     * @param string $genre 
     * @return array An array containing the matches found.
     */
    public function getMovieByGenre($genre)
    {
        $sql = "SELECT * FROM movies WHERE genre LIKE :genre";
        $data = $this->run($sql, [":genre" => $genre . "%"])->fetchAll();
        return $data;
    }

    /**
     * Get a list of movies whose name matches or contains the provided value.       
     * @param string $release_date 
     * @return array An array containing the matches found.
     */
    public function getMovieByReleaseDate($release_date)
    {
        $sql = "SELECT * FROM movies WHERE release_date LIKE :release_date";
        $data = $this->run($sql, [":release_date" => $release_date . "%"])->fetchAll();
        return $data;
    }

    /**
     * Get a list of movies whose name matches or contains the provided value.       
     * @param string $movieTitle 
     * @return array An array containing the matches found.
     */
    public function getMovieByBudget($movieBudget)
    {
        $sql = "SELECT * FROM movies WHERE budget LIKE :budget";
        $data = $this->run($sql, [":budget" => $movieBudget . "%"])->fetchAll();
        return $data;
    }



    /**
     * Retrieve a movie by its id.
     * @param int $movie_id the id of the movie.
     * @return array an array containing information about a given movie.
     */
    public function getMovieById($movie_id)
    {
        $sql = "SELECT * FROM movies WHERE movie_id = ?";
        $data = $this->paginate($sql, [$movie_id]);
        return $data;
    }

    /**
     * Retrieve a movie by its director.
     * @param int $director_id the id of the director.
     * @return array an array containing information about a given movie.
     */
    public function getMovieByDirectorId($director_id)
    {
        $sql = "SELECT * FROM movies WHERE director_id = ?";
        $data = $this->paginate($sql, [$director_id]);
        return $data;
    }

    /**
     * Retrieve a movie by director and studio.
     * @param int $director_id the id of the director.
     * @param int $studio_id the id of the studio.
     * @return array an array containing information about a given movie.
     */
    public function getMovieByDirectorAndStudio($director_id, $studio_id)
    {
        $sql = "SELECT * FROM movies WHERE director_id = ? AND studio_id = ?";
        $data = $this->paginate($sql, [$director_id, $studio_id]);
        return $data;
    }

    /**
     * create a Movie
     * @param array $data an array containing information about a given movie.
     * @return boolean if the insert was successful.
     */
    public function createMovie($data)
    {
        $data = $this->insert($this->table_name, $data);
        return $data;
    }

    /**
     * update an movie
     * @param array $data an array containing info about the movie
     * @param int $id of the movie
     * @return boolean if the update was successful
     */
    public function updateMovie($data, $id)
    {
        $data = $this->update($this->table_name, $data, $id);
        return $data;
    }

    /**
     * delete an movie
     * @param int $movie_id
     * @return boolean if success
     */
    public function deleteMovie($movie_id)
    {
        $sql = "DELETE FROM movies WHERE movie_id = ?;";
        $data = $this->run($sql, [$movie_id])->fetchAll();
        return $data;
    }
}
