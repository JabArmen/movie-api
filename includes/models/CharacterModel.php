<?php

class CharacterModel extends BaseModel
{

    private $table_name = "characters";

    /**
     * A model class for the `characters` database table.
     * It exposes operations that can be performed on characters records.
     */
    function __construct()
    {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
    }

    /**
     * Retrieve all characters from the `characters` table.
     * @return array A list of characters. 
     */
    public function getAll()
    {
        $sql = "SELECT * FROM characters";
        $data = $this->rows($sql);
        return $data;
    }

    /**
     * Get a list of characterss whose name matches or contains the provided value.       
     * @param string $characterTitle 
     * @return array An array containing the matches found.
     */
    public function getWhereLike($characterName)
    {
        $sql = "SELECT * FROM characters WHERE Name LIKE :name";
        $data = $this->run($sql, [":name" => $characterName . "%"])->fetchAll();
        return $data;
    }

    /**
     * Retrieve a character by its id.
     * @param int $character_id the id of the character.
     * @return array an array containing information about a given character.
     */
    public function getCharacterById($character_id)
    {
        $sql = "SELECT * FROM characters WHERE character_id = ?";
        $data = $this->run($sql, [$character_id])->fetch();
        return $data;
    }

    /**
     * Retrieve a character by its director.
     * @param int $director_id the id of the director.
     * @return array an array containing information about a given character.
     */
    public function getCharacterByActorId($actor_id)
    {
        $sql = "SELECT * FROM characters WHERE actor_id = ?";
        $data = $this->run($sql, [$actor_id])->fetchAll();
        return $data;
    }

    // /**
    //  * Retrieve a character by director and studio.
    //  * @param int $director_id the id of the director.
    //  * @param int $studio_id the id of the studio.
    //  * @return array an array containing information about a given character.
    //  */
    // public function getCharacterByDirectorAndStudio($director_id, $studio_id)
    // {
    //     $sql = "SELECT * FROM characters WHERE director_id = ? AND studio_id = ?";
    //     $data = $this->run($sql, [$director_id, $studio_id])->fetchAll();
    //     return $data;
    // }

    /**
     * create a Character
     * @param array $data an array containing information about a given character.
     * @return boolean if the insert was successful.
     */
    public function createCharacter($data)
    {
        $data = $this->insert($this->table_name, $data);
        return $data;
    }

    /**
     * update an character
     * @param array $data an array containing info about the character
     * @param int $id of the character
     * @return boolean if the update was successful
     */
    public function updateCharacter($data, $id)
    {
        $data = $this->update($this->table_name, $data, $id);
        return $data;
    }
    
    /**
     * delete an character
     * @param int $character_id
     * @return boolean if success
     */
    public function deleteCharacter($character_id)
    {
        $sql = "DELETE FROM characters WHERE character_id = ?;";
        $data = $this->run($sql, [$character_id])->fetchAll();
        return $data;
    }
}