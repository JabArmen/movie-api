<?php

class ActorModel extends BaseModel
{

    private $table_name = "actors";

    /**
     * A model class for the `actors` database table.
     * It exposes operations that can be performed on actors records.
     */
    function __construct()
    {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
    }

    /**
     * Retrieve all actors from the `actors` table.
     * @return array A list of actors. 
     */
    public function getAll()
    {
        $sql = "SELECT * FROM actors";
        $data = $this->paginate($sql);
        return $data;
    }

    /**
     * Get a list of actorss whose name matches or contains the provided value.       
     * @param string $actorName
     * @return array An array containing the matches found.
     */
    public function getWhereLike($actorName)
    {
        $sql = "SELECT * FROM actors WHERE Name LIKE :name";
        $data = $this->paginate($sql, [":name" => $actorName . "%"]);
        return $data;
    }


    /**
     * Retrieve a actor by its id.
     * @param int $actor_id the id of the actor.
     * @return array an array containing information about a given actor.
     */
    public function getActorById($actor_id)
    {
        $sql = "SELECT * FROM actors WHERE actor_id = ?";
        $data = $this->paginate($sql, [$actor_id]);
        return $data;
    }

    /**
     * Retrieve a actor by its director.
     * @param int $director_id the id of the director.
     * @return array an array containing information about a given actor.
     */
    public function getActorByDirectorId($director_id)
    {
        $sql = "SELECT * FROM actors WHERE director_id = ?";
        $data = $this->paginate($sql, [$director_id]);
        return $data;
    }

    /**
     * Retrieve a actor by director and studio.
     * @param int $director_id the id of the director.
     * @param int $studio_id the id of the studio.
     * @return array an array containing information about a given actor.
     */
    public function getActorByDirectorAndStudio($director_id, $studio_id)
    {
        $sql = "SELECT * FROM actors WHERE director_id = ? AND studio_id = ?";
        $data = $this->paginate($sql, [$director_id, $studio_id]);
        return $data;
    }

    /**
     * create a Actor
     * @param array $data an array containing information about a given actor.
     * @return boolean if the insert was successful.
     */
    public function createActor($data)
    {
        $data = $this->insert($this->table_name, $data);
        return $data;
    }

    /**
     * update an actor
     * @param array $data an array containing info about the actor
     * @param int $id of the actor
     * @return boolean if the update was successful
     */
    public function updateActor($data, $id)
    {
        $data = $this->update($this->table_name, $data, $id);
        return $data;
    }

    /**
     * delete an actor
     * @param int $actor_id
     * @return boolean if success
     */
    public function deleteActor($actor_id)
    {
        $sql = "DELETE FROM actors WHERE actor_id = ?;";
        $data = $this->run($sql, [$actor_id])->fetchAll();
        return $data;
    }
}
