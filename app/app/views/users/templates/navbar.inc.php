<div class="container mt-5">
    <div class="d-flex-end">
        <div class="dropdown">
            <button class="relative btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                <?php if(!is_set_session_user('image_src')): ?>

                    <img class="br-50" width="25" height="25" src="<?php echo link_image('default_user', 'jpg') ?>">

                <?php endif ?>

                <?php session_user_print('first_name') ?>

            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                <a class="dropdown-item" href="<?php echo link_url('posts') ?>"><i class="fas fa-home"></i> Home</a>
                <a class="dropdown-item" href="#"><i class="fas fa-user"></i> My Profile</a>
                <a 
                    class="dropdown-item relative" 
                    onclick="get_user_posts(<?php session_user_print('id') ?>)" 
                    href="#" 
                    id="my-posts">
                    <i class="fas fa-mail-bulk"></i> My Posts</a>
                <a class="dropdown-item" href="<?php echo link_url('user/logout') ?>"><i class="fas fa-sign-out-alt"></i> Sign Out</a>

            </div>

            <div class="my-posts-container"></div>
        </div>

    </div>
</div>


<script>const APP_URL = "<?php echo link_url() ?>";</script>
<script src="<?php echo js_url('js/navbar/navbar') ?>"></script>