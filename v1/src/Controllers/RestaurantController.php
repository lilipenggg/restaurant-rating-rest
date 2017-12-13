<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:37
 */

namespace Restaurant\Controllers;
use Restaurant\Http\StatusCodes;
use Restaurant\Models\Restaurant;
use Restaurant\Utilities\DatabaseConnection;
use Restaurant\Utilities\RestaurantEnums;
use Restaurant\Utilities\Utilities as u;
use Restaurant\Models\Token;
use Restaurant\Models\User;


class RestaurantController
{
    /*
     * @Route("/restaurants/{id}")
     * @Method("GET")
     */
    function getRestaurant($args)
    {
        try
        {
            // Check whether the requested restaurant exists in the database
            $id = $args['id'];
            if (Restaurant::restaurantExists($id) === true)
            {
                // Load the restaurant info from the database
                $restaurant = new Restaurant();
                $restaurant->setRestaurantId($id);
                $restaurant->load();
                return $restaurant;
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: restaurant with id ".$id." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    /*
     * @Route("/restaurants")
     * @Method("GET")
     */
    function getRestaurants()
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare("SELECT `restaurantId` FROM `Restaurant`");
            $stmtHandle->setFetchMode(\PDO::FETCH_ASSOC);

            $success = $stmtHandle->execute();

            if (!$success)
            {
                http_response_code(StatusCodes::INTERNAL_SERVER_ERROR);
                exit("Error: SQL query execution failed.");
            }
            else
            {
                $arr = array();
                while ($id = $stmtHandle->fetch()['restaurantId'])
                {
                    $restaurant = new Restaurant();
                    $restaurant->setRestaurantId($id);
                    $restaurant->load();
                    array_push($arr, $restaurant);
                }
                return $arr;
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    /*
     * @Route("/restaurants")
     * @Method("POST")
     */
    function postRestaurant()
    {
        try {
            // Make sure only registered or sign in user can post a restaurant
            $userEmail = Token::getEmailFromToken();
            if ($userEmail != null)
            {
                $data = (object)json_decode(file_get_contents('php://input'), true);

                // Check if all the necessary information for creating a restaurant is provided
                if (property_exists($data, RestaurantEnums::NAME) &&
                    property_exists($data, RestaurantEnums::PHONE_NUMBER) &&
                    property_exists($data, RestaurantEnums::ADDRESS) &&
                    property_exists($data, RestaurantEnums::CITY) &&
                    property_exists($data, RestaurantEnums::STATE) &&
                    property_exists($data, RestaurantEnums::ZIP_CODE)
                )
                {
                    $name = filter_var($data->{RestaurantEnums::NAME}, FILTER_SANITIZE_STRING);
                    $address = filter_var($data->{RestaurantEnums::ADDRESS}, FILTER_SANITIZE_STRING);
                    if (property_exists($data, RestaurantEnums::SECOND_ADDRESS))
                        $secondAddress = filter_var($data->{RestaurantEnums::SECOND_ADDRESS}, FILTER_SANITIZE_STRING);
                    else
                        $secondAddress = null;

                    $city = filter_var($data->{RestaurantEnums::CITY}, FILTER_SANITIZE_STRING);
                    $state = filter_var($data->{RestaurantEnums::STATE}, FILTER_SANITIZE_STRING);
                    $zipCode = filter_var($data->{RestaurantEnums::ZIP_CODE}, FILTER_SANITIZE_NUMBER_INT);

                    // Check whether the restaurant exists
                    if (Restaurant::restaurantExistsByNameAddress($name, $address, $secondAddress, $city, $state, $zipCode) === false)
                    {
                        $restaurant = new Restaurant();

                        // Set all the provided information to the local restaurant object
                        $restaurant->setName($name);
                        $restaurant->setPhoneNumber(filter_var($data->{RestaurantEnums::PHONE_NUMBER}, FILTER_SANITIZE_STRING));
                        $restaurant->setAddress($address);
                        $restaurant->setCity($city);
                        $restaurant->setState($state);
                        $restaurant->setZipCode($zipCode);


                        // Set hidden fields for restaurant
                        $restaurant->setRestaurantId(u::unique_id());
                        $restaurant->setUserId(User::getUserIdByEmail($userEmail));

                        // Set optional field for restaurant
                        if (property_exists($data, RestaurantEnums::WEBSITE))
                            $restaurant->setWebsite(filter_var($data->{RestaurantEnums::WEBSITE}, FILTER_SANITIZE_STRING));
                        else
                            $restaurant->setWebsite(null);

                        if (property_exists($data, RestaurantEnums::SECOND_ADDRESS))
                            $restaurant->setSecondAddress(filter_var($data->{RestaurantEnums::SECOND_ADDRESS}, FILTER_SANITIZE_STRING));
                        else
                            $restaurant->setSecondAddress(null);

                        // Create the restaurant in database
                        $restaurant->create();
                        http_response_code(StatusCodes::CREATED);
                    }
                    else
                    {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        exit("Error: the restaurant with this name and address already exists.");
                    }
                }
                else
                {
                    http_response_code(StatusCodes::BAD_REQUEST);
                    exit ("Error: this request does not contain all the mandatory info for creating a restaurant");
                }
            }
            else
            {
                http_response_code(StatusCodes::METHOD_NOT_ALLOWED);
                exit("Error: you have to create an account or sign in to post a review.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    /*
     * @Route("/users/{id}")
     * @Method("PUT")
     */
    function putRestaurant($args)
    {
        try
        {
            $data = (object)json_decode(file_get_contents('php://input'), true);

            // Check if the requested restaurant exists
            $id = $args['id'];
            if (Restaurant::restaurantExists($id) === true)
            {
                $restaurant = new Restaurant();
                $restaurant->setRestaurantId($id);
                $restaurant->load();

                // Check if the person who wants to update the restaurant info is the owner of the restaurant
                if ($restaurant->getUserId() == User::getUserIdByEmail(Token::getEmailFromToken()))
                {
                    // Check if the request contains all the mandatory info for full updating
                    if (property_exists($data, RestaurantEnums::NAME) &&
                        property_exists($data, RestaurantEnums::PHONE_NUMBER) &&
                        property_exists($data, RestaurantEnums::ADDRESS) &&
                        property_exists($data, RestaurantEnums::CITY) &&
                        property_exists($data, RestaurantEnums::STATE) &&
                        property_exists($data, RestaurantEnums::ZIP_CODE)
                    )
                    {
                        // Check if the restaurant name and address will be the same as other one in the database
                        $name = filter_var($data->{RestaurantEnums::NAME}, FILTER_SANITIZE_STRING);
                        $address = filter_var($data->{RestaurantEnums::ADDRESS}, FILTER_SANITIZE_STRING);

                        if (property_exists($data, RestaurantEnums::SECOND_ADDRESS))
                            $secondAddress = filter_var($data->{RestaurantEnums::SECOND_ADDRESS}, FILTER_SANITIZE_STRING);
                        else
                            $secondAddress = null;

                        $city = filter_var($data->{RestaurantEnums::CITY}, FILTER_SANITIZE_STRING);
                        $state = filter_var($data->{RestaurantEnums::STATE}, FILTER_SANITIZE_STRING);
                        $zipCode = filter_var($data->{RestaurantEnums::ZIP_CODE}, FILTER_SANITIZE_NUMBER_INT);

                        if (Restaurant::restaurantExistsByNameAddress($name, $address, $secondAddress, $city, $state, $zipCode, $restaurant->getRestaurantId()) === false)
                        {
                            // Set all the provided information to the local restaurant object
                            $restaurant->setName($name);
                            $restaurant->setPhoneNumber(filter_var($data->{RestaurantEnums::PHONE_NUMBER}, FILTER_SANITIZE_STRING));
                            $restaurant->setAddress($address);
                            $restaurant->setCity($city);
                            $restaurant->setState($state);
                            $restaurant->setZipCode($zipCode);

                            // Set optional field for restaurant
                            $restaurant->setSecondAddress($secondAddress);

                            if (property_exists($data, RestaurantEnums::WEBSITE))
                                $restaurant->setWebsite(filter_var($data->{RestaurantEnums::WEBSITE}, FILTER_SANITIZE_STRING));
                            else
                                $restaurant->setWebsite(null);

                            // Update the restaurant in database
                            $restaurant->update();
                            http_response_code(StatusCodes::OK);
                        }
                        else
                        {
                            http_response_code(StatusCodes::BAD_REQUEST);
                            exit("Error: the restaurant with this name and address already exists.");
                        }
                    }
                    else
                    {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        exit("Error: this request does not contain all the mandatory info for full updating a restaurant.");
                    }
                }
                else
                {
                    http_response_code(StatusCodes::UNAUTHORIZED);
                    exit("Error: you are not authorized to update this restaurant's information.");
                }
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: restaurant with id ".$id." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    /*
     * @Route("/restaurants/{id}")
     * @Method("PATCH")
     */
    function patchRestaurant($args)
    {
        try
        {
            $data = (object)json_decode(file_get_contents('php://input'), true);

            // Check if the requested restaurant exists
            $id = $args['id'];
            if (Restaurant::restaurantExists($id) === true)
            {
                $restaurant = new Restaurant();
                $restaurant->setRestaurantId($id);
                $restaurant->load();

                // Check if the person who wants to update the restaurant info is the owner of the restaurant
                if ($restaurant->getUserId() == User::getUserIdByEmail(Token::getEmailFromToken()))
                {
                    if (property_exists($data, RestaurantEnums::NAME))
                        $name = filter_var($data->{RestaurantEnums::NAME}, FILTER_SANITIZE_STRING);
                    else
                        $name = $restaurant->getName();

                    if (property_exists($data, RestaurantEnums::ADDRESS))
                        $address = filter_var($data->{RestaurantEnums::ADDRESS}, FILTER_SANITIZE_STRING);
                    else
                        $address = $restaurant->getAddress();

                    if (property_exists($data, RestaurantEnums::SECOND_ADDRESS))
                        $secondAddress = filter_var($data->{RestaurantEnums::SECOND_ADDRESS}, FILTER_SANITIZE_STRING);
                    else
                        $secondAddress = $restaurant->getSecondAddress();

                    if (property_exists($data, RestaurantEnums::CITY))
                        $city = filter_var($data->{RestaurantEnums::CITY}, FILTER_SANITIZE_STRING);
                    else
                        $city = $restaurant->getCity();

                    if (property_exists($data, RestaurantEnums::STATE))
                        $state = filter_var($data->{RestaurantEnums::STATE}, FILTER_SANITIZE_STRING);
                    else
                        $state = $restaurant->getState();

                    if (property_exists($data, RestaurantEnums::ZIP_CODE))
                        $zipCode = filter_var($data->{RestaurantEnums::ZIP_CODE}, FILTER_SANITIZE_NUMBER_INT);
                    else
                        $zipCode = $restaurant->getZipCode();

                    // Check if there is a restaurant with the same name and address exists in the database
                    if (Restaurant::restaurantExistsByNameAddress($name, $address, $secondAddress, $city, $state, $zipCode, $restaurant->getRestaurantId()) === false)
                    {
                        $restaurant->setName($name);
                        $restaurant->setAddress($address);
                        $restaurant->setSecondAddress($secondAddress);
                        $restaurant->setCity($city);
                        $restaurant->setState($state);
                        $restaurant->setZipCode($zipCode);

                        if (property_exists($data, RestaurantEnums::PHONE_NUMBER))
                            $restaurant->setPhoneNumber(filter_var($data->{RestaurantEnums::PHONE_NUMBER}, FILTER_SANITIZE_STRING));

                        if (property_exists($data, RestaurantEnums::WEBSITE))
                            $restaurant->setWebsite(filter_var($data->{RestaurantEnums::WEBSITE}, FILTER_SANITIZE_STRING));

                        // Update the restaurant info based on json data provided by request
                        $restaurant->update();
                        http_response_code(StatusCodes::OK);
                    }
                    else
                    {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        exit("Error: the restaurant with this name and address already exists.");
                    }
                }
                else
                {
                    http_response_code(StatusCodes::UNAUTHORIZED);
                    exit("Error: you are not authorized to update this restaurant's information.");
                }
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: restaurant with id ".$id." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    function deleteRestaurant($args)
    {
        try
        {
            // Check if the requested restaurant exists in the database
            $id = $args['id'];
            if (Restaurant::restaurantExists($id) === true)
            {
                $restaurant = new Restaurant();
                $restaurant->setRestaurantId($id);
                $restaurant->load();

                // Check whether the person who sent the request is an admin role or the owner of the restaurant
                if (Token::getRoleFromToken() == Token::ROLE_ADMIN || $restaurant->getUserId() == User::getUserIdByEmail(Token::getEmailFromToken()))
                {
                    // Delete the restaurant
                    $restaurant->delete();
                }
                else
                {
                    http_response_code(StatusCodes::UNAUTHORIZED);
                    exit("Error: you are not authorized to perform this operation.");
                }
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: restaurant with id ".$id." does not exist in the database.");
            }

        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

}