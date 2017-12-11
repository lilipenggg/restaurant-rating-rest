<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:37
 */

namespace Restaurant\Controllers;
use Restaurant\Http\StatusCodes;
use Restaurant\Models\Review;
use Restaurant\Models\Restaurant;
use Restaurant\Utilities\ReviewEnums;
use Restaurant\Models\User;
use Restaurant\Models\Token;
use Restaurant\Utilities\Utilities as u;


class ReviewController
{
    /*
     * @Route("/reviews/{id}")
     * @Method("GET")
     */
    function getReview($args)
    {
        try
        {
            // Check whether the requested review exists in the database
            $id = $args['id'];
            if (Review::reviewExists($id) === true)
            {
                $review = new Review();
                $review->setReviewId($id);
                $review->load();
                return $review;
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: review with id ".$id." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    /*
     * @Route("/reviews")
     * @Method("GET")
     */
    function getReviews()
    {
        try
        {
            $dbh = DatabaseConnection::getInstance();
            $stmtHandle = $dbh->prepare("SELECT `reviewId` FROM `Review`");
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
                while ($id = $stmtHandle->fetch()['reviewId'])
                {
                    $review = new Review();
                    $review->setReviewId($id);
                    $review->load();
                    array_push($arr, $review);
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
     * @Route("/reviews")
     * @Method("POST")
     */
    function postReview()
    {
        try
        {
            $data = (object)json_decode(file_get_contents('php;://input'), true);

            // Make sure that only registered user can post a review
            $userEmail = Token::getEmailFromToken();
            if ($userEmail != null)
            {
                $userId = User::getUserIdByEmail($userEmail);
                if (property_exists($data, ReviewEnums::RATING) &&
                    property_exists($data, ReviewEnums::RESTAURANT_ID) &&
                    property_exists($data, ReviewEnums::REVIEW_CONTENT)
                )
                {
                    // Check if the restaurant that is being reviewed exists in database
                    $restaurantId = filter_var($data->{ReviewEnums::RESTAURANT_ID}, FILTER_SANITIZE_STRING);
                    if (Restaurant::restaurantExists($restaurantId) === true)
                    {
                        // Set all the provided information to the local review object
                        $review = new Review();
                        $review->setRating(filter_var($data->{ReviewEnums::RATING}, FILTER_SANITIZE_NUMBER_INT));
                        $review->setReviewContent(filter_var($data->{ReviewEnums::REVIEW_CONTENT}, FILTER_SANITIZE_STRING));
                        $review->setRestaurantId($restaurantId);

                        // Set hidden field for review object
                        $review->setReviewId(u::unique_id());
                        $review->setUserId($userId);

                        // Create the review in database
                        $review->create();
                        http_response_code(StatusCodes::CREATED);
                    }
                    else
                    {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        exit("Error: restaurant with id ".$restaurantId." does not exist in the database.");
                    }
                }
                else
                {
                    http_response_code(StatusCodes::BAD_REQUEST);
                    exit("Error: this request does not contain all the mandatory info for creating a review.");
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
     * @Route("/reviews/{id}")
     * @Method("PUT")
     */
    function putReview($args)
    {
        try
        {
            $data = (object)json_decode(file_get_contents('php://input'), true);

            // Check whether the review exists in the database
            $id = $args['id'];
            if (Review::reviewExists($id) === true)
            {
                $review = new Review();
                $review->setReviewId($id);
                $review->load();

                // Check whether the review is being updated by the person who post it
                if ($review->getUserId() == User::getUserIdByEmail(Token::getEmailFromToken()))
                {
                    // Allow user to only update rating and review content
                    if (property_exists($data, ReviewEnums::RATING) &&
                        property_exists($data, ReviewEnums::REVIEW_CONTENT)
                    )
                    {
                        $review->setRating(filter_var($data->{ReviewEnums::RATING}, FILTER_SANITIZE_NUMBER_INT));
                        $review->setReviewContent(filter_var($data->{ReviewEnums::REVIEW_CONTENT}, FILTER_SANITIZE_STRING));

                        // Update the review in database
                        $review->update();
                        http_response_code(StatusCodes::OK);
                    }
                    else
                    {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        exit("Error: this request does not contain all the mandatory info for full updating a review.");
                    }
                }
                else
                {
                    http_response_code(StatusCodes::UNAUTHORIZED);
                    exit("Error: you are not authorized to update this review.");
                }
            }
            else
            {
                http_response_code(StatusCodes::BAD_REQUEST);
                exit("Error: review with id ".$id." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }

    /*
     * @Route("/reviews/{id}")
     * @Method("PATCH")
     */
    function patchReview($args)
    {
        try
        {
            $data = (object)json_decode(file_get_contents('php://input'), true);

            // Check whether the review exists in the database
            $id = $args['id'];
            if (Review::reviewExists($id) === true)
            {
                $review = new Review();
                $review->setReviewId($id);
                $review->load();

                // Check whether the review is being updated by the person who post it
                if ($review->getUserId() == User::getUserIdByEmail(Token::getEmailFromToken()))
                {
                    if (property_exists($data, ReviewEnums::RATING))
                        $review->setRating(filter_var($data->{ReviewEnums::RATING}, FILTER_SANITIZE_NUMBER_INT));

                    if (property_exists($data, ReviewEnums::REVIEW_CONTENT))
                        $review->setReviewContent(filter_var($data->{ReviewEnums::REVIEW_CONTENT}, FILTER_SANITIZE_STRING));

                    // Update the review in the database
                    $review->update();
                    http_response_code(StatusCodes::OK);
                }
                else
                {
                    http_response_code(StatusCodes::UNAUTHORIZED);
                    exit("Error: you are not authorized to update this review.");
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
     * @Route("/reviews/{id}")
     * @Method("DELETE")
     */
    function deleteReview($args)
    {
        try
        {
            // Check whether this review exists in the database
            $id = $args['id'];
            if (Review::reviewExists($id) === true)
            {
                $review = new Review();
                $review->setReviewId($id);
                $review->load();

                // Make sure the review can only be deleted by admin or the person who posted it
                if ($review->getUserId() == User::getUserIdByEmail(Token::getEmailFromToken()) || Token::getRoleFromToken() == Token::ROLE_ADMIN)
                {
                    // Delete the review
                    $review->delete();
                    http_response_code(StatusCodes::OK);
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
                exit("Error: review with id ".$id." does not exist in the database.");
            }
        }
        catch (\Exception $e)
        {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit($e->getMessage());
        }
    }
}