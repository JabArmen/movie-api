<?php

class ArtistModel extends BaseModel
{

    private $table_name = "artist";

    /**
     * A model class for the `artist` database table.
     * It exposes operations that can be performed on artists records.
     */
    function __construct()
    {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
    }

    /**
     * Retrieve all artists from the `artist` table.
     * @return array A list of artists. 
     */
    public function getAll()
    {
        $sql = "SELECT * FROM artist";
        $data = $this->rows($sql);
        return $data;
    }

    /**
     * Get a list of artists whose name matches or contains the provided value.       
     * @param string $artistName 
     * @return array An array containing the matches found.
     */
    public function getWhereLike($artistName)
    {
        $sql = "SELECT * FROM artist WHERE Name LIKE :name";
        $data = $this->run($sql, [":name" => $artistName . "%"])->fetchAll();
        return $data;
    }

    /**
     * Retrieve an artist by its id.
     * @param int $artist_id the id of the artist.
     * @return array an array containing information about a given artist.
     */
    public function getArtistById($artist_id)
    {
        $sql = "SELECT * FROM artist WHERE ArtistId = ?";
        $data = $this->run($sql, [$artist_id])->fetch();
        return $data;
    }

    /**
     * Retrieve an album by its artistid.
     * @param int $artist_id the id of the artist.
     * @return array an array containing information about a given artist.
     */
    public function getAlbumByArtistId($artist_id)
    {
        $sql = "SELECT * FROM album WHERE ArtistId = ?";
        $data = $this->run($sql, [$artist_id])->fetchAll();
        return $data;
    }

    /**
     * Retrieve an artist by its id.
     * @param int $artist_id the id of the artist.
     * @param int $album_id the id of the album.
     * @return array an array containing information about a given artist.
     */
    public function getAlbumByArtistIdAndAlbumId($artist_id, $album_id)
    {
        $sql = "SELECT * FROM album WHERE ArtistId = ? AND AlbumId = ?";
        $data = $this->run($sql, [$artist_id, $album_id])->fetchAll();
        return $data;
    }

    /**
     * Retrieve tracks by album id
     * @param int $album_id the id of the album.
     * @return array an array containing information about a given artist.
     */
    public function getTracksByAlbumId($album_id)
    {
        $sql = "SELECT * FROM track WHERE AlbumId = ?";
        $data = $this->run($sql, [$album_id])->fetchAll();
        return $data;
    }

    /**
     * create an Artist
     * @param array $data an array containing information about a given artist.
     * @return boolean if the insert was successful.
     */
    public function createArtist($data)
    {
        $data = $this->insert($this->table_name, $data);
        return $data;
    }

    /**
     * update an artist
     * @param array $data an array containing info about the artist
     * @param int $id of the artist
     * @return boolean if the update was successful
     */
    public function updateArtist($data, $id)
    {
        $data = $this->update($this->table_name, $data, $id);
        return $data;
    }
    
    /**
     * delete an artist
     * @param int $artist_id
     * @return boolean if success
     */
    public function deleteArtist($artist_id)
    {
        $sql = "DELETE FROM artist WHERE ArtistId = ?;";
        $data = $this->run($sql, [$artist_id])->fetchAll();
        return $data;
    }
}
