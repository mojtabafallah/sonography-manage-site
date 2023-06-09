<?php
require_once 'db.php';
function register()
{
    if (isset($_POST['register'])) {
        global $message;

        //validation
        if (!isset($_POST['f_name'], $_POST['l_name'], $_POST['user_name'], $_POST['password'], $_POST['re_password']
            , $_POST['csrf'])) {
            $message['error'] = 'فیلدها ناقص میباشد';
            return false;
        }

        //password
        if ($_POST['password'] !== $_POST['re_password']) {
            $message['error'] = 'پسورد یکسان نیست';
            return false;
        }

        //csrf
        if (!is_csrf_valid()) {
            $message['error'] = 'خطای امنیتی رخ داده است.';
            return false;
        }

        //exist
        if (existUsername(trim($_POST['user_name']))) {
            $message['error'] = 'این نام کاربری قبلا استفاده شده است';
            return false;
        }
        global $conn;
        $sql = "INSERT INTO users (f_name, l_name, user_name, password) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$_POST['f_name'], $_POST['l_name'], $_POST['user_name'], password_hash($_POST['password'], PASSWORD_DEFAULT)]);
        if ($result === true) {
            $message['success'] = 'ثبت نام با موفقیت انجام شد.';
            return true;
        } else {
            $message['error'] = 'خطا در پایگاه داده.';
            return false;
        }
    }
}

function get_name_user()
{
    return $_SESSION['name'];
}

function get_user($user_id)
{
    global $conn;
    $sql = 'SELECT *
		FROM users
        inner join user_meta on user_meta.user_id = users.id
        WHERE id = :userId
        ';

    $statement = $conn->prepare($sql);

    $statement->bindParam(':userId', $user_id);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_OBJ);
}

function delete_user()
{
    global $message;
    $userItem = get_user($_GET['user_id']);
    if (!$userItem) {
        header('Location: /customer-list');
        exit();
    }

    $result = deleteDb('users',"id = $userItem->id");
    if ($result) {
        $message['success'] = 'حذف با موفقیت انجام شد.';
    } else {
        $message['error'] = 'خطایی رخ داده است';
    }
}



function user_edit()
{
    if (isset($_POST['edit_user'])) {
        global $message;

        //validation
        if (!isset($_POST['national_code'], $_POST['mobile_phone'], $_POST['csrf'],
            $_POST['first_name'], $_POST['last_name']
        )) {
            $message['error'] = 'فیلدها ناقص میباشد';
            return false;
        }

        //csrf
        if (!is_csrf_valid()) {
            $message['error'] = 'خطای امنیتی رخ داده است.';
            return false;
        }
        $user_id = $_POST['user_id'];
        //insert data
        $result = edit(
            'users',
            [
                'f_name' => $_POST['first_name'],
                'l_name' => $_POST['last_name'],
                'user_name' => $_POST['national_code'],
                'password' => password_hash($_POST['mobile_phone'], PASSWORD_DEFAULT)
            ],
            "id = $user_id");

        $resultMeta = edit('user_meta',
            [
                'meta_key' => 'phone',
                'meta_value' => $_POST['mobile_phone']
            ],
            "user_id = {$user_id} and meta_key = 'phone'");

        if ($resultMeta) {
            $message['success'] = 'ویرایش با موفقیت انجام شد.';
        } else {
            $message['error'] = 'خطایی رخ داده است';
        }

    }
}

function is_admin()
{
    $userName = $_SESSION['user'];
    global $conn;
    $sql = 'SELECT *
		FROM users
        WHERE user_name = :userName
        ';

    $statement = $conn->prepare($sql);

    $statement->bindParam(':userName', $userName);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['role_id'] == 3;
}

function get_customers()
{
    global $conn;
    $sql = "SELECT *
        FROM users
        inner join user_meta on user_meta . user_id = users . id
        WHERE role_id = 1 and meta_key = 'phone'
        ";

    $statement = $conn->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $finaData = [];
    if (!$result) return [];
    foreach ($result as $item) {
        $temp['id'] = $item['id'];
        $temp['national_code'] = $item['user_name'];
        $temp['phone'] = $item['meta_value'];
        $temp['f_name'] = $item['f_name'];
        $temp['l_name'] = $item['l_name'];
        $finaData[] = (object)$temp;
    }
    return $finaData;
}

function logout()
{
    unset($_SESSION['user']);
    header('Location: /');
}

function login()
{
    if (isset($_POST['login'])) {
        global $message;

        //validation
        if (!isset($_POST['user_name'], $_POST['password'], $_POST['csrf'])) {
            $message['error'] = 'فیلدها ناقص میباشد';
            return false;
        }

        //csrf
        if (!is_csrf_valid()) {
            $message['error'] = 'خطای امنیتی رخ داده است.';
            return false;
        }

        //exist

        global $conn;
        $sql = 'SELECT *
		FROM users
        INNER join role on role.id = users.role_id
        WHERE user_name = :userName
        ';

        $statement = $conn->prepare($sql);

        $statement->bindParam(':userName', $_POST['user_name']);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($_POST['password'], $result['password'])) {
                $message['success'] = 'ورود با موفقیت انجام شد.';
                $_SESSION['name'] = $result['f_name'] . ' ' . $result['l_name'];
                $_SESSION['user'] = $result['user_name'];
                $_SESSION['role'] = $result['role_id'];

                ob_start(); //this should be first line of your page
                header('/');
                ob_end_flush(); //this should be last line of your page

                return true;
            } else {
                $message['error'] = 'نام کاربری یا کلمه عبور اشتباه است.';
                return false;
            }
        } else {
            $message['error'] = 'نام کاربری یا کلمه عبور اشتباه است.';
            return false;
        }
    }
}

function save_patient()
{
    if (isset($_POST['save_patient'])) {
        global $message;

        //validation
        if (!isset($_POST['national_code'], $_POST['mobile_phone'], $_POST['csrf'],
            $_POST['first_name'], $_POST['last_name']
        )) {
            $message['error'] = 'فیلدها ناقص میباشد';
            return false;
        }

        //csrf
        if (!is_csrf_valid()) {
            $message['error'] = 'خطای امنیتی رخ داده است.';
            return false;
        }

        //insert data
        $result = insert(
            'users',
            [
                'f_name' => $_POST['first_name'],
                'l_name' => $_POST['last_name'],
                'user_name' => $_POST['national_code'],
                'password' => password_hash($_POST['mobile_phone'], PASSWORD_DEFAULT)
            ]
        );

        $resultMeta = insert('user_meta',
            [
                'meta_key' => 'phone',
                'meta_value' => $_POST['mobile_phone'],
                'user_id' => $result['id']
            ]);

        if ($result) {
            $message['success'] = 'ثبت نام با موفقیت انجام شد.';
        } else {
            $message['error'] = 'خطایی رخ داده است';
        }

    }
}

function is_login()
{
    if (!isset($_SESSION['user'])) {
        return false;
    }
    //check exist user name
    if (!existUsername($_SESSION['user'])) {
        return false;
    }
    return true;
}

function existUsername($userName)
{
    global $conn;
    $sql = 'SELECT *
		FROM users
        WHERE user_name = :userName';

    $statement = $conn->prepare($sql);
    $statement->bindParam(':userName', $userName);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user)
        return true;
    else
        return false;
}