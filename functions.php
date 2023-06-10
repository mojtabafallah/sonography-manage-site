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

function get_user_current_object()
{
    global $conn;
    $sql = 'SELECT *
		FROM users
        WHERE user_name = :username
        ';

    $statement = $conn->prepare($sql);

    $statement->bindParam(':username', $_SESSION['user']);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_OBJ);
}

function get_user($user_id)
{
    global $conn;
    $sql = 'SELECT *
		FROM users
        left join user_meta on user_meta.user_id = users.id
        WHERE id = :userId
        ';

    $statement = $conn->prepare($sql);

    $statement->bindParam(':userId', $user_id);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_OBJ);
}

function get_bime($bime_id)
{
    global $conn;
    $sql = 'SELECT *
		FROM bimes
        WHERE id = :bimeId
        ';

    $statement = $conn->prepare($sql);

    $statement->bindParam(':bimeId', $bime_id);
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

    $result = deleteDb('users', "id = $userItem->id");
    if ($result) {
        $message['success'] = 'حذف با موفقیت انجام شد.';
    } else {
        $message['error'] = 'خطایی رخ داده است';
    }
}

function get_reception($reception_id)
{
    global $conn;
    $sql = 'SELECT *
		FROM reception
        WHERE reception_id = :receptionId
        ';

    $statement = $conn->prepare($sql);

    $statement->bindParam(':receptionId', $reception_id);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_OBJ);
}

function delete_bime()
{
    global $message;
    $bimeItem = get_bime($_GET['bime_id']);
    if (!$bimeItem) {
        header('Location: /manage-bime');
        exit();
    }

    $result = deleteDb('bimes', "id = $bimeItem->id");
    if ($result) {
        $message['success'] = 'حذف با موفقیت انجام شد.';
    } else {
        $message['error'] = 'خطایی رخ داده است';
    }
}

