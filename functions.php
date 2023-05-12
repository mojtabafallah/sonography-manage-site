<?php

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