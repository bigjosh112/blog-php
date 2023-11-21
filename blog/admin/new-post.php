
<?php require_once './includes/header.php' ?>
<?php 
  if(!isset($_COOKIE['_ua_'])){
    header("Location: sign-in.php");
  }

?>
    <div class="fluid-container">
    <?php require_once './includes/nav.php' ?>  

        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
            <h2 class="pb-3">Add New Post</h2>

            <?php
                if(isset($_POST['create-post'])){
                    $post_title = $_POST['post-title'];
                    $post_cat_id = $_POST['cat_id'];
                    $post_status = $_POST['post_status'];
                    $post_desc = $_POST['post-desc'];
                    $post_date = date('j F Y');
                    $post_author = 'dee';
                    $post_image = $_FILES['post-image']['name'];
                    $post_temp_image = $_FILES['post-image']['tmp_name'];
                    move_uploaded_file("{$post_temp_image}", "../img/{$post_image}");
                    if(empty($post_title) || empty($post_cat_id) || empty($post_status) || empty($post_desc) || empty($post_image)){
                        echo '<div class="alert alert-danger">Fields cannot be empty <div>';
                    } else {
                        $sql = 'INSERT INTO posts(post_title, post_desc, post_image, post_date, post_author, post_cat_id, post_status) 
                        VALUES (:title, :desc, :image, :date, :author, :cat_id, :status)';
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':title'=>$post_title,
                            ':desc'=>$post_desc,
                            ':image'=> $post_image,
                            ':date'=> $post_date,
                            ':author' => $post_author,
                            ':cat_id' => $post_cat_id,
                            ':status' => $post_status
                        ]);
                        echo '<div class="allert alert-success">Post created Successfully. <a href="index.php">Go back</a></div>';
                    }
                }
            ?>
            <form method="POST" action="new-post.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="post-title">Post Title</label>
                    <input type="text" name="post-title" class="form-control" id="post-title" placeholder="Enter post title">
                </div>
                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select class="form-control" id="category" name="cat_id">
                    <?php
                        $sql1 = 'SELECT * FROM categories';
                        $stmt1 = $pdo->prepare($sql1);
                        $stmt1->execute();
                        while ($category = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                            $cat_id = $category['category_id'];
                            $category_title = $category['category_title'];?>
                             echo '<option value="<?php echo $cat_id ?>"><?php echo $category_title ?></option>'
                        
                    <?php }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Post Status</label>
                    <select class="form-control" id="category" name="post_status">
                        <option>Publish</option>
                        <option>Draft</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="post-image">Upload post image</label>
                    <input type="file" name="post-image" class="form-control-file" id="post-image">
                </div>
                <div class="form-group">
                    <label for="post-content">Post Content</label>
                    <textarea class="form-control" name="post-desc" id="post-content" rows="6" placeholder="Your post content"></textarea>
                </div>
                <button type="submit" name="create-post" class="btn btn-primary">Submit</button>
            </form>
        </section>

    </div>
<?php require_once './includes/footer.php' ?>