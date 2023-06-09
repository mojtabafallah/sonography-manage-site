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
                    <h6 class="mb-3">مدیریت پذیرش ها</h6>
                </div>
                <div class="card-body p-3">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">کد ملی</th>
                            <th scope="col">تلفن همراه</th>
                            <th scope="col">نام</th>
                            <th scope="col">نام خانوادگی</th>
                            <th scope="col">نوع پذیرش</th>
                            <th scope="col">قیمت</th>
                            <th scope="col">زمان</th>
                            <th scope="col">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $receptions = get_receptions();
                        foreach ($receptions as $reception):
                            ?>
                            <tr>
                                <th scope="row"><?php echo $reception->reception_id ?></th>
                                <td><?php echo $reception->user_name ?></td>
                                <td><?php echo $reception->meta_value ?></td>
                                <td><?php echo $reception->f_name ?></td>
                                <td><?php echo $reception->l_name ?></td>
                                <td><?php echo $reception->type ?></td>
                                <td><?php echo $reception->total_price ?></td>
                                <td><?php echo $reception->date ?></td>
                                <td>
                                    <a class="btn btn-secondary"
                                       href="/reception/edit?<?php echo http_build_query(["reception_id" => $reception->reception_id]) ?>">ویرایش</a>

                                    <a class="btn btn-danger"
                                       href="/reception/delete?<?php echo http_build_query(["reception_id" => $reception->reception_id]) ?>">حذف</a>

                                    <a class="btn btn-danger"
                                       href="/reception/view?<?php echo http_build_query(["reception_id" => $reception->reception_id]) ?>">نمایش</a>

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