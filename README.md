# Restaurant Rating Review API
The Restaurant Rating Review RESTful API system will allow users to create, update, and delete their own reviews for restaurants. In order to for the user to create, update, and delete their own reviews, they will have to create an account in the system first. However, both of the non-registered and registered users will be able to read and filter all the reviews by ratings, and both types of users can view all the restaurant information, but only registered user can create, update, and delete their own restaurants in the system. Registered users also have the ability to view and update their own personal information.

## Guidelines

This documentation provides guidelines and examples for using Restaurant Rating Review APIs.

## Request & Response Examples

### API Resources

  - [POST /tokens](#post-tokens)
  
  - [GET /users](#get-users)
  - [GET /users/[id]](#get-usersid)
  - [POST /users](#post-users)
  - [PUT /users/[id]](#put-users)
  - [PATCH /users/[id]](#patch-users)
  - [DELETE /users/[id]](#delete-users)
  
  - [GET /restaurants](#get-restaurants)
  - [GET /restaurants/[id]](#get-restaurants)
  - [POST /restaurants](#post-restaurants)
  - [PUT /restaurants/[id]](#put-restaurants)
  - [PATCH /restaurants/[id]](#patch-restaurants)
  - [DELETE /restaurants/[id]](#delete-restaurants)
  
  - [GET /reviews](#get-reviews)
  - [GET /reviews/[id]](#get-reviews)
  - [POST /reviews](#post-reviews)
  - [PUT /reviews/[id]](#put-reviews)
  - [PATCH /reviews/[id]](#patch-reviews)
  - [DELETE /reviews/[id]](#delete-reviews)

### POST /tokens

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/tokens

Resquest body:

    {
        "email": "admin@gmail.com",
        "password": "newPassw0rd!"
    }

Response body:

    "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8"
    
Note: 
   In order to retrieve a token with username and password, you will need to send the POST /users request to create a user in the system first. The admin user in this example actually exists.
    
### GET /users

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/users

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Response body:

    [
    {
        "UserId": "317002676",
        "FirstName": "Jean",
        "LastName": "Doe",
        "Email": "jeandoe@gmail.com",
        "ZipCode": "84401",
        "Birthday": null,
        "PhoneNumber": "8017773333",
        "Gender": "Male",
        "UserType": "Regular"
    },
    {
        "UserId": "578524206",
        "FirstName": "John",
        "LastName": "Doe",
        "Email": "johndoe@gmail.com",
        "ZipCode": "84401",
        "Birthday": null,
        "PhoneNumber": "8012223333",
        "Gender": "Male",
        "UserType": "Regular"
    },
    {
        "UserId": "695306068",
        "FirstName": "Admin",
        "LastName": "User",
        "Email": "admin@gmail.com",
        "ZipCode": "84401",
        "Birthday": null,
        "PhoneNumber": "8012223333",
        "Gender": "Female",
        "UserType": "Admin"
    }
    ]
    
Note: 
only admin type user can retrieve all the users infomation.

### GET /users/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/users/695306068

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Response body:

    {
        "UserId": "695306068",
        "FirstName": "Admin",
        "LastName": "User",
        "Email": "admin@gmail.com",
        "ZipCode": "84401",
        "Birthday": null,
        "PhoneNumber": "8012223333",
        "Gender": "Female",
        "UserType": "Admin"
    }

Note: 
Only the user themselves can retrieve their own information, otherwise the request is unauthorized.


### POST /users

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/users

Request body:

    {
        "FirstName": "John",
        "LastName": "Doe",
        "Email": "johndoe@gmail.com",
        "ZipCode": "84401",
        "PhoneNumber": "8012223333",
        "Gender": "Male",
        "Password": "newPassw0rd!"
    }

Note:
The email used for create a new user account cannot be used by other existing user in the system, otherwise the request will return an error and the new user will not be created successfully.
With sending POST request to create a user account, the default user type will be set to Regular.

### PUT /users/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/users/695306068

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Request body:

    {
        "FirstName": "Johnny",
        "LastName": "Doe",
        "Email": "johndoe@gmail.com",
        "ZipCode": "84403",
        "PhoneNumber": "8012345678",
        "Gender": "Male",
        "Password": "newPassw0rd!"
    }

Note: 
Token is required to send with the request.
Only the user themselves can update their own information, otherwise the request is unauthorized. Also, the email used for updating cannot be used by other users in the system. In other word, emails are unique identifier for users.
When any of the required field is not included in the json body, the request will not be successful. Other optional fields that are not sent with the request will be setting to null.
IMPORTANT: When you update the password with this request, you will need to regernerate a token from sending the POST /token request.


### PATCH /users/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/users/695306068

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Request body:

    {
        "FirstName": "Johnny",
        "LastName": "Doe",
        "Email": "johndoe@gmail.com",
        "ZipCode": "84403",
        "PhoneNumber": "8012345678",
        "Gender": "Male",
        "Password": "newPassw0rd!"
    }

Note: 
Token is required to send with the request.
Only the user themselves can update their own information, otherwise the request is unauthorized. Also, the email used for updating cannot be used by other users in the system. In other word, emails are unique identifier for users.
With patch request, users can choose to only send the fields that they want to update in the request, the other fields that are not included will stay the same.
IMPORTANT: When you update the password with this request, you will need to regernerate a token from sending the POST /token request.


### DELETE /users/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/users/695306068

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Note: 
Token is required to send with the request.
Only the admin user can perform the delete operation.
When the user is being deleted, the reviews and restaurants associated with it will be deleted as well.


### GET /restaurants

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/restaurants


Response body:

    [
        {
            "RestaurantId": "206459621",
            "Name": "Hearth on 25th",
            "PhoneNumber": "(801) 399-0088",
            "Address": "195 25th Street",
            "SecondAddress": null,
            "City": "Ogden",
            "State": "UT",
            "ZipCode": "84401",
            "Website": null,
            "UserId": "283422970"
        },
        {
            "RestaurantId": "306536309",
            "Name": "The House",
            "PhoneNumber": "(415) 986-8612",
            "Address": "1230 Grant Ave",
            "SecondAddress": null,
            "City": "San Francisco",
            "State": "CA",
            "ZipCode": "94133",
            "Website": "thehse.com",
            "UserId": "283422970"
        },
        {
            "RestaurantId": "532427260",
            "Name": "Fog Harbor Fish House",
            "PhoneNumber": "(415) 421-2442",
            "Address": "Fishermans Wharf, North Beach Hill",
            "SecondAddress": "Pier 39",
            "City": "San Francisco",
            "State": "CA",
            "ZipCode": "94133",
            "Website": null,
            "UserId": "844857169"
        },
        {
            "RestaurantId": "717365228",
            "Name": "The House Full of Food",
            "PhoneNumber": "(415) 986-8612",
            "Address": "1230 Grant Ave",
            "SecondAddress": null,
            "City": "San Francisco",
            "State": "CA",
            "ZipCode": "94133",
            "Website": "thehse.com",
            "UserId": "283422970"
        }
    ]
    
Note: 
This request can be sent without token. Both registered and non-registered users can retrieve all the restaurant information.


### GET /restaurants/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/restaurants/532427260


Response body:

    {
        "RestaurantId": "532427260",
        "Name": "Fog Harbor Fish House",
        "PhoneNumber": "(415) 421-2442",
        "Address": "Fishermans Wharf, North Beach Hill",
        "SecondAddress": "Pier 39",
        "City": "San Francisco",
        "State": "CA",
        "ZipCode": "94133",
        "Website": null,
        "UserId": "844857169"
    }

Note: 
This request can be sent without token. Both registered and non-registered user can retrieve a particular restaurant information.


### POST /restaurants

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/restaurants


Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8


Request body:

    {
        "Name": "Slackwater Pub & Pizzeria",
        "PhoneNumber": "(801) 399-0637",
        "Address": "1895 Washington Blvd",
        "City": "Ogden",
        "State": "UT",
        "ZipCode": "84401"
    }

Note:
This request will have to be sent with a token because only registered user can create a restaurant in the system.
All the required fields are needed to be filled out, otherwise the request will not be successful.
The required fields are Name, PhoneNumber, Address, City, State, and ZipCode.


### PUT /restaurants/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/restaurants/216004616

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Request body:

    {
        "Name": "Pig and a Jelly Jar",
        "PhoneNumber": "(415) 986-8612",
        "Address": "1230 Grant Ave",
        "City": "San Francisco",
        "State": "CA",
        "ZipCode": "94133",
        "Website": "thehse.com"
    }

Note: 
Token is required to send with the request.
Only the user who created the restaurant is able to update the restaurant information, otherwise it will return an unauthorized response code.
When any of the required field is not included in the json body, the request will not be successful. Other optional fields that are not sent with the request will be setting to null.


### PATCH /restaurants/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/restaurants/206459621

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Request body:

    {
        "Website": "pigandjelly.com"
    }

Note: 
Token is required to send with the request.
Only the user themselves can update their own information, otherwise the request is unauthorized. 
With patch request, users can choose to only send the fields that they want to update in the request, the other fields that are not included will stay the same.


### DELETE /restaurants/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/restaurants/254011894

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Note: 
Token is required to send with the request.
Only the admin user or the user who created the restaurant can perform the delete operation.
When the restaurant is being deleted, the reviews associated with it will be deleted as well.


### GET /reviews

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/reviews


Response body:

    [
        {
        "ReviewId": "102973372",
        "Rating": "1",
        "RestaurantId": "532427260",
        "ReviewContent": "This is a really fantastic restaurant, really good food and service.",
        "UserId": "844857169"
    },
    {
        "ReviewId": "128254907",
        "Rating": "2",
        "RestaurantId": "352629251",
        "ReviewContent": "The worst restaurant I have ever been!! but the service is good, food is awful!! Don&#39;t go!",
        "UserId": "578524206"
    },
    {
        "ReviewId": "175848080",
        "Rating": "5",
        "RestaurantId": "532427260",
        "ReviewContent": "Great Food, Great Service.Came in here for lunch on a work day. I ordered Kim Bop, and Suntofu Soup. There isn&#39;t much to say except that the food was excellent, the sides were delicious, the soup was filling, savory and spicy, the Kim bop was the best I&#39;ve had. It was just a great meal. I will definitely be back soon.",
        "UserId": "578524206"
    },
    {
        "ReviewId": "621613249",
        "Rating": "3",
        "RestaurantId": "306536309",
        "ReviewContent": "A little bit pricy. but great experience in general!",
        "UserId": "578524206"
    },
    {
        "ReviewId": "630374179",
        "Rating": "3",
        "RestaurantId": "532427260",
        "ReviewContent": "I like the food here, but there is improvement to be made.",
        "UserId": "844857169"
    },
    {
        "ReviewId": "651081393",
        "Rating": "5",
        "RestaurantId": "206459621",
        "ReviewContent": "Great Food, Great Service. I will definitely be back soon.",
        "UserId": "578524206"
    },
    {
        "ReviewId": "836263070",
        "Rating": "4",
        "RestaurantId": "254667598",
        "ReviewContent": "Good restaurant!",
        "UserId": "578524206"
    },
    {
        "ReviewId": "876654966",
        "Rating": "2",
        "RestaurantId": "254667598",
        "ReviewContent": "I love this place, this is my favorite restaurant! highly recommend",
        "UserId": "578524206"
    }
    ]
    
Note: 
This request can be sent without token. Both registered and non-registered users can retrieve all the reviews.


### GET /reviews?ratings=3+

This endpoint provides a ability to the user to filter the reviews based on rating stars.

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/reviews?ratings=3+


Response body:

    [
        {
            "ReviewId": "175848080",
            "Rating": "5",
            "RestaurantId": "532427260",
            "ReviewContent": "Great Food, Great Service.Came in here for lunch on a work day. I ordered Kim Bop, and Suntofu Soup. There isn&#39;t much to say except that the food was excellent, the sides were delicious, the soup was filling, savory and spicy, the Kim bop was the best I&#39;ve had. It was just a great meal. I will definitely be back soon.",
            "UserId": "578524206"
        },
        {
            "ReviewId": "621613249",
            "Rating": "3",
            "RestaurantId": "306536309",
            "ReviewContent": "A little bit pricy. but great experience in general!",
            "UserId": "578524206"
        },
        {
            "ReviewId": "630374179",
            "Rating": "3",
            "RestaurantId": "532427260",
            "ReviewContent": "I like the food here, but there is improvement to be made.",
            "UserId": "844857169"
        },
        {
            "ReviewId": "651081393",
            "Rating": "5",
            "RestaurantId": "206459621",
            "ReviewContent": "Great Food, Great Service. I will definitely be back soon.",
            "UserId": "578524206"
        },
        {
            "ReviewId": "836263070",
            "Rating": "4",
            "RestaurantId": "254667598",
            "ReviewContent": "Good restaurant!",
            "UserId": "578524206"
        }
    ]
    
Note: 
This request can be sent without token. 
Both registered and non-registered users can retrieve all the reviews.
The filter of the reviews will accept any integer between 1 and 9 with or without plus or minus sign.
example: /reviews?ratings=3+ means that return all the reviews with ratings greater or equal to 3, 
/reviews?ratings=3- means that return all the reviews with ratings less or equal to 3,
/reviews?ratings=3 means that return all the reviews with rating equals to 3.


### GET /reviews/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/reviews/175848080


Response body:

    {
        "ReviewId": "175848080",
        "Rating": "5",
        "RestaurantId": "532427260",
        "ReviewContent": "Great Food, Great Service.Came in here for lunch on a work day. I ordered Kim Bop, and Suntofu Soup. There isn&#39;t much to say except that the food was excellent, the sides were delicious, the soup was filling, savory and spicy, the Kim bop was the best I&#39;ve had. It was just a great meal. I will definitely be back soon.",
        "UserId": "578524206"
    }

Note: 
This request can be sent without token. 
Both registered and non-registered user can retrieve a particular review information.


### POST /reviews

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/reviews


Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8


Request body:

    {
        "Rating": "4",
        "ReviewContent": "Good restaurant!",
        "RestaurantId": "254667598"
    }

Note:
This request will have to be sent with a token because only registered user can post a review for a restaurant.
All the required fields are needed to be filled out, otherwise the request will not be successful.
The required fields are Rating, ReviewContent, and RestaurantId.


### PUT /reviews/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/reviews/102973372

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Request body:

    {
        "Rating": "5",
        "ReviewContent": "This is a really fantastic restaurant, really good food and service.",
        "RestaurantId": "532427260"
    }

Note: 
Token is required to send with the request.
Only the user who posted the review is able to update the review, otherwise it will return an unauthorized response code.
When any of the required field is not included in the json body, the request will not be successful.


### PATCH /reviews/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/reviews/630374179

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Request body:

    {
        "Rating": "1"
    }

Note: 
Token is required to send with the request.
Only the user themselves who posted the review can update their own reviews, otherwise the request is unauthorized. 
With patch request, users can choose to only send the fields that they want to update in the request, the other fields that are not included will stay the same.


### DELETE /reviews/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/reviews/630374179

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Note: 
Token is required to send with the request.
Only the admin user or the user who posted the review can perform the delete operation.

