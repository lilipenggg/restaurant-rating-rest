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


class Restaurant implements \JsonSerializable
{
    private $restaurantId;
    private $name;
    private $phoneNumber;
    private $description;
    private $address;
    private $secondAddress;
    private $city;
    private $state;
    private $zipCode;
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
    public function setRestaurantId(string $restaurantId)
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
    public function getSecondAddress()
    {
        return $this->secondAddress;
    }

    /**
     * @param mixed $secondAddress
     */
    public function setSecondAddress($secondAddress)
    {
        $this->secondAddress = $secondAddress;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param mixed $zipCode
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
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
    public function setWebsite($website)
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
            $stmtHandle = $dbh->prepare(
                "INSERT INTO `Restaurant`(
                `restaurantId`, 
                `name`, 
                `phoneNumber`, 
                `address`, 
                `secondAddress`, 
                `city`, 
                `state`, 
                `zipCode`,
                `website`, 
                `userId`) 
                VALUES (:restaurantId,:rname,:phoneNumber,:address, :secondAddress,:city,:state,:zipCode,:website,:userId)"
            );

            $stmtHandle->bindValue(":restaurantId", $this->restaurantId);
            $stmtHandle->bindValue(":rname", $this->name);
            $stmtHandle->bindValue(":phoneNumber", $this->phoneNumber);
            $stmtHandle->bindValue(":address", $this->address);
            $stmtHandle->bindValue(":secondAddress", $this->secondAddress);
            $stmtHandle->bindValue(":secondAddress", $this->secondAddress);
            $stmtHandle->bindValue(":city", $this->city);
            $stmtHandle->bindValue(":state", $this->state);
            $stmtHandle->bindValue(":zipCode", $this->zipCode);
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
                     `secondAddress`=:secondAddress,
                     `city`=:city,
                     `state`=:state,
                     `zipCode`=:zipCode,
                     `website`=:website,
                     `userId = :userId`
                 WHERE `restaurantId` = :restaurantId"
            );

            $stmtHandle->bindValue(":restaurantId", $this->restaurantId);
            $stmtHandle->bindValue(":rname", $this->name);
            $stmtHandle->bindValue(":phoneNumber", $this->phoneNumber);
            $stmtHandle->bindValue(":address", $this->address);
            $stmtHandle->bindValue(":secondAddress", $this->secondAddress);
            $stmtHandle->bindValue(":city", $this->city);
            $stmtHandle->bindValue(":state", $this->state);
            $stmtHandle->bindValue(":zipCode", $this->zipCode);
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
                        $this->secondAddress = $data['secondAddress'];
                        $this->city = $data['city'];
                        $this->state = $data['state'];
                        $this->zipCode = $data['zipCode'];
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

    public static function restaurantExists($id) : bool
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();

            $stmtHandle = $dbh->prepare("SELECT * FROM  `Restaurant` WHERE `restaurantId` = :restaurantId");
            $stmtHandle->bindValue(":restaurantId", $id);

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

    public static function restaurantExistsByNameAddress(string $name, string $address, $id=null)
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();

            if ($id == null)
            {
                $stmtHandle = $dbh->prepare("SELECT * FROM  `Restaurant` WHERE `name` = :rname AND `address` = :address");
            }
            else
            {
                $stmtHandle = $dbh->prepare("SELECT * FROM  `Restaurant` WHERE `name` = :rname AND `address` = :address AND `restaurantId` != :restaurantId");
                $stmtHandle->bindValue(":restaurantId", $id);
            }

            $stmtHandle->bindValue(":rname", $name);
            $stmtHandle->bindValue(":address", $address);

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