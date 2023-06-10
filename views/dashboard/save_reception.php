<?php

//get user_data
if (!isset($_GET['user_id'])) {
    header('Location: /customer-list');
    exit();
}


$userItem = get_user($_GET['user_id']);

if (!$userItem) {
    header('Location: /customer-list');
    exit();
}

$bimes = get_bimes();
include 'part/header.php';
?>
    <div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-3">پذیرش بیمار</h6>
                </div>
                <div class="card-body p-3">
                    <form method="post" action="/reception/save" enctype="multipart/form-data">
                        <?php set_csrf(); ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="hidden" readonly name="user_id" value="<?php echo $userItem->id ?>">
                                    <label for="national-code">کد ملی(نام کاربری)</label>
                                    <input required type="text" class="form-control" id="national-code"
                                           readonly
                                           name="national_code"
                                           placeholder="کد ملی را وارد کنید"
                                           value="<?php echo $userItem->user_name ?>">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="mobile-phone">تلفن همراه(کلمه عبور)</label>
                                    <input required type="number" class="form-control" id="mobile-phone"
                                           readonly
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
                                           readonly
                                           placeholder="نام"
                                           value="<?php echo $userItem->f_name ?>"
                                    >
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="last-name">نام خانوادگی</label>
                                    <input required type="text" class="form-control" id="last-name" name="last_name"
                                           readonly
                                           placeholder="نام خانوادگی"
                                           value="<?php echo $userItem->l_name ?>"
                                    >
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="type-reception">نوع پذیرش</label>
                                    <select name="type_reception" id="type-reception" class="form-select">
                                        <option value="">انتخاب کنید</option>
                                        <option data-price="<?php echo get_option('sono_price') ?>" value="sono">سنو
                                            گرافی
                                        </option>
                                        <option data-price="<?php echo get_option('radio_price') ?>" value="radio">
                                            رادیولوژی
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="type-bime">بیمه پایه</label>
                                    <select name="type_bime" class="form-select" id="type-bime">
                                        <option data-percent="0" value="">نوع بیمه را انتخاب کنید</option>
                                        <?php foreach ($bimes as $bime): ?>
                                            <option data-percent="<?php echo $bime->percent ?>"
                                                    value="<?php echo $bime->id ?>"><?php echo $bime->title ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="bime-takmili">نام بیمه تکمیلی</label>
                                    <input type="text" class="form-control" id="bime-takmili" name="bime_takmili"
                                           placeholder="بیمه تکمیلی">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="file-upload">آپلود فایل</label>
                                    <input required type="file" class="form-control" id="file-upload" name="file">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="total-price">قیمت نهایی</label>
                                    <input type="text" class="form-control" id="total-price" name="total_price"
                                           placeholder="قیمت نهایی">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="total-price">تاریخ</label>
                                    <input type="date" class="form-control" id="total-price" name="date"
                                           placeholder="قیمت نهایی">
                                </div>
                            </div>

                        </div>
                        <button type="submit" name="save_reception" class="btn btn-primary">ذخیره</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'part/footer.php' ?>