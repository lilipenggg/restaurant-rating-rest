<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:36
 */

namespace Restaurant\Models;
use Restaurant\Utilities\DatabaseConnection;
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
    public function setReviewId(string $reviewId)
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
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "INSERT INTO `Review`(
                `reviewId`, 
                `rating`, 
                `restaurantId`, 
                `reviewContent`, 
                `userId`) 
                VALUES (:reviewId,:rating,:restaurantId,:reviewContent,:userId)"
            );

            $stmtHandle->bindValue(":reviewId", $this->reviewId);
            $stmtHandle->bindValue(":rating", $this->rating);
            $stmtHandle->bindValue(":restaurantId", $this->restaurantId);
            $stmtHandle->bindValue(":reviewContent", $this->reviewContent);
            $stmtHandle->bindValue(":userId", $this->userId);

            $success = $stmtHandle->execute();
            if (!$success)
                throw new \PDOException("Error: SQL query execution failed.");
        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }

    public function update()
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare(
                "UPDATE `Review` 
                 SET `rating`=:rating,
                     `restaurantId`=:restaurantId,
                     `reviewContent`=:reviewContent,
                     `userId`=:userId 
                 WHERE `reviewId`=:reviewId"
            );

            $stmtHandle->bindValue(":reviewId", $this->reviewId);
            $stmtHandle->bindValue(":rating", $this->rating);
            $stmtHandle->bindValue(":restaurantId", $this->restaurantId);
            $stmtHandle->bindValue(":reviewContent", $this->reviewContent);
            $stmtHandle->bindValue(":userId", $this->userId);

            $success = $stmtHandle->execute();
            if (!$success)
                throw new \PDOException("Error: SQL query execution failed.");

        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }

    public function load()
    {
        try
        {
            if (empty($this->reviewId))
            {
                throw new \Exception("Error: review id is not set.");
            }
            else
            {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare("SELECT * FROM `Review` WHERE `reviewId` = :reviewId");
                $stmtHandle->bindValue(":reviewId", $this->reviewId);

                $stmtHandle->setFetchMode(\PDO::FETCH_ASSOC);
                $success = $stmtHandle->execute();

                if (!$success)
                    throw new \PDOException("Error: SQL query execution failed.");
                else
                {
                    if ($stmtHandle->rowCount() != 0)
                    {
                        $data = $stmtHandle->fetch();
                        $this->rating = $data['rating'];
                        $this->restaurantId = $data['restaurantId'];
                        $this->reviewContent = $data['reviewContent'];
                        $this->userId = $data['userId'];
                    }
                    else
                    {
                        throw new \Exception("Error: this review does not exist in the database.");
                    }
                }
            }
        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }

    public function delete()
    {
        try
        {
            if (empty($this->reviewId))
            {
                throw new \Exception(("Error: review id is not set."));
            }
            else
            {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare("DELETE FROM `Review` WHERE `reviewId` = :reviewId");
                $stmtHandle->bindValue(":reviewId", $this->reviewId);

                $success = $stmtHandle->execute();

                if (!$success)
                {
                    throw new \PDOException("Error: SQL query execution failed.");
                }
            }
        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }

    public static function reviewExists($id) : bool
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();

            $stmtHandle = $dbh->prepare("SELECT * FROM  `Review` WHERE `reviewId` = :reviewId");
            $stmtHandle->bindValue(":reviewId", $id);

            $stmtHandle->setFetchMode(\PDO::FETCH_ASSOC);

            $success = $stmtHandle->execute();

            if (!$success)
            {
                throw new \PDOException("Error: SQL query execution failed.");
            }
            else
            {
                return ($stmtHandle->rowCount() != 0 ? true : false);
            }
        }
        catch (\Exception $e)
        {
            throw $e;
        }
    }
}