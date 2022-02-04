<div class="container-fluid px-0">
    <div class="container">

        <div class="buttons d-flex justify-content-center mt-5">
            <button id="night" class="btn btn-outline-dark text-white far fa-moon" title="Night layout"></button>
            <button id="evening" class="btn btn-outline-warning text-white fas fa-cloud-moon" title="Evening layout"></button>
            <button id="morning" class="btn btn-outline-info text-white far fa-sun" title="Morning layout"></button>
        </div>

        <div style="margin-top: 250px"></div>

        <h1 class="mt-5 sign-in-h1 text-center">Passowrd Recovery</h1>
        <p class="text-muted text-center">Fill the form below to add your new password</p>

        <div class="row mt-5">
            <div class="col-md-6 mx-auto">

                <form action="<?php echo $_ENV['APP_SRC'] ?>user/passwordChange/<?php echo $user->password_code ?>" method="post">

                    <input type="hidden" name="password_forgot_id" value="<?php echo $user->password_forgot_id ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user->id ?>">

                    <!-- PASSWORD AND CONFIRM PASSWORD -->
                    <div class="mb-4">
                        <div class="row">
                            <div class="col" style="position: relative">
                                <label for="password" class="form-label sign-up-form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control py-2 px-2 <?php echo input_error($user->password_err) ?>" value="<?php echo $user->password ?>" maxlength="100">
                                <i id="toggle-sign-up-password-visibility" class="bx bxs-show hidden"></i>
                                <span class="invalid-feedback sign-up-error-field"><?php echo $user->password_err ?></span>
                            </div>
                            <div class="col" style="position: relative">
                                <label for="confirm-password" class="form-label sign-up-form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm-password" class="form-control py-2 px-2 <?php echo input_error($user->confirm_password_err) ?>" value="<?php echo $user->confirm_password ?>">
                                <i id="toggle-sign-up-confirm-password-visibility" class="bx bxs-show hidden"></i>
                                <span class="invalid-feedback sign-up-error-field"><?php echo $user->confirm_password_err ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON AND LINKS -->
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" style="height: 50px" class="btn btn-primary">Change</button>
                        <div class="text-center mt-3">
                            <a class="text-warning" href="<?php echo $_ENV['APP_SRC'] ?>">Go Back</a>
                        </div>
                    </div>

                </form>

            </div>
        </div>

        <canvas id="canvas-image-blending"></canvas>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/granim/2.0.0/granim.min.js"></script>
        <script src="<?php echo js_url('js/gradient') ?>"></script>
        <script src="<?php echo js_url('js/passwordForgot') ?>"></script>
    </div>
</div>