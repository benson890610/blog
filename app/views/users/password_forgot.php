<div class="container-fluid px-0">
    <div class="container">

        <div class="buttons d-flex justify-content-center mt-5">
            <button id="night" class="btn btn-outline-dark text-white far fa-moon" title="Night layout"></button>
            <button id="evening" class="btn btn-outline-warning text-white fas fa-cloud-moon" title="Evening layout"></button>
            <button id="morning" class="btn btn-outline-info text-white far fa-sun" title="Morning layout"></button>
        </div>

        <div style="margin-top: 250px"></div>

        <h1 class="mt-5 sign-in-h1 text-center">Forgot your password?</h1>

        <div class="row mt-5">
            <div class="col-md-6 mx-auto">

                <form action="<?php echo $_ENV['APP_SRC'] ?>forgotPassword" method="post">

                    <!-- EMAIL ADDRESS -->
                    <div class="mb-3">
                        <label for="email" class="form-label sign-in-form-label">Email Address</label>
                        <input type="text" name="email" id="email" class="form-control py-3 px-3 <?php echo input_error($user->email_err) ?>" placeholder="youremail@example.com..." value="<?php echo $user->email ?>" maxlength="100">
                        <span class="invalid-feedback sign-in-error-field"><?php echo $user->email_err ?></span>
                    </div>

                    <!-- SUBMIT BUTTON AND LINKS -->
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" style="height: 50px" class="btn btn-primary">Send</button>
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