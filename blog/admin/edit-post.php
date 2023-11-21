
<?php require_once './includes/header.php' ?>
<?php 
  if(!isset($_COOKIE['_ua_'])){
    header("Location: sign-in.php");
  }

?>
    <div class="fluid-container">
        <?php require_once './includes/nav.php' ?>
        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
            <h2 class="pb-3">Edit Post</h2>
            <form>
                <div class="form-group">
                    <label for="post-title">Post Title</label>
                    <input type="email" class="form-control" id="post-title" placeholder="Enter post title">
                </div>
                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select class="form-control" id="category">
                        <option>PHP</option>
                        <option>JavaScript</option>
                        <option>NodeJS</option>
                        <option>AngularJS</option>
                        <option>ReactJS</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Post Status</label>
                    <select class="form-control" id="category">
                        <option>Publish</option>
                        <option>Draft</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="post-image">Upload post image</label>
                    <input type="file" class="form-control-file" id="post-image">
                </div>
                <div class="form-group">
                    <label for="post-content">Post Content</label>
                    <textarea class="form-control" id="post-content" rows="6" placeholder="Your post content"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </section>

    </div>
<?php require_once './includes/footer.php' ?>