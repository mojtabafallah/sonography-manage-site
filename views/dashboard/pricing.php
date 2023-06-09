<?php
if (!is_admin()) {
    header('Location: /my-account');
    exit();
}

$sono_price = get_option('sono_price');
$radio_price = get_option('radio_price');

include 'part/header.php';
?>
    <div class="container-fluid py-4">
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-3">قیمت دهی</h6>
                </div>
                <div class="card-body p-3">
                    <form method="post" action="/pricing">
                        <?php set_csrf(); ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="sono">قیمت سونوگرافی:</label>
                                    <input required type="number" class="form-control" id="sono"
                                           name="sono"
                                           placeholder="قیمت سونوگرافی را وارد کنید"
                                           value="<?php echo  $sono_price?>"
                                    >
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="radio">قیمت رادیولوژی</label>
                                    <input required type="number" class="form-control" id="radio"
                                           name="radio"
                                           placeholder="قیمت رادیولوژی را وارد کنید"
                                           value="<?php echo  $radio_price?>"
                                    >
                                </div>
                            </div>

                        </div>

                        <button type="submit" name="save_pricing" class="btn btn-primary">ذخیره</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'part/footer.php' ?>