# Restaurant Rating Review API
The Restaurant Rating Review RESTful API system will allow users to create, update, and delete their own reviews for restaurants. In order to for the user to create, update, and delete their own reviews, they will have to create an account in the system first. However, both of the non-registered and registered users will be able to read and filter all the reviews by ratings, and both types of users can view all the restaurant information, but only registered user can create, update, and delete their own restaurants in the system. Registered users also have the ability to view and update their own personal information.

## Guidelines

This documentation provides guidelines and examples for using Restaurant Rating Review APIs.

## Request & Response Examples

### API Resources

  - [POST /tokens](#post-tokens)
  
  - [GET /users](#get-magazines)
  - [GET /users/[id]](#get-magazinesid)
  - [POST /users](#post-magazinesidarticles)
  - [PUT /users/[id]](#post-magazinesidarticles)
  - [PATCH /users/[id]](#post-magazinesidarticles)
  - [DELETE /users/[id]](#post-magazinesidarticles)
  
  - [GET /restaurants](#post-magazinesidarticles)
  - [GET /restaurants/[id]](#post-magazinesidarticles)
  - [POST /restaurants](#post-magazinesidarticles)
  - [PUT /restaurants/[id]](#post-magazinesidarticles)
  - [PATCH /restaurants/[id]](#post-magazinesidarticles)
  - [DELETE /restaurants/[id]](#post-magazinesidarticles)
  
  - [GET /reviews](#post-magazinesidarticles)
  - [GET /reviews/[id]](#post-magazinesidarticles)
  - [POST /reviews](#post-magazinesidarticles)
  - [PUT /reviews/[id]](#post-magazinesidarticles)
  - [PATCH /reviews/[id]](#post-magazinesidarticles)
  - [DELETE /reviews/[id]](#post-magazinesidarticles)

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


### DELETE /users/[id]

Example: http://icarus.cs.weber.edu/~lp54326/restaurant-rating-rest/v1/users/695306068

Resquest header:

    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MTMxMzU4NDEsImp0aSI6IjVhMzA5ZWUxNTQ1MmQyLjg0MzM1NTAxIiwiaXNzIjoiaHR0cDpcL1wvaWNhcnVzLmNzLndlYmVyLmVkdSIsIm5iZiI6MTUxMzEzNTg0MSwiZXhwIjoxNTEzMTM5NDQxLCJkYXRhIjp7ImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIiwicm9sZSI6IkFkbWluIn19.26px1-kwlspb94pLcuEIBkGylKiBJ_CJI5mY_FjP9M8

Note: 
Token is required to send with the request.
Only the admin user can perform the delete operation.


## Mock Responses
It is suggested that each resource accept a 'mock' parameter on the testing server. Passing this parameter should return a mock data response (bypassing the backend).

Implementing this feature early in development ensures that the API will exhibit consistent behavior, supporting a test driven development methodology.

Note: If the mock parameter is included in a request to the production environment, an error should be raised.


## JSONP

JSONP is easiest explained with an example. Here's one from [StackOverflow](http://stackoverflow.com/questions/2067472/what-is-jsonp-all-about?answertab=votes#tab-top):

> Say you're on domain abc.com, and you want to make a request to domain xyz.com. To do so, you need to cross domain boundaries, a no-no in most of browserland.

> The one item that bypasses this limitation is `<script>` tags. When you use a script tag, the domain limitation is ignored, but under normal circumstances, you can't really DO anything with the results, the script just gets evaluated.

> Enter JSONP. When you make your request to a server that is JSONP enabled, you pass a special parameter that tells the server a little bit about your page. That way, the server is able to nicely wrap up its response in a way that your page can handle.

> For example, say the server expects a parameter called "callback" to enable its JSONP capabilities. Then your request would look like:

>         http://www.xyz.com/sample.aspx?callback=mycallback

> Without JSONP, this might return some basic javascript object, like so:

>         { foo: 'bar' }

> However, with JSONP, when the server receives the "callback" parameter, it wraps up the result a little differently, returning something like this:

>         mycallback({ foo: 'bar' });

> As you can see, it will now invoke the method you specified. So, in your page, you define the callback function:

>         mycallback = function(data){
>             alert(data.foo);
>         };

http://stackoverflow.com/questions/2067472/what-is-jsonp-all-about?answertab=votes#tab-top
