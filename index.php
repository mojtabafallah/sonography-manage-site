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
get('/save-employee', 'views/dashboard/add-employee.php');
get('/customer-list', 'views/dashboard/customer-list.php');
get('/user/edit', 'views/dashboard/edit-user.php');
get('/user/save_reception', 'views/dashboard/save_reception.php');
get('/manage-bime', 'views/dashboard/manage-bime.php');
get('/manage-reception', 'views/dashboard/manage-reception.php');
get('/bime/add', 'views/dashboard/add-bime.php');
get('/employ-list', 'views/dashboard/employ-list.php');
get('/timing', 'views/dashboard/timing.php');

get('/reception/edit', 'views/dashboard/edit-reception.php');

get('/reception/view', 'views/dashboard/view-reception.php');

get('/save-reception', function () {
    header('Location: /user/save_reception?user_id=' . get_user_current_object()->id);
});


get('/user/delete', function () {
    delete_user();
    include 'views/dashboard/edit-user.php';
});

get('/reception/delete', function () {
    delete_reception();
    include 'views/dashboard/manage-reception.php';
});

get('/bime/delete', function () {
    delete_bime();
    include 'views/dashboard/manage-bime.php';
});

get('/logout', function () {
    logout();
});

post('/user/edit', function () {
    user_edit();
    include 'views/dashboard/edit-user.php';
});

post('/reception/edit', function () {
    reception_edit();
    include 'views/dashboard/edit-reception.php';
});

post('/reception/save', function () {
    reception_save();
    include 'views/dashboard/manage-reception.php';
});

get('/bime/save', function () {
    include 'views/dashboard/manage-bime.php';
});

get('/user/entry', function () {
    entry_user();
    include 'views/dashboard/employ-list.php';
});

get('/user/exit', function () {
    exit_user();
    include 'views/dashboard/employ-list.php';
});

post('/bime/save', function () {
    save_bime();
    include 'views/dashboard/manage-bime.php';
});

get('/bime/edit', 'views/dashboard/edit-bime.php');

post('/bime/edit', function () {
    bime_edit();
    include 'views/dashboard/edit-bime.php';
});


post('/save_patient', function () {
    save_patient();
    include 'views/dashboard/reception.php';
});

post('/save_employee', function () {
    save_employee();
    include 'views/dashboard/employ-list.php';
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

