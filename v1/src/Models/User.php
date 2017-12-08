<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:36
 */

namespace Restaurant\Models;
use \Restaurant\Utilities\DatabaseConnection;
use \Restaurant\Utilities\UserEnums;


class User implements \JsonSerializable
{
    // Constants
    const TYPE_REGULAR = "Regular";
    const TYPE_BUSINESS = "Business";

    // Attributes
    private $userId;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $zipCode;
    private $birthday;
    private $phoneNumber;
    private $gender;
    private $userType;

    public function __construct()
    {

    }

    function jsonSerialize()
    {
        return array(
            UserEnums::USER_ID => $this->userId,
            UserEnums::FIRST_NAME => $this->firstName,
            UserEnums::LAST_NAME => $this->lastName,
            UserEnums::EMAIL => $this->email,
            UserEnums::ZIP_CODE => $this->zipCode,
            UserEnums::BIRTHDAY => $this->birthday,
            UserEnums::PHONE_NUMBER => $this->phoneNumber,
            UserEnums::GENDER => $this->gender,
            UserEnums::USER_TYPE => $this->userType
        );
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
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
    public function setZipCode(int $zipCode)
    {
        $this->zipCode = $zipCode;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday(string $birthday)
    {
        $this->birthday = $birthday;
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
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender(string $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param mixed $userType
     */
    public function setUserType(string $userType)
    {
        $this->userType = $userType;
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