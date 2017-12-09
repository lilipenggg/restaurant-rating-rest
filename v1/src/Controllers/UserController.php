<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:37
 */

namespace Restaurant\Controllers;
use \Restaurant\Models\User;


class UserController
{
    /*
     * @Route("/users/{id}")
     * @Method("GET")
     */
    function getUser($args)
    {
        $userId = $args['id'];
        if (User::userExists($userId) === true)
        {
            // Check whether the person who send the request is retrieving their own information
            $user = new User();
            $user->setUserId($userId);
            $user->load();
        }
        else
        {

        }
    }

    function getUsers()
    {

    }

    function postUser()
    {

    }

    function putUser($args)
    {

    }

    function patchUser($args)
    {

    }

    function deleteUser($args)
    {

    }
}