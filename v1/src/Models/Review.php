<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:36
 */

namespace Restaurant\Models;
use \Restaurant\Utilities\ReviewEnums;


class Review implements \JsonSerializable
{
    // Attributes
    private $reviewId;
    private $rating;
    private $restaurantId;
    private $reviewContent;
    private $userId;

    public function __construct()
    {

    }

    function jsonSerialize()
    {
        return array(
            ReviewEnums::REVIEW_ID => $this->reviewId,
            ReviewEnums::RATING => $this->rating,
            ReviewEnums::RESTAURANT_ID => $this->restaurantId,
            ReviewEnums::REVIEW_CONTENT => $this->reviewContent,
            ReviewEnums::USER_ID => $this->userId
        );
    }

    /**
     * @return mixed
     */
    public function getReviewId()
    {
        return $this->reviewId;
    }

    /**
     * @param mixed $reviewId
     */
    public function setReviewId(int $reviewId)
    {
        $this->reviewId = $reviewId;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating(int $rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getRestaurantId()
    {
        return $this->restaurantId;
    }

    /**
     * @param mixed $restaurantId
     */
    public function setRestaurantId(int $restaurantId)
    {
        $this->restaurantId = $restaurantId;
    }

    /**
     * @return mixed
     */
    public function getReviewContent()
    {
        return $this->reviewContent;
    }

    /**
     * @param mixed $reviewContent
     */
    public function setReviewContent(string $reviewContent)
    {
        $this->reviewContent = $reviewContent;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function load()
    {

    }

    public function delete()
    {

    }
}