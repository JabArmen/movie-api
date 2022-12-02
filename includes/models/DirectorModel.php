<?php

class DirectorModel extends BaseModel
{

    private $table_name = "directors";

    /**
     * A model class for the `directors` database table.
     * It exposes operations that can be performed on directors records.
     */
    function __construct()
    {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
    }

    /**
     * Retrieve all directors from the `directors` table.
     * @return array A list of directors. 
     */
    public function getAll()
    {
        $sql = "SELECT * FROM directors";
        $data = $this->paginate($sql);
        return $data;
    }

    /**
     * Get a list of directorss whose name matches or contains the provided value.       
     * @param string $directorTitle 
     * @return array An array containing the matches found.
     */
    public function getWhereLike($directorName)
    {
        $sql = "SELECT * FROM directors WHERE Name LIKE :name";
        $data = $this->paginate($sql, [":name" => $directorName . "%"]);
        return $data;
    }

    /**
     * Retrieve a director by its id.
     * @param int $director_id the id of the director.
     * @return array an array containing information about a given director.
     */
    public function getDirectorById($director_id)
    {
        $sql = "SELECT * FROM directors WHERE director_id = ?";
        $data = $this->paginate($sql, [$director_id]);
        return $data;
    }

    public function getDirectorByCountry($country)
    {
        $sql = "SELECT * FROM directors WHERE country = ?";
        $data = $this->paginate($sql, [$country]);
        return $data;
    }

    public function counter()
    {
        $sql = "SELECT count(director_id) FROM directors";
        $data = $this->rows($sql);
        return $data;
    }
    // /**
    //  * Retrieve a movie by its director.
    //  * @param int $director_id the id of the director.
    //  * @return array an array containing information about a given movie.
    //  */
    // public function getMovieByDirectorId($director_id)
    // {
    //     $sql = "SELECT * FROM movies WHERE director_id = ?";
    //     $data = $this->run($sql, [$director_id])->fetchAll();
    //     return $data;
    // }

    // /**
    //  * Retrieve a movie by director and studio.
    //  * @param int $director_id the id of the director.
    //  * @param int $studio_id the id of the studio.
    //  * @return array an array containing information about a given movie.
    //  */
    // public function getMovieByDirectorAndStudio($director_id, $studio_id)
    // {
    //     $sql = "SELECT * FROM movies WHERE director_id = ? AND studio_id = ?";
    //     $data = $this->run($sql, [$director_id, $studio_id])->fetchAll();
    //     return $data;
    // }

    /**
     * create a Director
     * @param array $data an array containing information about a given director.
     * @return boolean if the insert was successful.
     */
    public function createDirector($data)
    {
        $data = $this->insert($this->table_name, $data);
        return $data;
    }

    /**
     * update an director
     * @param array $data an array containing info about the director
     * @param int $id of the director
     * @return boolean if the update was successful
     */
    public function updateDirector($data, $id)
    {
        $data = $this->update($this->table_name, $data, $id);
        return $data;
    }

    /**
     * delete an director
     * @param int $director_id
     * @return boolean if success
     */
    public function deleteDirector($director_id)
    {
        $sql = "DELETE FROM directors WHERE director_id = ?;";
        $data = $this->run($sql, [$director_id])->fetchAll();
        return $data;
    }
}
