FORMAT: 1A

# AppHttpControllersLessonsController
Class LessonsController

## Show all lessons [GET /api/v1/lessons]
Get a JSON representation of all the lessons.

+ Request (application/json)
    + Headers

            Authorization: Bearer TOKEN_HERE
            Paginate: 

## Get a specific lesson [GET /api/v1/lessons/{id}]
Get a JSON representation of a specific lesson.

+ Request (application/json)
    + Headers

            Authorization: Bearer eyxxxxx

## Update a specific lesson [PUT /api/v1/lessons/{id}]
Give ID of a lesson as URL parameter and add title and body info so it get's updated

+ Request (application/json)
    + Headers

            Authorization: Bearer eyxxxxx
            title: 
            body: 

## Add a specific lesson [POST /api/v1/lessons]
Add a lesson with title and body to API

+ Request (application/json)
    + Headers

            Authorization: Bearer eyxxxxx
            title: 
            body: 

# Authenticate [/auth]
Class AuthenticateController
# nopapidocs1


## Login a user [POST /auth/login]
Returns a JSON web token. Use this token to make calls to the different endpoints

+ Request (application/json)
    + Headers

            email: 
            password: 

+ Response 200 (application/json)
    + Headers

            token: FooBar