<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:36
 */

namespace Restaurant\Models;
use \Restaurant\Utilities\DatabaseConnection;
use \Restaurant\Utilities\RestaurantEnums;
require_once "..\Utilities\Utilities.php";


class Restaurant implements \JsonSerializable
{
    private $restaurantId;
    private $name;
    private $phoneNumber;
    private $description;
    private $address;
    private $website;
    private $userId;

    public function __construct()
    {

    }

    function jsonSerialize()
    {
        return array(
            RestaurantEnums::RESTAURANT_ID => $this->restaurantId,
            RestaurantEnums::NAME => $this->name,
            RestaurantEnums::PHONE_NUMBER => $this->phoneNumber,
            RestaurantEnums::DESCRIPTION => $this->description,
            RestaurantEnums::ADDRESS => $this->address,
            RestaurantEnums::WEBSITE => $this->website,
            RestaurantEnums::USER_ID => $this->userId
        );
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite(string $website)
    {
        $this->website = $website;
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

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function create()
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $this->restaurantId = GUID();
            $stmtHandle = $dbh->prepare(
                "INSERT INTO `Restaurant`(
                `restaurantId`, 
                `name`, 
                `phoneNumber`, 
                `address`, 
                `website`, 
                `userId`) 
                VALUES (:restaurantId,:name,:phoneNumber,:address,:website,:userId)"
            );

            $stmtHandle->bindValue(":restaurantId", $this->restaurantId);
            $stmtHandle->bindValue(":name", $this->name);
            $stmtHandle->bindValue(":phoneNumber", $this->phoneNumber);
            $stmtHandle->bindValue(":address", $this->address);
            $stmtHandle->bindValue(":website", $this->website);
            $stmtHandle->bindValue(":userId", $this->userId);

            $success = $stmtHandle->execute();
            if (!$success)
            {
                throw new \PDOException("Error: SQL query execution failed.");
            }
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
                "UPDATE `Restaurant` 
                 SET `name`=:rname,
                     `phoneNumber`=:phoneNumber,
                     `address`=:address,
                     `website`=:website,
                     `userId = :userId`
                 WHERE `restaurantId` = :restaurantId"
            );

            $stmtHandle->bindValue(":restaurantId", $this->restaurantId);
            $stmtHandle->bindValue(":rname", $this->name);
            $stmtHandle->bindValue(":phoneNumber", $this->phoneNumber);
            $stmtHandle->bindValue(":address", $this->address);
            $stmtHandle->bindValue(":website", $this->website);
            $stmtHandle->bindValue(":userId", $this->userId);

            $success = $stmtHandle->execute();
            if (!$success)
            {
                throw new \PDOException("Error: SQL query execution failed.");
            }
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
            if (empty($this->restaurantId))
            {
                throw new \Exception("Error: restaurant id is not set.");
            }
            else
            {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare("SELECT * FROM `Restaurant` WHERE `restaurantId` = :restaurantId");
                $stmtHandle->bindValue(":restaurantId", $this->restaurantId);

                $stmtHandle->setFetchMode(\PDO::FETCH_ASSOC);
                $success = $stmtHandle->execute();

                if (!$success)
                    throw new \PDOException("Error: SQL query execution failed.");
                else
                {
                    if ($stmtHandle->rowCount() != 0)
                    {
                        $data = $stmtHandle->fetch();
                        $this->name = $data['name'];
                        $this->phoneNumber = $data['phoneNumber'];
                        $this->address = $data['address'];
                        $this->website = $data['website'];
                        $this->userId = $data['userId'];
                    }
                    else
                    {
                        throw new \Exception("Error: this restaurant does not exist in the database");
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
            if (empty($this->restaurantId))
            {
                throw new \Exception("Error: restaurant id is not set.");
            }
            else
            {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare("DELETE FROM `Restaurant` WHERE `restaurantId` = :restaurantId");
                $stmtHandle->bindValue(":restaurantId", $this->restaurantId);
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
}