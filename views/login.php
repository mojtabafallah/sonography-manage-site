<?php
//check is login
if (is_login()) {
    header('Location: /my-account');
    exit();
}

require_once('./header.php');

?>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                         class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="post">
                        <?php set_csrf(); ?>
                        <!-- user name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form3Example3" name="user_name" class="form-control form-control-lg"
                                   placeholder="نام کاربری خود را وارد نمایید"/>
                            <label class="form-label" for="form3Example3">نام کاربری</label>
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <input type="password" id="form3Example4" name="password"
                                   class="form-control form-control-lg"
                                   placeholder="کلمه عبور خود را وارد نمایید"/>
                            <label class="form-label" for="form3Example4">کلمه عبور</label>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" name="login" class="btn btn-primary btn-lg"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">ورود
                            </button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">ثبت نام نکرده اید؟ <a href="/register"
                                                                                          class="link-danger">ثبت
                                    نام</a>
                            </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

<?php require_once('./footer.php') ?>