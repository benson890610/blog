<div class="container-fluid px-0">
    <div class="container">
        
        <div class="buttons d-flex justify-content-center mt-5">
            <button id="night" class="btn btn-outline-dark text-white far fa-moon" title="Night layout"></button>
            <button id="evening" class="btn btn-outline-warning text-white fas fa-cloud-moon" title="Evening layout"></button>
            <button id="morning" class="btn btn-outline-info text-white far fa-sun" title="Morning layout"></button>
        </div>

        <div style="margin-top: 120px"></div>

        <h1 class="mt-3 sign-in-h1 text-center">Sign Up</h1>

        <div class="row mt-5">
            <div class="col-md-8 mx-auto">
                
                <form action="<?php echo $_ENV['APP_SRC'] ?>register" method="post">

                    <!-- FIRST AND LAST NAME -->
                    <div class="mb-3">
                        <div class="row">

                            <div class="col">
                                <label for="first_name" class="form-label sign-up-form-label">
                                    First Name
                                </label>
                                <input 
                                    type="text" 
                                    name="first_name" 
                                    id="first_name" 
                                    class="form-control py-2 px-2 <?php echo input_error($user->first_name_err) ?>" 
                                    value="<?php echo $user->first_name ?>" 
                                    maxlength="20"
                                >
                                <span class="invalid-feedback sign-up-error-field">
                                    <?php echo $user->first_name_err ?>
                                </span>
                            </div>

                            <div class="col">
                                <label for="last_name" class="form-label sign-up-form-label">Last Name</label>
                                <input 
                                    type="text" 
                                    name="last_name" 
                                    id="last_name" 
                                    class="form-control py-2 px-2 <?php echo input_error($user->last_name_err) ?>" 
                                    value="<?php echo $user->last_name ?>" 
                                    maxlength="20"
                                >
                                <span class="invalid-feedback sign-up-error-field">
                                    <?php echo $user->last_name_err ?>
                                </span>
                            </div>

                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label for="email" class="form-label sign-in-form-label">
                            Email Address
                        </label>
                        <input 
                            type="text" 
                            name="email" 
                            id="email" 
                            class="form-control py-2 px-2 <?php echo input_error($user->email_err) ?>" 
                            placeholder="youremail@example.com..." 
                            value="<?php echo $user->email ?>" 
                            maxlength="100"
                        >
                        <span class="invalid-feedback sign-up-error-field">
                            <?php echo $user->email_err ?>
                        </span>
                    </div>

                    <!-- USERNAME -->
                    <div class="mb-3">
                        <label for="username" class="form-label sign-in-form-label">
                            Username
                        </label>
                        <input 
                            type="text" 
                            name="username" 
                            id="username" 
                            class="form-control py-2 px-2 <?php echo input_error($user->username_err) ?>" 
                            value="<?php echo $user->username ?>" 
                            maxlength="20"
                        >
                        <span class="invalid-feedback sign-up-error-field">
                            <?php echo $user->username_err ?>
                        </span>
                    </div>

                    <!-- PASSWORD AND CONFIRM PASSWORD -->
                    <div class="mb-4">
                        <div class="row">

                            <div class="col p-relative">
                                <label for="password" class="form-label sign-up-form-label">
                                    Password
                                </label>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password" 
                                    class="form-control py-2 px-2 <?php echo input_error($user->password_err) ?>" 
                                    value="<?php echo $user->password ?>" 
                                    maxlength="100"
                                >
                                <i id="toggle-sign-up-password-visibility" class="bx bxs-show hidden"></i>
                                <span class="invalid-feedback sign-up-error-field">
                                    <?php echo $user->password_err ?>
                                </span>
                            </div>

                            <div class="col p-relative">
                                <label for="confirm-password" class="form-label sign-up-form-label">
                                    Confirm Password
                                </label>
                                <input 
                                    type="password" 
                                    name="confirm_password" 
                                    id="confirm-password" 
                                    class="form-control py-2 px-2 <?php echo input_error($user->confirm_password_err) ?>" 
                                    value="<?php echo $user->confirm_password ?>" 
                                    maxlength="100"
                                >
                                <i id="toggle-sign-up-confirm-password-visibility" class="bx bxs-show hidden"></i>
                                <span class="invalid-feedback sign-up-error-field">
                                    <?php echo $user->confirm_password_err ?>
                                </span>
                            </div>

                        </div>
                    </div>

                    <!-- PERSONAL ADDRESS -->
                    <div id="personal-address" class="hidden">

                        <div class="personal-address-heading mb-2">
                            Personal Address (Optional)
                        </div>

                        <div class="row">

                            <!-- COUNTRY -->
                            <div class="col-4 mb-3">
                                <label class="form-label sign-up-form-label" for="country">Country</label>
                                <select 
                                    class="form-select py-2 px-2 <?php echo input_error($user->country_err) ?>" 
                                    name="country" 
                                    id="country" 
                                    aria-label="Default select example"
                                >
                                    <option value="0" selected>Select country</option>
                                    <?php foreach($user->countries as $country): ?>
                                    <option value="<?php echo $country['country_id'] ?>">
                                        <?php echo $country['name'] ?>
                                    </option>
                                    <?php endforeach ?>
                                </select>
                                <span class="invalid-feedback sign-up-error-field">
                                    <?php echo $user->country_err ?>
                                </span>
                            </div>

                            <!-- CITY -->
                            <div class="col-4 mb-3">
                                <label for="city" class="form-label sign-up-form-label">
                                    City
                                </label>
                                <input 
                                    type="text" 
                                    name="city" 
                                    id="city" 
                                    class="form-control py-2 px-2 <?php echo input_error($user->city_err) ?>" 
                                    value="<?php echo $user->city ?>" 
                                    maxlength="50"
                                >
                                <span class="invalid-feedback sign-up-error-field">
                                    <?php echo $user->city_err ?>
                                </span>
                            </div>

                            <!-- ADDRESS LINE -->
                            <div class="col-4 mb-3">
                                <label for="address_line" class="form-label sign-up-form-label">
                                    Address Line
                                </label>
                                <input 
                                    type="text" 
                                    name="address_line" 
                                    id="address_line" 
                                    class="form-control py-2 px-2 <?php echo input_error($user->address_line_err) ?>" 
                                    value="<?php echo $user->address_line ?>" 
                                    maxlength="100"
                                >
                                <span class="invalid-feedback sign-up-error-field">
                                    <?php echo $user->address_line_err ?>
                                </span>
                            </div>

                            <!-- ZIPCODE -->
                            <div class="col-4 mb-4">
                                <label for="zipcode" class="form-label sign-up-form-label">
                                    Zip Code
                                </label>
                                <input 
                                    type="text" 
                                    name="zipcode" 
                                    id="zipcode" 
                                    class="form-control py-2 px-2 <?php echo input_error($user->zipcode_err) ?>" 
                                    value="<?php echo $user->zipcode ?>" 
                                    maxlength="30"
                                >
                                <span class="invalid-feedback sign-up-error-field">
                                    <?php echo $user->zipcode_err ?>
                                </span>
                            </div>
                            
                        </div>
                    </div>

                    <!-- SUBMIT BUTTON AND LINKS -->
                    <div class="d-flex-between mb-3 mt-5">
                        <button type="submit" style="height: 40px" class="btn btn-primary w-50">
                            Sign Up
                        </button>
                        <p class="w-50 sign-up-login-link text-center pt-1">
                            Have an account? <a href="<?php echo $_ENV['APP_SRC'] ?>" class="registration-sign-in-link text-warning">Sign In</a>
                        </p>
                    </div>

                </form>

            </div>
        </div>

        <canvas id="canvas-image-blending"></canvas>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/granim/2.0.0/granim.min.js"></script>
        <script src="<?php echo js_url('js/gradient') ?>"></script>
        <script src="<?php echo js_url('js/register') ?>"></script>
    </div>
</div>