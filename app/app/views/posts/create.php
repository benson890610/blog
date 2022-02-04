<div class="container-fluid px-0">
    <div class="container">

        <header id="post-header" class="d-flex-between">
            <h1 id="main-heading">Create Post</h1>
        </header>

        <hr class="hr-white">

        <!-- CREATE POST -->
        <div class="row mt-5">
            <div class="col-10 mx-auto">

                <form action="<?php echo link_url('post/create') ?>" method="POST" enctype="multipart/form-data" id="post-form">
                    
                    <!-- CATEGORY -->
                    <div class="mb-3">

                        <label for="category" class="text-white mb-2">* Category</label>
                        <select name="category" id="category" class="form-control <?php echo input_error($post->category_err) ?>">

                            <?php foreach($post->categories as $category): ?>
                            <option value="<?php echo $category['category_id'] ?>">
                                <?php echo $category['category_name'] ?>
                            </option>
                            <?php endforeach ?>

                        </select>
                        <span class="invalid-feedback"><?php echo $post->category_err ?></span>

                    </div>

                    <!-- TITLE -->
                    <div class="mb-3">

                        <label for="title" class="text-white mb-2">* Title</label>
                        <input type="text" name="title" id="title" 
                            class="form-control <?php echo input_error($post->title_err) ?>" 
                            value="<?php echo $post->title ?>" maxlength="255">
                        <span class="invalid-feedback"><?php echo $post->title_err ?></span>

                    </div>

                    <!-- DESCRIPTION -->
                    <div class="mb-3">

                        <label for="description" class="text-white mb-2">* Description</label>
                        <textarea name="description" id="summary-editor" class="form-control <?php echo input_error($post->description_err) ?>"><?php echo $post->description ?></textarea>
                        <span class="invalid-feedback"><?php echo $post->description_err ?></span>

                    </div>

                    <!-- IMAGE -->
                    <div class="mb-3">

                        <label for="file" id="label-file" class="<?php echo empty($post->file_err) ? '' : 'is-invalid upload-label-err' ?>">
                        Optional Image
                        </label>
                        <input type="file" name="file" id="file" accept="image/*">
                        <span class="invalid-feedback"><?php echo $post->file_err ?></span>

                    </div>

                    <!-- SHOW UPLOADED IMAGE ATTEMPT -->
                    <div id="upload-image-content"></div>

                    <!-- CREATE BUTTON -->
                    <div class="mb-3 mt-3 d-grid gap-2">

                        <button type="submit" class="btn btn-primary">Create</button>
                        <h3 class="mx-auto">
                            <a href="<?php echo link_url('posts') ?>" title="Home"><i class="bx bxs-home"></i></a>
                        </h3>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="<?php echo js_url('js/posts/create') ?>"></script>
<script src="<?php echo js_url('ckeditor/ckeditor') ?>"></script>
<script>
    CKEDITOR.replace( 'summary-editor' );
    CKEDITOR.config.height = 300;
</script>