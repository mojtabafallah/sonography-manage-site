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
                    <h6 class="mb-3">ورود و خروج پرسنل</h6>
                </div>
                <div class="card-body p-3">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">کد ملی</th>

                            <th scope="col">نام</th>
                            <th scope="col">نام خانوادگی</th>
                            <th scope="col">تاریخ</th>
                            <th scope="col">ورود/خروج</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $times = get_timing();
                        foreach ($times as $time):
                            ?>
                            <tr>
                                <th scope="row"><?php echo $time->id ?></th>
                                <td><?php echo $time->user_name ?></td>
                                <td><?php echo $time->f_name ?></td>
                                <td><?php echo $time->l_name ?></td>
                                <td><?php echo $time->date ?></td>
                                <td><?php echo $time->type ? 'ورود' : 'خروج' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php include 'part/footer.php' ?>