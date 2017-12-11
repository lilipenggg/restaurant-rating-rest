<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:37
 */

namespace Restaurant\Controllers;
use Restaurant\Models\Restaurant;
use \Restaurant\Models\User;
use \Restaurant\Models\Token;
use \Restaurant\Http\StatusCodes;
use Restaurant\Utilities\DatabaseConnection;
use Restaurant\Utilities\UserEnums;
use Restaurant\Utilities\Utilities as u;


class UserController
{
    /*
     * @Route("/users/{id}")
     * @Method("GET")
     */
    function getUser($args)
    {
        try
        {
            $userId = $args['id'];
            if (User::userExists($userId) === true)
            {
                $user = new User();
                $user->setUserId($userId);
                $user->load();

                // Check whether the person who send the request is retrieving their own information
                if ($user->getEmail() == Token::getEmailFromToken())
                {
                    return $user;
                }
                else
                {
                    http_response_code(StatusCodes::UNAUTHORIZED);
                    exit("Error: you are not authorized to retrieve this user's information.");
                }
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: user with id ".$userId." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    /*
     * @Route("/users")
     * @Method("GET")
     */
    function getUsers()
    {
        try
        {
            // Make sure that the person who sent this request is a admin role type
            if (Token::getRoleFromToken() != Token::ROLE_ADMIN)
            {
                http_response_code(StatusCodes::UNAUTHORIZED);
                exit("Error: you are not authorized to retrieve all the user's information.");
            }
            else
            {
                $dbh = DatabaseConnection::getInstance();
                $stmtHandle = $dbh->prepare("SELECT `userId` FROM `User`");
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
                    while ($userId = $stmtHandle->fetch()['userId'])
                    {
                        $user = new User();
                        $user->setUserId($userId);
                        $user->load();
                        array_push($arr, $user);
                    }
                    return $arr;
                }
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    /*
    * @Route("/users")
    * @Method("POST")
    */
    function postUser()
    {
        try
        {
            $data = (object)json_decode(file_get_contents('php://input'), true);

            $user = new User();
            // Check if all the necessary information for creating a user is provided
            if (property_exists($data, UserEnums::FIRST_NAME) &&
                property_exists($data, UserEnums::LAST_NAME) &&
                property_exists($data, UserEnums::EMAIL) &&
                property_exists($data, UserEnums::PASSWORD) &&
                property_exists($data, UserEnums::ZIP_CODE)
            )
            {
                $email = filter_var($data->{UserEnums::EMAIL}, FILTER_SANITIZE_EMAIL);

                // Check whether the provided email is already registered
                if (User::userExists($email, 'Email'))
                {
                    http_response_code(StatusCodes::BAD_REQUEST);
                    exit("Error: this email is already used.");
                }
                else
                {

                    $user->setFirstName(filter_var($data->{UserEnums::FIRST_NAME}, FILTER_SANITIZE_STRING));
                    $user->setLastName(filter_var($data->{UserEnums::LAST_NAME}, FILTER_SANITIZE_STRING));
                    $user->setEmail($email);
                    $user->setPassword(filter_var($data->{UserEnums::PASSWORD}, FILTER_SANITIZE_STRING));
                    $user->setZipCode(filter_var($data->{UserEnums::ZIP_CODE}, FILTER_SANITIZE_NUMBER_INT));

                    // Set the user hidden attributes
                    $user->setUserId(u::unique_id());
                    $user->setUserType(User::TYPE_REGULAR); // Only allow creating regular type user from sending request

                    // Check and set the optional attributes for user
                    if (property_exists($data, UserEnums::BIRTHDAY))
                        $user->setBirthday(filter_var($data->{UserEnums::BIRTHDAY}, FILTER_SANITIZE_STRING));
                    else
                        $user->setBirthday(null);

                    if (property_exists($data, UserEnums::PHONE_NUMBER))
                        $user->setPhoneNumber(filter_var($data->{UserEnums::PHONE_NUMBER}, FILTER_SANITIZE_STRING));
                    else
                        $user->setPhoneNumber(null);

                    if (property_exists($data, UserEnums::GENDER))
                        $user->setGender(filter_var($data->{UserEnums::GENDER}, FILTER_SANITIZE_STRING));
                    else
                        $user->setGender(null);

                    // Create the user in the database
                    $user->create();
                    http_response_code(StatusCodes::CREATED);
                }
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: this request does not contain all the mandatory info for creating a user.");
            }

        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    /*
    *  @Route("/users/{id}")
    *  @Method("PUT")
    */
    function putUser($args)
    {
        try
        {
            $data = (object)json_decode(file_get_contents('php://input'), true);

            // Check if the requested user exists
            $userId = $args['id'];
            if (User::userExists($userId) === true)
            {
                $user = new User();
                $user->setUserId($userId);
                $user->load();

                // Check if the person who sent the request is requesting their own information
                if ($user->getEmail() == Token::getEmailFromToken())
                {
                    if (property_exists($data, UserEnums::FIRST_NAME) &&
                        property_exists($data, UserEnums::LAST_NAME) &&
                        property_exists($data, UserEnums::EMAIL) &&
                        property_exists($data, UserEnums::PASSWORD) &&
                        property_exists($data, UserEnums::ZIP_CODE)
                    )
                    {
                        $email = filter_var($data->{UserEnums::EMAIL}, FILTER_SANITIZE_EMAIL);

                        // Check whether the provided email is already registered
                        if (User::userEmailUsed($email, $user->getUserId()))
                        {
                            http_response_code(StatusCodes::BAD_REQUEST);
                            exit("Error: this email is already used.");
                        }
                        else
                        {
                            $user->setFirstName(filter_var($data->{UserEnums::FIRST_NAME}, FILTER_SANITIZE_STRING));
                            $user->setLastName(filter_var($data->{UserEnums::LAST_NAME}, FILTER_SANITIZE_STRING));
                            $user->setEmail($email);
                            $user->setPassword(filter_var($data->{UserEnums::PASSWORD}, FILTER_SANITIZE_STRING));
                            $user->setZipCode(filter_var($data->{UserEnums::ZIP_CODE}, FILTER_SANITIZE_NUMBER_INT));

                            // Check and set the optional attributes for user
                            if (property_exists($data, UserEnums::BIRTHDAY))
                                $user->setBirthday(filter_var($data->{UserEnums::BIRTHDAY}, FILTER_SANITIZE_STRING));
                            else
                                $user->setBirthday(null);

                            if (property_exists($data, UserEnums::PHONE_NUMBER))
                                $user->setPhoneNumber(filter_var($data->{UserEnums::PHONE_NUMBER}, FILTER_SANITIZE_STRING));
                            else
                                $user->setPhoneNumber(null);

                            if (property_exists($data, UserEnums::GENDER))
                                $user->setGender(filter_var($data->{UserEnums::GENDER}, FILTER_SANITIZE_STRING));
                            else
                                $user->setGender(null);

                            // Update the user in the database
                            $user->update();
                            http_response_code(StatusCodes::OK);
                        }
                    }
                    else
                    {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        exit("Error: this request does not contain all the mandatory info for full updating a user.");
                    }
                }
                else
                {
                    http_response_code(StatusCodes::UNAUTHORIZED);
                    exit("Error: you are not authorized to update this user's information.");
                }
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: user with id ".$userId." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }

    }

    /*
    *  @Route("/users/{id}")
    *  @Method("PATCH")
    */
    function patchUser($args)
    {
        try
        {
            $data = (object)json_decode(file_get_contents('php://input'), true);

            // Check if the requested user exists
            $userId = $args['id'];
            if (User::userExists($userId) === true)
            {
                // Check whether the person who sent the request is updating their own information
                $user = new User();
                $user->setUserId($userId);
                $user->load();

                if ($user->getEmail() == Token::getEmailFromToken())
                {
                    if (property_exists($data, UserEnums::FIRST_NAME))
                        $user->setFirstName(filter_var($data->{UserEnums::FIRST_NAME}, FILTER_SANITIZE_STRING));

                    if (property_exists($data, UserEnums::LAST_NAME))
                        $user->setLastName(filter_var($data->{UserEnums::LAST_NAME}, FILTER_SANITIZE_STRING));

                    if (property_exists($data, UserEnums::EMAIL))
                    {
                        $email = filter_var($data->{UserEnums::EMAIL}, FILTER_SANITIZE_EMAIL);

                        // Check whether the provided email is already registered
                        if (User::userEmailUsed($email, $user->getUserId()))
                        {
                            http_response_code(StatusCodes::BAD_REQUEST);
                            exit("Error: this email is already used.");
                        }
                        $user->setEmail($email);
                    }

                    if (property_exists($data, UserEnums::PASSWORD))
                        $user->setPassword(filter_var($data->{UserEnums::PASSWORD}, FILTER_SANITIZE_STRING));

                    if (property_exists($data, UserEnums::ZIP_CODE))
                        $user->setZipCode(filter_var($data->{UserEnums::ZIP_CODE}, FILTER_SANITIZE_NUMBER_INT));

                    if (property_exists($data, UserEnums::BIRTHDAY))
                        $user->setBirthday(filter_var($data->{UserEnums::BIRTHDAY}, FILTER_SANITIZE_STRING));

                    if (property_exists($data, UserEnums::PHONE_NUMBER))
                        $user->setPhoneNumber(filter_var($data->{UserEnums::PHONE_NUMBER}, FILTER_SANITIZE_STRING));

                    if (property_exists($data, UserEnums::GENDER))
                        $user->setGender(filter_var($data->{UserEnums::GENDER}, FILTER_SANITIZE_STRING));

                    // Update the user in the database
                    $user->update();
                    http_response_code(StatusCodes::OK);
                }
                else
                {
                    http_response_code(StatusCodes::UNAUTHORIZED);
                    exit("Error: you are not authorized to update this user's information.");
                }
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: user with id ".$userId." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    function deleteUser($args)
    {
        try
        {
            // Check if the requested user exists in the database
            $userId = $args['id'];
            if (User::userExists($userId))
            {
                // Check whether the person who sent the request is an admin role
                if (Token::getRoleFromToken() == Token::ROLE_ADMIN)
                {
                    // Perform the delete operation
                    $user = new User();
                    $user->setUserId($userId);
                    $user->delete();
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
                exit("Error: user with id ".$userId." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }
}