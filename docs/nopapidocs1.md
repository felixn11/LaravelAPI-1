FORMAT: 1A

# nopapidocs1

# AppHttpControllersLessonsController
Class LessonsController

## Show all lessons [GET /api/v1/lessons]
Get a JSON representation of all the lessons.

+ Request (application/json)
    + Headers

            Authorization: Bearer TOKEN_HERE
            paginate: 

## Get a specific lesson [GET /api/v1/lessons/{id}]
Get a JSON representation of a specific lesson.

+ Request (application/json)
    + Headers

            Authorization: Bearer eyxxxxx
            contentType: application/json

# Authenticate [/auth]
Class AuthenticateController

## Login a user [POST /auth/login]
Returns a JSON web token. Use this token to make calls to the different endpoints

+ Request (application/json)
    + Headers

            email: 
            password: 

+ Response 200 (application/json)
    + Headers

            token: FooBar