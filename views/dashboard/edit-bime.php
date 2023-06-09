<?php
if (!is_admin()) {
    header('Location: /my-account');
    exit();
}

//get user_data
if (!isset($_GET['bime_id'])) {
    header('Location: /manage-bime');
    exit();
}

$bimeItem = get_bime($_GET['bime_id']);

if (!$bimeItem) {
    header('Location: /manage-bime');
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
                    <form method="post" action="/bime/edit">
                        <?php set_csrf(); ?>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="hidden" name="bime_id" readonly value="<?php echo $bimeItem->id ?>">
                                    <label for="bime-name">نام بیمه</label>
                                    <input required type="text" class="form-control" id="bime-name"
                                           name="bime_name"
                                           value="<?php echo $bimeItem->title ?>"
                                           placeholder="نام بیمه را وارد کنید">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group">
                                    <label for="percent">درصد پوشش</label>
                                    <input required type="number" class="form-control" id="percent" step="0.01"
                                           value="<?php echo $bimeItem->percent ?>"
                                           name="percent" placeholder="درصد پوشش">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="address">آدرس</label>
                                    <textarea class="form-control" name="address"
                                              id="address"><?php echo $bimeItem->address ?></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="edit_bime" class="btn btn-primary">ذخیره</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'part/footer.php' ?>