function delete_reception()
{
    global $message;
    $receptionItem = get_reception($_GET['reception_id']);
    if (!$receptionItem) {
        header('Location: /manage-bime');
        exit();
    }

    $result = deleteDb('reception', "reception_id = $receptionItem->reception_id");
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

        //exist
        if (existUsername(trim($_POST['national_code']))) {
            $message['error'] = 'این نام کاربری قبلا استفاده شده است';
            return false;
        }

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

function bime_edit()
{
    if (isset($_POST['edit_bime'])) {
        global $message;

        //validation
        if (!isset($_POST['bime_id'], $_POST['bime_name'], $_POST['csrf'],
            $_POST['percent'], $_POST['address']
        )) {
            $message['error'] = 'فیلدها ناقص میباشد';
            return false;
        }

        //csrf
        if (!is_csrf_valid()) {
            $message['error'] = 'خطای امنیتی رخ داده است.';
            return false;
        }

        $bime_id = $_POST['bime_id'];
        //insert data
        $result = edit(
            'bimes',
            [
                'title' => $_POST['bime_name'],
                'percent' => $_POST['percent'],
                'address' => $_POST['address']
            ],
            "id = $bime_id");

        if ($result) {
            $message['success'] = 'ویرایش با موفقیت انجام شد.';
        } else {
            $message['error'] = 'خطایی رخ داده است';
        }

    }
}

function reception_edit()
{
    if (isset($_POST['edit_reception'])) {
        global $message;

        //validation
        if (!isset($_POST['user_id'], $_POST['type_reception'], $_POST['csrf'],
            $_POST['type_bime'], $_POST['bime_takmili'], $_FILES['file'], $_POST['total_price'], $_POST['date'],
            $_POST['reception_id']
        )) {
            $message['error'] = 'فیلدها ناقص میباشد';
            return false;
        }

        //csrf
        if (!is_csrf_valid()) {
            $message['error'] = 'خطای امنیتی رخ داده است.';
            return false;
        }

        $reception_id = $_POST['reception_id'];
        $target_file = $_POST['file_name'];
        //upload file
        if (basename($_FILES["file"]["name"])) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["file"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

            $check = getimagesize($_FILES["file"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }


// Check if file already exists
            if (file_exists($target_file)) {
                $uploadOk = 0;
            }

// Check file size
            if ($_FILES["file"]["size"] > 500000) {
                $uploadOk = 0;
            }

// Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {

                $uploadOk = 0;
            }

// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $message['error'] = 'فایل آپلود نشد';
// if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    $message['success'] = 'فایل آپلود شد';
                } else {
                    $message['error'] = 'فایل آپلود نشد';
                }
            }
        }

        //insert data
        $result = edit(
            'reception',
            [
                'user_id' => $_POST['user_id'],
                'type' => $_POST['type_reception'],
                'bime_id' => $_POST['type_bime'],
                'bime_takmili' => $_POST['bime_takmili'],
                'file' => $target_file,
                'total_price' => $_POST['total_price'],
                'date' => $_POST['date']
            ],
            "reception_id = $reception_id");

        if ($result) {
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

function get_employee()
{
    global $conn;
    $sql = "SELECT *
        FROM users
        left join user_meta on user_meta.user_id = users.id
        WHERE role_id = 2 and (meta_key = 'phone' or 1)
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

function get_bimes()
{
    global $conn;
    $sql = "SELECT *
        FROM bimes
        ";

    $statement = $conn->prepare($sql);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function get_receptions()
{
    global $conn;
    $sql = "SELECT
    *
FROM
    reception
INNER JOIN users on users.id = reception.user_id
        left join user_meta on user_meta.user_id = users.id
INNER JOIN bimes on bimes.id = reception.bime_id
where meta_key = 'phone' or 1
        ";

    $statement = $conn->prepare($sql);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function save_bime()
{
    if (isset($_POST['save_bime'])) {
        global $message;

        //validation
        if (!isset($_POST['bime_name'], $_POST['percent'], $_POST['address'], $_POST['csrf']
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
            'bimes',
            [
                'title' => $_POST['bime_name'],
                'percent' => $_POST['percent'],
                'address' => $_POST['address']
            ]
        );

        if ($result) {
            $message['success'] = 'ثبت با موفقیت انجام شد.';
        } else {
            $message['error'] = 'خطایی رخ داده است';
        }
    }
}

function reception_save()
{
    if (isset($_POST['save_reception'])) {
        global $message;

        //validation
        if (!isset($_POST['user_id'], $_POST['type_reception'], $_POST['type_bime'], $_POST['bime_takmili'], $_FILES['file'],
            $_POST['total_price'], $_POST['date']
            , $_POST['csrf']
        )) {
            $message['error'] = 'فیلدها ناقص میباشد';
            return false;
        }

        //csrf
        if (!is_csrf_valid()) {
            $message['error'] = 'خطای امنیتی رخ داده است.';
            return false;
        }

        //upload file
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image

        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }


// Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

// Check file size
        if ($_FILES["file"]["size"] > 500000) {
            $uploadOk = 0;
        }

// Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {

            $uploadOk = 0;
        }

// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $message['error'] = 'فایل آپلود نشد';
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $message['success'] = 'فایل آپلود شد';
            } else {
                $message['error'] = 'فایل آپلود نشد';
            }
        }

        //insert data
        $result = insert(
            'reception',
            [
                'user_id' => $_POST['user_id'],
                'type' => $_POST['type_reception'],
                'bime_id' => $_POST['type_bime'],
                'bime_takmili' => $_POST['bime_takmili'],
                'file' => $target_file,
                'total_price' => $_POST['total_price'],
                'date' => $_POST['date'],
            ]
        );

        if ($result) {
            $message['success'] = 'ثبت با موفقیت انجام شد.';
        } else {
            $message['error'] = 'خطایی رخ داده است';
        }
    }
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

        //exist
        if (existUsername(trim($_POST['national_code']))) {
            $message['error'] = 'این نام کاربری قبلا استفاده شده است';
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

function entry_user()
{
    global $message;

    if (!isset($_GET['user_id'])) {
        header('Location: /employ-list');
        exit();
    }

    $userItem = get_user($_GET['user_id']);

    if (!$userItem) {
        header('Location: /employ-list');
        exit();
    }

    $result = insert('entry_and_exit',
        [
            'user_id' => $userItem->id,
            'type' => true
        ]
    );
    if ($result) {
        $message['success'] = 'اطلاعات با موفقیت ثبت شد.';
    } else {
        $message['error'] = 'خطایی رخ داده است';
    }

}

function exit_user()
{
    global $message;

    if (!isset($_GET['user_id'])) {
        header('Location: /employ-list');
        exit();
    }

    $userItem = get_user($_GET['user_id']);

    if (!$userItem) {
        header('Location: /employ-list');
        exit();
    }

    $result = insert('entry_and_exit',
        [
            'user_id' => $userItem->id,
            'type' => false
        ]
    );
    if ($result) {
        $message['success'] = 'اطلاعات با موفقیت ثبت شد.';
    } else {
        $message['error'] = 'خطایی رخ داده است';
    }

}

function save_pricing()
{
    if (isset($_POST['save_pricing'])) {
        global $message;

        //validation
        if (!isset($_POST['sono'], $_POST['radio'], $_POST['csrf']
        )) {
            $message['error'] = 'فیلدها ناقص میباشد';
            return false;
        }

        //csrf
        if (!is_csrf_valid()) {
            $message['error'] = 'خطای امنیتی رخ داده است.';
            return false;
        }

        global $conn;
        $sql = "SELECT
    *
FROM
    options
where option_name = 'sono_price'
        ";

        $statement = $conn->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        if (!$result) {
            $result = insert(
                'options',
                [
                    'option_value' => $_POST['sono'],
                    'option_name' => 'sono_price'
                ]
            );

            if ($result) {
                $message['success'] = 'اطلاعات با موفقیت ثبت شد.';
            } else {
                $message['error'] = 'خطایی رخ داده است';
            }
        } else {
            $result = edit('options',
                [
                    'option_value' => $_POST['sono']
                ],
                ' option_name = "sono_price" ');

            if ($result) {
                $message['success'] = 'اطلاعات با موفقیت ثبت شد.';
            } else {
                $message['error'] = 'خطایی رخ داده است';
            }
        }

        global $conn;
        $sql = "SELECT
    *
FROM
    options
where option_name = 'radio_price'
        ";

        $statement = $conn->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_OBJ);

        if (!$result) {
            $result = insert(
                'options',
                [
                    'option_value' => $_POST['radio'],
                    'option_name' => 'radio_price'
                ]
            );

            if ($result) {
                $message['success'] = 'اطلاعات با موفقیت ثبت شد.';
            } else {
                $message['error'] = 'خطایی رخ داده است';
            }
        } else {
            $result = edit('options',
                [
                    'option_value' => $_POST['radio']
                ],
                ' option_name = "radio_price" ');

            if ($result) {
                $message['success'] = 'اطلاعات با موفقیت ثبت شد.';
            } else {
                $message['error'] = 'خطایی رخ داده است';
            }
        }

    }
}

function get_option($option_name)
{
    global $conn;
    $sql = "SELECT
    *
FROM
    options
where option_name = '$option_name'
        ";

    $statement = $conn->prepare($sql);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_OBJ);
    return $result->option_value;
}

function get_timing()
{
    global $conn;
    $sql = "SELECT * FROM `entry_and_exit`
INNER JOIN users on users.id = entry_and_exit.user_id
        ";

    $statement = $conn->prepare($sql);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_OBJ);
}

function save_employee()
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

        //exist
        if (existUsername(trim($_POST['national_code']))) {
            $message['error'] = 'این نام کاربری قبلا استفاده شده است';
            return false;
        }

        //insert data
        $result = insert(
            'users',
            [
                'f_name' => $_POST['first_name'],
                'l_name' => $_POST['last_name'],
                'user_name' => $_POST['national_code'],
                'password' => password_hash($_POST['mobile_phone'], PASSWORD_DEFAULT),
                'role_id' => 2
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