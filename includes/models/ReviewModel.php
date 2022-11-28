<?php

class ReviewModel extends BaseModel
{

    private $table_name = "reviews";

    /**
     * A model class for the `reviews` database table.
     * It exposes operations that can be performed on reviews records.
     */
    function __construct()
    {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
    }

    /**
     * Retrieve all reviews from the `reviews` table.
     * @return array A list of reviews. 
     */
    public function getAll()
    {
        $sql = "SELECT * FROM reviews";
        $data = $this->rows($sql);
        return $data;
    }

    /**
     * Get a list of reviewss whose name matches or contains the provided value.       
     * @param string $reviewUsername 
     * @return array An array containing the matches found.
     */
    public function getWhereLike($reviewUsername)
    {
        $sql = "SELECT * FROM reviews WHERE Username LIKE :username";
        $data = $this->run($sql, [":title" => $reviewUsername . "%"])->fetchAll();
        return $data;
    }

    /**
     * Retrieve a review by its id.
     * @param int $review_id the id of the review.
     * @return array an array containing information about a given review.
     */
    public function getReviewById($review_id)
    {
        $sql = "SELECT * FROM reviews WHERE review_id = ?";
        $data = $this->run($sql, [$review_id])->fetch();
        return $data;
    }

    /**
     * Retrieve a review by its movie.
     * @param int $movie_id the id of the movie.
     * @return array an array containing information about a given review.
     */
    public function getReviewsByMovieId($movie_id)
    {
        $sql = "SELECT * FROM reviews WHERE movie_id = ?";
        $data = $this->run($sql, [$movie_id])->fetchAll();
        return $data;
    }

    /**
     * Retrieve a review by its show.
     * @param int $show_id the id of the show.
     * @return array an array containing information about a given review.
     */
    public function getReviewsByShowId($show_id)
    {
        $sql = "SELECT * FROM reviews WHERE show_id = ?";
        $data = $this->run($sql, [$show_id])->fetchAll();
        return $data;
    }

    // /**
    //  * Retrieve a review by director and studio.
    //  * @param int $director_id the id of the director.
    //  * @param int $studio_id the id of the studio.
    //  * @return array an array containing information about a given review.
    //  */
    // public function getReviewByDirectorAndStudio($director_id, $studio_id)
    // {
    //     $sql = "SELECT * FROM reviews WHERE director_id = ? AND studio_id = ?";
    //     $data = $this->run($sql, [$director_id, $studio_id])->fetchAll();
    //     return $data;
    // }

    /**
     * create a Review
     * @param array $data an array containing information about a given review.
     * @return boolean if the insert was successful.
     */
    public function createReview($data)
    {
        $data = $this->insert($this->table_name, $data);
        return $data;
    }

    /**
     * update an review
     * @param array $data an array containing info about the review
     * @param int $id of the review
     * @return boolean if the update was successful
     */
    public function updateReview($data, $id)
    {
        $data = $this->update($this->table_name, $data, $id);
        return $data;
    }
    
    /**
     * delete an review
     * @param int $review_id
     * @return boolean if success
     */
    public function deleteReview($review_id)
    {
        $sql = "DELETE FROM reviews WHERE review_id = ?;";
        $data = $this->run($sql, [$review_id])->fetchAll();
        return $data;
    }
}
