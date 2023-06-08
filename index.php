<?php
require_once 'core.php';
require_once 'functions.php';
require_once __DIR__ . '/router.php';

// ##################################################
// ##################################################
// ##################################################

// Static GET
// In the URL -> http://localhost
// The output -> Index

get('/', 'views/index.php');
get('/login', 'views/login.php');
get('/register', 'views/register.php');
get('/my-account', 'views/dashboard/my-account.php');
get('/reception', 'views/dashboard/reception.php');
get('/logout', function (){
    logout();
});

post('/login', function () {
    login();
    include 'views/login.php';
});
post('/register', function () {
    register();
    include 'views/register.php';
});

// Dynamic GET. Example with 1 variable
// The $id will be available in user.php
get('/user/$id', 'views/user');

// Dynamic GET. Example with 2 variables
// The $name will be available in full_name.php
// The $last_name will be available in full_name.php
// In the browser point to: localhost/user/X/Y
get('/user/$name/$last_name', 'views/full_name.php');

// Dynamic GET. Example with 2 variables with static
// In the URL -> http://localhost/product/shoes/color/blue
// The $type will be available in product.php
// The $color will be available in product.php
get('/product/$type/color/$color', 'product.php');

// A route with a callback
get('/callback', function () {
    echo 'Callback executed';
});

// A route with a callback passing a variable
// To run this route, in the browser type:
// http://localhost/user/A
get('/callback/$name', function ($name) {
    echo "Callback executed. The name is $name";
});

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
get('/callback/$name/$last_name', function ($name, $last_name) {
    echo "Callback executed. The full name is $name $last_name";
});

// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404', 'views/404.php');

