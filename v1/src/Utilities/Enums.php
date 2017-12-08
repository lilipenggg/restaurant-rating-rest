<?php
/**
 * Created by PhpStorm.
 * User: lilipeng
 * Date: 12/7/17
 * Time: 18:56
 */

namespace Restaurant\Utilities;


class UserEnums
{
    const USER_ID = "UserId";
    const FIRST_NAME = "FirstName";
    const LAST_NAME = "LastName";
    const EMAIL = "Email";
    const PASSWORD = "Password";
    const ZIP_CODE = "ZipCode";
    const BIRTHDAY = "Birthday";
    const PHONE_NUMBER = "PhoneNumber";
    const GENDER = "Gender";
    const USER_TYPE = "UserType";
}

class RestaurantEnums
{
    const RESTAURANT_ID = "RestaurantId";
    const NAME = "Name";
    const PHONE_NUMBER = "PhoneNumber";
    const DESCRIPTION = "Description";
    const ADDRESS = "Address";
    const WEBSITE = "Website";
    const USER_ID = "UserId";
}

class ReviewEnums
{
    const REVIEW_ID = "ReviewId";
    const RATING = "Rating";
    const RESTAURANT_ID = "RestaurantId";
    const REVIEW_CONTENT = "ReviewContent";
    const USER_ID = "UserId";
}