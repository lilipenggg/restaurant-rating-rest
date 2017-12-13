<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:38
 */

namespace Restaurant\Controllers;
use \Restaurant\Models\User;
use \Restaurant\Models\Token;
use Restaurant\Utilities\DatabaseConnection;
use Restaurant\Http\StatusCodes;

class TokenController
{
    public function buildToken(string $email, string $password)
    {
        // Workaround for not using a server default account
        $dbh  = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("SELECT `password`, `userType` FROM `User` WHERE `email` = :email");
        $stmtHandle->bindValue(":email", $email);

        $stmtHandle->setFetchMode(\PDO::FETCH_ASSOC);
        $success = $stmtHandle->execute();

        if ($success === false)
        {
            http_response_code(StatusCodes::INTERNAL_SERVER_ERROR);
            exit("Error: SQL query execution failed.");
        }
        else
        {
            if ($stmtHandle->rowCount() != 0)
            {
                $data = $stmtHandle->fetch();

                // Check whether the password matches
                if (password_verify($password, $data['password']))
                {
                    $role = $data['userType'];
                    return (new Token())->buildToken($email, $role);
                }
                else
                {
                    http_response_code(StatusCodes::UNAUTHORIZED);
                    exit("Error: you're not authorized.");
                }
            }
            else
            {
                http_response_code(StatusCodes::FORBIDDEN);
                exit("Error: your credentials were rejected by the server.");
            }
        }
    }
}