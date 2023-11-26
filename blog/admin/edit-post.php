
<?php require_once './includes/header.php' ?>
<?php 
  if(!isset($_COOKIE['_ua_'])){
    header("Location: sign-in.php");
  }

?>

<?php

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        header("Location: index.php");
    }

    if(isset($_POST['val'])){
        $pid = $_POST['val'];
        $sql = 'SELECT * FROM posts WHERE post_id = :pid';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':pid' => $pid
        ]);
          while($post = $stmt->fetch(PDO::FETCH_ASSOC)){
            $post_id = $post['post_id'];
            $post_title = $post['post_title'];
            $post_cat_id = $post['post_cat_id'];
            $post_status = $post['post_status'];
            $post_image = $post['post_image'];
            $post_desc = $post['post_desc'];?>
            <div class="fluid-container">
        <?php require_once './includes/nav.php' ?>
        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
            <h2 class="pb-3">Edit Post</h2>
            <form method="POST" action="edit-post.php" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" name="edit-post-id" value="<?php echo $post_id ?>">
                    <label for="post-title">Post Title</label>
                    <input name="post_title" value="<?php echo $post_title ?>" type="text" class="form-control" id="post-title">
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
                                echo '<option value="<?php echo $cat_id ?>" <?php echo $cat_id == $post_cat_id ? 'selected': '' ?>><?php echo $category_title ?></option>'
                            
                        <?php }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Post Status</label>
                    <select name="post_status" class="form-control" id="category">
                        <option <?php echo $post_status == 'Published'?'selected': '' ?>>Published</option>
                        <option <?php echo $post_status == 'Draft'?'selected': '' ?>>Draft</option>
                    </select>
                 </div>

                <div class="form-group">
                    <img src="../img/<?php echo $post_image ?>" style="width: 200px; height: 200px">
                    <p>Image Name: <?php echo $post_image ?></p>
                    <p>Image Path: ../img/<?php echo $post_image ?></p>
                    <label for="post_image"></label>
                    <input name="post_image" type="file" class="form-control-file" id="post-image">
                </div>
                <div class="form-group">
                    <label for="post-content">Post Content</label>
                    <textarea name="post_desc" class="form-control" id="post-content" rows="6"><?php echo $post_desc; ?></textarea>
                </div>


                <button name="update-post" type="submit" class="btn btn-primary">Submit</button>

                <?php }
}
?>
            </form>
        </section>       
        <?php
                if(isset($_POST['update-post'])){
                    $post_title = $_POST['post_title'];
                    $post_cat_id = $_POST['cat_id'];
                    $post_status = $_POST['post_status'];
                    $post_desc = $_POST['post_desc'];
                    $postid = $_POST['edit-post-id'];
                    $post_date = date('j F Y');
                    $post_author = 'dee';
                    if (array_key_exists('post_image', $_FILES)) {
                        $post_image = $_FILES['post_image']['name'];
                        $post_temp_image = $_FILES['post_image']['tmp_name'];
                        if (is_uploaded_file($_FILES['post_image']['tmp_name'])) {
                            $moved = move_uploaded_file($_FILES['post_image']['tmp_name'], "../img/{$post_image}");
                            var_dump($moved); // Print the return value of the move_uploaded_file() function
                        }
                    }
                    echo $post_image;
                        $sql = 'UPDATE posts SET post_title = :title, post_desc = :desc, post_image = :image, post_date = :date, post_author = :author, post_cat_id = :cat_id, post_status = :status 
                        WHERE post_id = :postid';
                     
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':title'=>$post_title,
                            ':desc'=>$post_desc,
                            ':image'=> $post_image,
                            ':date'=> $post_date,
                            ':author' => $post_author,
                            ':cat_id' => $post_cat_id,
                            ':status' => $post_status,
                            ':postid' => $postid
                        ]);
                       header("Location: index.php"); 
                    }
                
            ?>

    </div>
<?php require_once './includes/footer.php' ?>