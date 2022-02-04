<div class="container-fluid px-0">
    <div class="container">

        <div class="buttons d-flex justify-content-center mt-5">
            <button id="night" class="btn btn-outline-dark text-white far fa-moon" title="Night layout"></button>
            <button id="evening" class="btn btn-outline-warning text-white fas fa-cloud-moon" title="Evening layout"></button>
            <button id="morning" class="btn btn-outline-info text-white far fa-sun" title="Morning layout"></button>
            
        </div>

        <div style="margin-top: 250px"></div>

        <h1 class="mt-5 sign-in-h1 text-center">Sign In</h1>

        <div class="row mt-5">
            <div class="col-md-6 mx-auto">
                
                <?php echo $data->message ?>

                <form action="<?php echo $_ENV['APP_SRC'] ?>" method="post">

                    <!-- EMAIL ADDRESS -->
                    <div class="mb-3">
                        <label for="email" class="form-label sign-in-form-label">Email Address</label>
                        <input type="text" name="email" id="email" class="form-control py-3 px-3 <?php echo input_error($user->email_err) ?>" placeholder="youremail@example.com..." value="<?php echo $user->email ?>" maxlength="100">
                        <span class="invalid-feedback sign-in-error-field"><?php echo $user->email_err ?></span>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-4" style="position: relative">
                        <label for="password" class="form-label sign-in-form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control py-3 px-3 <?php echo input_error($user->password_err) ?>" value="<?php echo $user->password ?>" maxlength="100">
                        <i id="toggle-password-visibility" class="bx bxs-show hidden"></i>
                        <span class="invalid-feedback sign-in-error-field"><?php echo $user->password_err ?></span>
                    </div>

                    <!-- SUBMIT BUTTON AND LINKS -->
                    <div class="d-flex-between mb-3">
                        <button type="submit" style="height: 50px" class="btn btn-primary w-50">Sign In</button>
                        <p class="w-50 sign-in-register-link">
                            Dont have an account? <a href="<?php echo $_ENV['APP_SRC'] ?>register" class="text-warning">Sign Up</a><br>
                            Forgot Password? <a href="<?php echo $_ENV['APP_SRC'] ?>forgotPassword" class="text-warning">Password Recovery</a>
                        </p>
                    </div>

                    <!-- REMEMBER ME CHECKBOX -->
                    <div class="form-check mb-3 mt-4">
                        <div style="width: 120px; margin: 0 auto">
                            <input type="checkbox" name="remember_me" value="true" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label sign-in-remember-label">Remember Me</label>
                        </div>
                    </div>

                </form>

            </div>
        </div>

        <canvas id="canvas-image-blending"></canvas>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/granim/2.0.0/granim.min.js"></script>
        <script src="<?php echo js_url('js/gradient') ?>"></script>
        <script src="<?php echo js_url('js/login') ?>"></script>
    </div>
</div>