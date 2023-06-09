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
                    <h6 class="mb-3">لیست پرسنل</h6>
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
                            <th scope="col">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $employees = get_employee();
                        foreach ($employees as $employee):
                            ?>
                            <tr>
                                <th scope="row"><?php echo $employee->id ?></th>
                                <td><?php echo $employee->national_code ?></td>
                                <td><?php echo $employee->phone ?></td>
                                <td><?php echo $employee->f_name ?></td>
                                <td><?php echo $employee->l_name ?></td>
                                <td>
                                    <a class="btn btn-secondary"
                                       href="/user/edit?<?php echo http_build_query(["user_id" => $employee->id]) ?>">ویرایش</a>

                                    <a class="btn btn-danger"
                                       href="/user/delete?<?php echo http_build_query(["user_id" => $employee->id]) ?>">حذف</a>

                                    <a class="btn btn-primary"
                                       href="/user/entry?<?php echo http_build_query(["user_id" => $employee->id]) ?>">ورود</a>

                                    <a class="btn btn-primary"
                                       href="/user/exit?<?php echo http_build_query(["user_id" => $employee->id]) ?>">خروج</a>

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