<?php require_once('header.php') ?>
    <!-- Section: Design Block -->
    <section>
        <!-- Jumbotron -->
        <div class="px-4 py-5 px-md-5 text-center text-lg-end" style="background-color: hsl(0, 0%, 96%)">
            <div class="container">
                <div class="row gx-lg-5 align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h1 class="my-5 display-3 fw-bold ls-tight">
                            ثبت نام <br/>
                            <span class="text-primary">سایت سونوگرافی</span>
                        </h1>
                        <p style="color: hsl(217, 10%, 50.8%)">
                            با ثبت نام در سایت سونو گرافی بهترین خدمات را زا ما دریافت کنید
                        </p>
                    </div>

                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="card">
                            <div class="card-body py-5 px-md-5">
                                <form method="post" action="/register">
                                    <?php set_csrf(); ?>
                                    <!-- 2 column grid layout with text inputs for the first and last names -->
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="text" id="f-name" name="f_name" required
                                                       class="form-control"/>
                                                <label class="form-label" for="f-name">نام</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-outline">
                                                <input type="text" id="last-name" name="l_name" required
                                                       class="form-control"/>
                                                <label class="form-label" for="last-name">نام خانوادگی</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email input -->
                                    <div class="form-outline mb-4">
                                        <input type="email" id="username" name="user_name" required
                                               class="form-control"/>
                                        <label class="form-label" for="username">نام کاربری</label>
                                    </div>

                                    <!-- Password input -->
                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" class="form-control"/>
                                        <label class="form-label" for="password">کلمه عبور</label>
                                    </div>

                                    <!-- Password input -->
                                    <div class="form-outline mb-4">
                                        <input type="password" id="re-password" name="re_password"
                                               class="form-control"/>
                                        <label class="form-label" for="re-password">تکرار کلمه عبور</label>
                                    </div>

                                    <!-- Submit button -->
                                    <button type="submit" name="register" class="btn btn-primary btn-block mb-4">
                                        ثبت نام
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Jumbotron -->
    </section>
    <!-- Section: Design Block -->
<?php require_once('footer.php') ?>