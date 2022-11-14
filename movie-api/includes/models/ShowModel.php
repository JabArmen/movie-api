<?php

class ShowModel extends BaseModel
{

    private $table_name = "shows";

    /**
     * A model class for the `shows` database table.
     * It exposes operations that can be performed on shows records.
     */
    function __construct()
    {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
    }

    /**
     * Retrieve all shows from the `shows` table.
     * @return array A list of shows. 
     */
    public function getAll()
    {
        $sql = "SELECT * FROM shows";
        $data = $this->rows($sql);
        return $data;
    }

    /**
     * Get a list of showss whose name matches or contains the provided value.       
     * @param string $showTitle 
     * @return array An array containing the matches found.
     */
    public function getWhereLike($showTitle)
    {
        $sql = "SELECT * FROM shows WHERE Title LIKE :title";
        $data = $this->run($sql, [":title" => $showTitle . "%"])->fetchAll();
        return $data;
    }

    /**
     * Retrieve a show by its id.
     * @param int $show_id the id of the show.
     * @return array an array containing information about a given show.
     */
    public function getShowById($show_id)
    {
        $sql = "SELECT * FROM shows WHERE show_id = ?";
        $data = $this->run($sql, [$show_id])->fetch();
        return $data;
    }

    /**
     * Retrieve a show by its director.
     * @param int $director_id the id of the director.
     * @return array an array containing information about a given show.
     */
    public function getShowByDirectorId($director_id)
    {
        $sql = "SELECT * FROM shows WHERE director_id = ?";
        $data = $this->run($sql, [$director_id])->fetchAll();
        return $data;
    }

    /**
     * Retrieve a show by director and studio.
     * @param int $director_id the id of the director.
     * @param int $studio_id the id of the studio.
     * @return array an array containing information about a given show.
     */
    public function getShowByDirectorAndStudio($director_id, $studio_id)
    {
        $sql = "SELECT * FROM shows WHERE director_id = ? AND studio_id = ?";
        $data = $this->run($sql, [$director_id, $studio_id])->fetchAll();
        return $data;
    }

    /**
     * create a Show
     * @param array $data an array containing information about a given show.
     * @return boolean if the insert was successful.
     */
    public function createShow($data)
    {
        $data = $this->insert($this->table_name, $data);
        return $data;
    }

    /**
     * update an show
     * @param array $data an array containing info about the show
     * @param int $id of the show
     * @return boolean if the update was successful
     */
    public function updateShow($data, $id)
    {
        $data = $this->update($this->table_name, $data, $id);
        return $data;
    }
    
    /**
     * delete an show
     * @param int $show_id
     * @return boolean if success
     */
    public function deleteShow($show_id)
    {
        $sql = "DELETE FROM shows WHERE show_id = ?;";
        $data = $this->run($sql, [$show_id])->fetchAll();
        return $data;
    }
}
