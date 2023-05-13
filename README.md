<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## HOW TO RUN THIS PROJECT
for your information, im using laravel with composer.
1. clone or download this project from here
2. run composer update
3. Rename .env.examples to .env
4. run php artisan key:generate
5. set up the database like dbname and etc
6. run php artisan migrate, or u can use the market_place.sql file instead (skip number 7 step)
7. set up indoregion data to get province and region data, u can see at https://github.com/azishapidin/indoregion
8. set up some packages,
    add this following code to .env file :
    
    MIDTRANS_SERVER_KEY="SB-Mid-server-NaAKI9fj8xruf5EowZn2BP56"
    
    MIDTRANS_CLIENT_KEY="SB-Mid-client-2Y-DEuymXOjp9zE6"
    
    MIDTRANS_IS_PRODUCTION=false
    
    MIDTRANS_IS_SANITIZED=true
    
    MIDTRANS_IS_3DS=true

    JWT_SECRET=LHGUUZquDevmytWyC7Bhj7ZNDDjr7XaQmbKPg2fGZeXE0jlBJKknA0Io0RJMaUYY
9. run php artisan serve :)
u can run the admin menu by change the users role to ADMIN.

here some pics of my laravel program
[https://drive.google.com/file/d/1-Co-996EH8etGKu2ABo0ohkm4oZvZCmG/view?usp=share_link](https://drive.google.com/drive/folders/14DslI8yrInunbNVzPzV40xkPmGQMFP9K?usp=share_link)
api documentation
https://documenter.getpostman.com/view/9865674/2s93ecwAHH
