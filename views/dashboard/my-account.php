<?php


//get user_data
if (!isset($_GET['user_id'])) {

    header('Location: /my-account?user_id='. get_user_current_object()->id );
    exit();
}

$userItem = get_user($_GET['user_id']);
if (!$userItem) {
    header('Location: /my-account?user_id='. get_user_current_object()->id );
    exit();
}

include 'part/header.php' ?>
    <div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-3">ویرایش پروفایل</h6>
                </div>
                <div class="card-body p-3">
                    <form method="post" action="/user/edit">
                        <?php set_csrf(); ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="hidden" name="user_id" value="<?php echo  $userItem->id?>">
                                    <label for="national-code">کد ملی(نام کاربری)</label>
                                    <input required type="text" class="form-control" id="national-code"
                                           name="national_code"
                                           placeholder="کد ملی را وارد کنید"
                                           value="<?php echo $userItem->user_name ?>">

                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="mobile-phone">تلفن همراه(کلمه عبور)</label>
                                    <input required type="text" class="form-control" id="mobile-phone"
                                           name="mobile_phone" placeholder="تلفن همراه را وارد کنید"
                                           value="<?php if ($userItem->meta_key == 'phone') echo $userItem->meta_value ?>"
                                    >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="first-name">نام</label>
                                    <input required type="text" class="form-control" id="first-name" name="first_name"
                                           placeholder="نام"
                                           value="<?php echo $userItem->f_name?>"
                                    >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="last-name">نام خانوادگی</label>
                                    <input required type="text" class="form-control" id="last-name" name="last_name"
                                           placeholder="نام خانوادگی"
                                           value="<?php echo $userItem->l_name?>"
                                    >
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="edit_user" class="btn btn-primary">ذخیره</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'part/footer.php' ?>