

# Mobile Application Subscription Management


## Technology & Design Details
 - Database:Mysql
 - PHP :Laravel 8.0 php 7:3
 - Laravel Code Design  Architecture:Repository
 - Coding Design Pattern:SOLID Principles
 - Nginx Webserver
 - Docker:Microservice Architecture
 - Redis:Queue ,caching & Scheduler Management
 - Jenkins:CI/CD Pipeline Management
 - AWS S3 :Data Backup Technologies 
 - Azure Blob Storage : Azure File Storage Technologies

## Project Dependencies
 - linux server
 - Docker Setup:Only if you want to containerize your app.
 - Docker-compose: This is used to manage all your containers in a single host VM
 - Apache Server :This is needed when  going non docker approach.
 - Mysql client : This is also needed to manage our data when going non docker approach.
 - Supervisord : to mange our jobs when going non docker approach
 - composer :For laravel artisan commands 

## General Process
 - Git clone Repository into your local path
 - navigate into your clone repository using your terminal

## Project Implementation Method
 - Docker
 - Non Docker
 
### 1.Docker
#### Containers
 - Redis
 - Mysql
 - Teknasyon app
 - Queue Processor
 - Nginx Web server
 - scheduler Processor
 - Remote-host

#### NB
  - Make sure you have docker & docker-compose  installed on your local machine or  on the cloud server
 
  - After completing the General process steps, type 'docker-compose up -d 'in the terminal. Docker images will start building for the containers to start
  - Type docker ps from terminal to see all 7 containers 
  - Navigate into docker container app using command "docker exec -ti app bash", if all containers are built successfully
  - Run  cp .env.example .env from the terminal 
  - Run composer install
  - Run php artisan key:generate
  - configure necessary .env variables
  

### 2.Non Docker
#### apps
 
 - Mysql
 - Teknasyon app

#### NB
 - Make sure you have apache , mysql & composer  installed on your local machine or  on the cloud server
 
  - After completing the General process steps.
  - Run  cp .env.example .env from the terminal 
  - Run composer install
  - Run php artisan key:generate
  - configure necessary .env variable
  - php artisan migrate
  - php artisan serve
 
## Project Features

  - User Account:This is a feature that validate the user when signing into their google App store or apple store which after user verification all subscriptions of the user is returned to the device.
  - Register :This feature registers the device and generate a token to the device and saves the device info into the device table.
  - Purchase : This feature manages and verifys  all in app purchases
  - Check Subscription - This API checks for the current subscriptions status
  - Report - This API provides reporting on subscriptions based on day,app and status  
  
### Acoount

###### API Details

  - http://127.0.0.1:8000/api/auth/user/account
  - This is where you pass your google or ios plaform account credentials for authentication into app store
  headers{
  username:""
  password:""
  }
   
  - body:{
           "platform":"ios"
           }
           
###### Response

  - Success :{
                 "data": {
                     "userUID": "62a42e20-5fdf-11eb-b9da-1bf5881e2dc2",
                     "listSubscriptions": []
                 },
                 "Success": true,
                 "statuscode": 200
             }
  - failure :{
                 "data": "Unauthorized",
                 "Success": false,
                 "statuscode": 401
             }

 
 ### Register
 
 ###### API Details
 
   - http://127.0.0.1:8000/api/device/register
   - payload/boy {
      "os":"ios",
      "uid":"4493ffj44iicfj32cjjdjc94jf4f",
      "language":"en",
      "appID":"io.3music.com",
      "userUID":"62a42e20-5fdf-11eb-b9da-1bf5881e2dc2"
      }
            
 ###### Response
 
   - Success :{
                 {
                     "data": {
                         "client_token": "45a113ac-c7f2-30b0-90a5-a399ab912716"
                     },
                     "Success": true,
                     "statuscode": 200
                 }
   - failure :{
                  "data": "Error",
                  "Success": false,
                  "statuscode": 500
              }
 
 ### Purchase
  
  ###### API Details
  
    {
        "client_token": "45a113ac-c7f2-30b0-90a5-a399ab912716",
        "reciept":"55889433df92djcjd4923zx93"
    }
             
  ###### Response
  
    - Success :{
                  {
                      "data": {
                          "client_token": "45a113ac-c7f2-30b0-90a5-a399ab912716"
                      },
                      "Success": true,
                      "statuscode": 200
                  }
    - failure :{
                   "data": "Error",
                   "Success": false,
                   "statuscode": 500
               }
  
  
  




