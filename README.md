# Endpoints

Here is a list of endpoints we will use.

## User
```
GET /users/oauth
 
Open this url in a popup.

Headers
  //nothing required

Sent to server
  //nothing
  
Response from server
  //just sends the user to login via twitter
```

```
When we get a response from twitter it will then redirect back to the frontend sending the access-token as a url parameter. The frontend
will then store the access-token in local storage and close that popup window.
```

```
GET /users/status
 
Get the current user logged in

Headers
  {
    access-token: 'akldfjaldfjaldkfasdlfasdlfajldks'
  }
  
Sent to server
  //nothing
  
Response from server
  {
    user: {
      name: "twitterhandle",
      picture: "http:twitteruserpictureurl"
    }
  }
```

## Tweets
```
GET /tweets
 
Get the list of tweets the user has scheduled

Headers
  {
    access-token: 'akldfjaldfjaldkfasdlfasdlfajldks'
  }
  
Sent to server
  //nothing
  
Response from server
  {
    tweets: [
      {
        id: 123,
        message: "This is my first scheduled tweet",
        scheduled: "2016-06-06 12:21:00",
        status: "scheduled", //options will be "scheduled" and "posted"
        created_at: "2016-06-01 15:32:12"
      },
      {
        id: 124,
        message: "This is my second scheduled tweet",
        scheduled: "2016-06-07 12:21:00",
        status: "scheduled", //options will be "scheduled" and "posted"
        created_at: "2016-06-01 15:35:12"
      }
    ]
  }
```

```
GET /tweets/{id}
 
Get a single scheduled tweet

Headers
  {
    access-token: 'akldfjaldfjaldkfasdlfasdlfajldks'
  }
  
Sent to server
  //nothing
  
Response from server
  200 RESPONSE
  {
    tweet: {
      id: 123,
      message: "This is my first scheduled tweet",
      scheduled: "2016-06-06 12:21:00",
      status: "scheduled", //options will be "scheduled" and "posted"
      created_at: "2016-06-01 15:32:12"
    }
  }
  403 RESPONSE
  {
    errors: [
      "Access denied"
    ]
  }
```

```
POST /tweets
 
Create a new scheduled tweet

Headers
  {
    access-token: 'akldfjaldfjaldkfasdlfasdlfajldks'
  }
  
Sent to server
  {
    tweet: {
      message: "This is my first scheduled tweet",
      scheduled: "2016-06-06 12:21:00"
    }
  }
  
Response from server
  200 RESPONSE
  {
    tweet: {
      id: 123,
      message: "This is my first scheduled tweet",
      scheduled: "2016-06-06 12:21:00",
      status: "scheduled", //options will be "scheduled" and "posted"
      created_at: "2016-06-01 15:32:12"
    }
  }
  400 RESPONSE
  {
    errors: [
      'A message is required.', 'The scheduled date must be in the future'
    ]
  }
```

```
PUT /tweets/{id}
 
Update a scheduled tweet

Headers
  {
    access-token: 'akldfjaldfjaldkfasdlfasdlfajldks'
  }
  
Sent to server
  {
    tweet: {
      message: "This is my updated first scheduled tweet",
      scheduled: "2016-06-06 12:21:00"
    }
  }
  
Response from server
  200 RESPONSE
  {
    tweet: {
      id: 123,
      message: "This is my updated first scheduled tweet",
      scheduled: "2016-06-06 12:21:00",
      status: "scheduled", //options will be "scheduled" and "posted"
      created_at: "2016-06-01 15:32:12"
    }
  }
  400 RESPONSE
  {
    errors: [
      'A message is required.', 'The scheduled date must be in the future'
    ]
  }
```

```
DELETE /tweets/{id}
 
Delete a scheduled tweet

Headers
  {
    access-token: 'akldfjaldfjaldkfasdlfasdlfajldks'
  }
  
Sent to server
  //nothing
  
Response from server
  200 RESPONSE
  //blank
  403 RESPONSE
  {
    errors: [
      "Access denied"
    ]
  }
```