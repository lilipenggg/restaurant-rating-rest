<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:36
 */

namespace Restaurant\Models;
use \Restaurant\Utilities\RestaurantEnums;


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