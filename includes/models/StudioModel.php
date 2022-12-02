<?php

class StudioModel extends BaseModel
{

    private $table_name = "studios";

    /**
     * A model class for the `studios` database table.
     * It exposes operations that can be performed on studios records.
     */
    function __construct()
    {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
    }

    /**
     * Retrieve all studios from the `studios` table.
     * @return array A list of studios. 
     */
    public function getAll()
    {
        $sql = "SELECT * FROM studios";
        $data = $this->paginate($sql);
        return $data;
    }

    public function counter()
    {
        $sql = "SELECT count(studio_id) FROM studios";
        $data = $this->rows($sql);
        return $data;
    }

    /**
     * Get a list of studioss whose name matches or contains the provided value.       
     * @param string $studioTitle 
     * @return array An array containing the matches found.
     */
    public function getWhereLike($studioName)
    {
        $sql = "SELECT * FROM studios WHERE Name LIKE :name";
        $data = $this->paginate($sql, [":name" => $studioName . "%"]);
        return $data;
    }

    /**
     * Retrieve a studio by its id.
     * @param int $studio_id the id of the studio.
     * @return array an array containing information about a given studio.
     */
    public function getStudioById($studio_id)
    {
        $sql = "SELECT * FROM studios WHERE studio_id = ?";
        $data = $this->paginate($sql, [$studio_id]);
        return $data;
    }

    /**
     * Retrieve a studio by its country.
     * @param string $country the name of the studio.
     * @return array an array containing information about a given studio.
     */
    public function getDirectorByCountry($country)
    {
        $sql = "SELECT * FROM studios WHERE country = ?";
        $data = $this->paginate($sql, [$country]);
        return $data;
    }
    // /**
    //  * Retrieve a movie by its studio.
    //  * @param int $studio_id the id of the studio.
    //  * @return array an array containing information about a given movie.
    //  */
    // public function getMovieByStudioId($studio_id)
    // {
    //     $sql = "SELECT * FROM movies WHERE studio_id = ?";
    //     $data = $this->run($sql, [$studio_id])->fetchAll();
    //     return $data;
    // }

    // /**
    //  * Retrieve a movie by studio and studio.
    //  * @param int $studio_id the id of the studio.
    //  * @param int $studio_id the id of the studio.
    //  * @return array an array containing information about a given movie.
    //  */
    // public function getMovieByStudioAndStudio($studio_id, $studio_id)
    // {
    //     $sql = "SELECT * FROM movies WHERE studio_id = ? AND studio_id = ?";
    //     $data = $this->run($sql, [$studio_id, $studio_id])->fetchAll();
    //     return $data;
    // }

    /**
     * create a Studio
     * @param array $data an array containing information about a given studio.
     * @return boolean if the insert was successful.
     */
    public function createStudio($data)
    {
        $data = $this->insert($this->table_name, $data);
        return $data;
    }

    /**
     * update an studio
     * @param array $data an array containing info about the studio
     * @param int $id of the studio
     * @return boolean if the update was successful
     */
    public function updateStudio($data, $id)
    {
        $data = $this->update($this->table_name, $data, $id);
        return $data;
    }

    /**
     * delete an studio
     * @param int $studio_id
     * @return boolean if success
     */
    public function deleteStudio($studio_id)
    {
        $sql = "DELETE FROM studios WHERE studio_id = ?;";
        $data = $this->run($sql, [$studio_id])->fetchAll();
        return $data;
    }
}
