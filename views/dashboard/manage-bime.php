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
                    <a href="/bime/add" class="btn btn-primary">افزودن</a>
                </div>
                <div class="card-body p-3">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">نام</th>
                            <th scope="col">درصد پوشش</th>
                            <th scope="col">آدرس</th>
                            <th scope="col">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $bimes = get_bimes();
                        foreach ($bimes as $bime):
                            ?>
                            <tr>
                                <th scope="row"><?php echo $bime->id ?></th>
                                <td><?php echo $bime->title ?></td>
                                <td><?php echo $bime->percent ?></td>
                                <td><?php echo $bime->address ?></td>
                                <td>
                                    <a class="btn btn-secondary"
                                       href="/bime/edit?<?php echo http_build_query(["bime_id" => $bime->id]) ?>">ویرایش</a>

                                    <a class="btn btn-danger"
                                       href="/bime/delete?<?php echo http_build_query(["bime_id" => $bime->id]) ?>">حذف</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php include 'part/footer.php' ?>