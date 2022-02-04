<div class="container-fluid px-0">
    <div class="container">

        <header id="post-header" class="d-flex-between">
            <h1 id="main-heading">My Posts</h1>
            <label class="switch">
                <input type="checkbox" id="page-checkbox">
                <span class="slider round"></span>
            </label>
        </header>

        <hr class="hr-white">

        <?php echo $data->message ?>

        <!-- POSTS CONTENT -->
        <div class="row mt-5">
            <div class="col">

                <?php if(count($post->all) > 0): ?>

                <form action="<?php echo $_ENV['APP_SRC'] ?>posts/search" method="GET">

                    <div class="select-box-area">

                        <select name="category" class="select-category">

                            <?php foreach($post->categories as $category): ?>
                            <option value="<?php echo $category['category_id'] ?>"><?php echo $category['category_name'] ?></option>
                            <?php endforeach ?>

                        </select>

                    </div>

                </form>

                <div class="mt-5" id="top-pagination-content">
                    <?php echo pagination($post) ?>
                </div>

                <hr class="hr-color" id="top-hr">

                <!-- CREATE POST BUTTON -->
                <div class="mt-4 d-flex-end">
                    <a href="<?php echo link_url('post/create') ?>" class="btn btn-outline-primary">Create Post <i class="fas fa-plus"></i></a>
                </div>

                <!-- POSTS -->
                <div id="posts-content">

                    <?php foreach($post->all as $blog): ?>

                    <div class="post card mt-5 p-3">

                        <div class="card-body">

                            <!-- POST TITLE AND CATEGORY -->
                            <div class="d-flex-between-center">
                                <h3 class="post-title card-title mb-3"><?php echo $blog['title'] ?></h3>
                                <h5 class="card-title text-muted"><?php echo $blog['category_name'] ?></h5>
                            </div>

                            <!-- POST TEXT -->
                            <div class="card-text text-muted"><?php echo $blog['description'] ?></div>

                            <!-- POST OPTIONAL IMAGE -->
                            <?php if(!is_null($blog['image_src'])): ?>
                            <div class="mx-auto text-center">
                                <img width="900" height="600" src="<?php echo $blog['image_src'] ?>">
                            </div>
                            <?php endif ?>

                            <!-- POST CREATOR AND CREATION DATE -->
                            <div class="mt-3 d-flex-between">
                                <span>
                                    <small>
                                        Posted by - <a href="<?php echo username_link($blog['username'], 'member/show') ?>">@<?php echo $blog['user'] ?></a>
                                    </small>
                                </span>
                                <span>
                                    <small class="post-created-at"><?php echo $blog['created_at'] ?></small>
                                </span>
                            </div>

                            <hr>

                            <!-- POST LINK -->
                            <div>
                                <a class="btn btn-outline-primary" href="<?php echo $_ENV['APP_SRC'] . "post/show/" . $blog['post_id'] ?>">Visit Post</a>
                            </div>

                        </div>
                    </div>

                    <?php endforeach; ?>

                </div>

                <div class="mt-5"></div>

                <hr class="hr-color" id="bottom-hr">

                <div id="back-to-top-content" class="d-flex-between">
                    
                    <a href="#" class="btn btn-outline-primary" id="back-to-top" title="Back to Top"><i class="bx bxs-chevrons-up"></i></a>
                    <a href="<?php echo link_url('posts') ?>" class="btn btn-outline-primary" title="Home"><i class="bx bxs-home"></i></a>

                </div>

                <div class="mt-5"></div>

                <?php else: ?>

                <div class="card">
                    <div class="card-body p-5">

                        <h5 class="card-title text-center">Currently you have no posts</h5>
                        <p class="card-text text-muted text-center">Create your first post</p>
                        <hr>

                        <div class="text-center">
                            <a href="<?php echo link_url('post/create') ?>" class="btn btn-primary ">Create Post</a>
                        </div>
                        
                    </div>
                </div>

                <?php endif ?>

            </div>
        </div>
        
        <script src="<?php echo js_url('js/posts/posts_layout') ?>"></script>
    </div>
</div>