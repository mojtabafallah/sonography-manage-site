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
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">کد ملی</th>
                            <th scope="col">تافن همراه</th>
                            <th scope="col">نام</th>
                            <th scope="col">نام خانوادگی</th>
                            <th scope="col">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $customers = get_customers();
                        foreach ($customers as $customer):
                            ?>
                            <tr>
                                <th scope="row"><?php echo $customer->id ?></th>
                                <td><?php echo $customer->national_code ?></td>
                                <td><?php echo $customer->phone ?></td>
                                <td><?php echo $customer->f_name ?></td>
                                <td><?php echo $customer->l_name ?></td>
                                <td>
                                    <a class="btn btn-secondary"
                                       href="/user/edit?<?php echo http_build_query(["user_id" => $customer->id]) ?>">ویرایش</a>

                                    <a class="btn btn-secondary"
                                       href="/user/delete?<?php echo http_build_query(["user_id" => $customer->id]) ?>">حذف</a>

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