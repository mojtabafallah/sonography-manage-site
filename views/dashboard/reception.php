<?php
if (!is_admin()) {
    header('Location: /my-account');
    exit();
}

include 'part/header.php';
?>
    <div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-3">ثبت اطلاعات بیمار</h6>
                </div>
                <div class="card-body p-3">
                    <form method="post" action="/save_patient">
                        <?php set_csrf(); ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="national-code">کد ملی(نام کاربری)</label>
                                    <input required type="number" class="form-control" id="national-code"
                                           name="national_code"
                                           placeholder="کد ملی را وارد کنید">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="mobile-phone">تلفن همراه(کلمه عبور)</label>
                                    <input required type="number" class="form-control" id="mobile-phone"
                                           name="mobile_phone" placeholder="تلفن همراه را وارد کنید">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="first-name">نام</label>
                                    <input required type="text" class="form-control" id="first-name" name="first_name"
                                           placeholder="نام">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="last-name">نام خانوادگی</label>
                                    <input required type="text" class="form-control" id="last-name" name="last_name"
                                           placeholder="نام خانوادگی">
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="save_patient" class="btn btn-primary">ذخیره</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'part/footer.php' ?>