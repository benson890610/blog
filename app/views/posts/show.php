<div class="container-fluid px-0">
    <div class="container">

        <header id="post-header" class="d-flex-between">
            <h1 style="letter-spacing: 2px;" id="main-heading"><?php echo $post->title ?></h1>
            <label class="switch">
                <input type="checkbox" id="page-checkbox">
                <span class="slider round"></span>
            </label>
        </header>

        <hr class="hr-white">

        <div class="post card mt-5 p-3">

            <div class="card-body">

                <div class="d-flex-end mb-3">
                    <a href="<?php echo link_url('posts') ?>" class="btn btn-outline-secondary">Back <i class="fas fa-backward"></i></a>
                </div>

                <!-- POST CATEGORY -->
                <div class="d-flex-between">
                    <h3 class="card-title"><?php echo $post->category_name ?></h3>
                    <div title="Number of views"><i class="fas fa-eye"></i> <span class="text-primary"><?php echo $post->views ?></span></div>
                </div>

                <!-- POST TEXT -->
                <div class="card-text text-muted"><?php echo $post->description ?></div>

                <!-- POST OPTIONAL IMAGE -->
                <?php if(!is_null($post->image_src)): ?>

                <div class="mx-auto text-center">
                    <img width="900" height="600" src="<?php echo $post->image_src ?>" title="<?php echo $post->image_name ?>">
                </div>

                <?php endif ?>

                <!-- POST CREATOR AND CREATION DATE -->
                <div class="mt-3 d-flex-between">
                    <span>
                        <small>
                            Posted by - <a href="<?php echo username_link($post->username, 'member/show') ?>">@<?php echo $post->user ?></a>
                        </small>
                    </span>
                    <span>
                        <small class="post-created-at"><?php echo $post->created_at ?></small>
                    </span>
                </div>

                <?php if(App\Tools\Auth::user_post($post->user_id)): ?>

                <hr>

                <div class="d-flex-between">

                    <a href="<?php echo link_url('post/edit/' . $post->id) ?>" class="btn btn-outline-success">Edit <i class="fas fa-edit"></i></a>

                    <form action="<?php echo link_url('post/delete/') ?>" method="post" id="delete-post-form">
                        <input type="hidden" name="post_id" value="<?php echo $post->id ?>">
                        <button type="submit" class="btn btn-outline-danger">Remove <i class="far fa-trash-alt"></i></button>
                    </form>
                    
                </div>

                <?php endif ?>

            </div>
        </div>

        <div class="mt-5"></div>

    </div>
</div>

<script src="<?php echo js_url('js/posts/show') ?>"></script>