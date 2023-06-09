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
                    <h6 class="mb-3">افزودن بیمه</h6>
                </div>
                <div class="card-body p-3">
                    <form method="post" action="/bime/save">
                        <?php set_csrf(); ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="bime-name">نام بیمه</label>
                                    <input required type="text" class="form-control" id="bime-name"
                                           name="bime_name"
                                           placeholder="نام بیمه را وارد کنید">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="percent">درصد پوشش</label>
                                    <input required type="number" class="form-control" id="percent" step="0.01"
                                           name="percent" placeholder="درصد پوشش">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="address">آدرس</label>
                                    <textarea class="form-control" name="address" id="address"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="save_bime" class="btn btn-primary">ذخیره</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'part/footer.php' ?>