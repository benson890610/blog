<div class="container-fluid px-0">
    <div class="container">

        <header id="post-header" class="d-flex-between">
            <h1 id="main-heading">Edit <?php echo $post->title ?></h1>
        </header>

        <hr class="hr-white">

        <!-- EDIT POST -->
        <div class="row mt-5">
            <div class="col-10 mx-auto">

                <form action="<?php echo link_url('post/update') ?>" method="POST" enctype="multipart/form-data" id="edit-form">

                    <!-- POST ID -->
                    <input type="hidden" name="post_id" value="<?php echo $post->id ?>">

                    <!-- CATEGORY -->
                    <div class="mb-3">

                        <label for="category" class="text-white mb-2">* Category</label>
                        <select name="category_id" id="category" class="form-control <?php error_check('category') ?>">

                            <?php foreach($post->categories as $category): ?>
                            <option value="<?php echo $category['category_id'] ?>">
                                <?php echo $category['category_name'] ?>
                            </option>
                            <?php endforeach ?>

                        </select>
                        <span class="invalid-feedback"><?php error('category') ?></span>

                    </div>

                    <!-- TITLE -->
                    <div class="mb-3">

                        <label for="title" class="text-white mb-2">* Title</label>
                        <input type="text" name="title" id="title" 
                            class="form-control <?php error_check('title') ?>" 
                            value="<?php echo $post->title ?>" maxlength="255">
                        <span class="invalid-feedback"><?php error('title') ?></span>

                    </div>

                    <!-- DESCRIPTION -->
                    <div class="mb-3">

                        <label for="description" class="text-white mb-2">* Description</label>
                        <textarea name="description" id="summary-editor" class="form-control <?php error_check('description') ?>"><?php echo $post->description ?></textarea>
                        <span class="invalid-feedback"><?php error('description') ?></span>

                    </div>

                    <?php if(!empty($post->image_src)): ?>

                    <div class="mt-3">
                        <div class="text-white mb-2">* Post Image</div>
                        <div class="p-5 bg-white">
                            <img src="<?php echo $post->image_src ?>" style="width: 100%;" height="500">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="btn btn-outline-danger" id="delete-image-label" for="delete_image">Delete Image</label>
                        <input type="checkbox" class="hidden" name="delete_image" id="delete_image">
                    </div>

                    <?php endif ?>

                    <!-- EDIT BUTTON -->
                    <div class="mb-3 mt-3 d-grid gap-2">

                        <button type="submit" class="btn btn-primary">Update</button>
                        <h3 class="mx-auto">
                            <a href="<?php echo link_url('posts') ?>" title="Home"><i class="bx bxs-home"></i></a>
                        </h3>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="<?php echo js_url('js/posts/edit') ?>"></script>
<script src="<?php echo js_url('ckeditor/ckeditor') ?>"></script>
<script>
    CKEDITOR.replace( 'summary-editor' );
    CKEDITOR.config.height = 300;
</script>