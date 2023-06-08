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
                        <form>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">کد ملی</label>
                                        <input type="number" class="form-control" id="exampleInputEmail1"
                                               aria-describedby="emailHelp" placeholder="کد ملی را وارد کنید">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">تلفن همراه</label>
                                        <input type="number" class="form-control" id="exampleInputEmail1"
                                               aria-describedby="emailHelp" placeholder="تلفن همراه را وارد کنید">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">نام</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1"
                                               placeholder="نام">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">نام خانوادگی</label>
                                        <input type="text" class="form-control" id="exampleInputPassword1"
                                               placeholder="نام خانوادگی">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">ذخیره</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php include 'part/footer.php' ?>