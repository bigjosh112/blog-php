<?php require_once './includes/header.php' ?>
<div class="fluid-container">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-md-5 p-3">
    <?php require_once './includes/navigation.php' ?>
  </nav> <!--End nav-->

  <section id="main">
    <div class="post-single-information">
      <?php
      if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = 'SELECT * FROM posts WHERE post_id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $count = $stmt->rowCount();
        if ($count == 1) {
          while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $post_title = $post['post_title'];
            $post_desc = $post['post_desc'];
            $post_image = $post['post_image'];
            $post_cat_id = $post['post_cat_id'];
            $post_date = $post['post_date'];
            $post_author = $post['post_author']; ?>

            <div class="post-single-info">
              <div class="post-single-80">

                <h1 class="category-title">Category:
                  <?php
                  $sql1 = 'SELECT * FROM categories WHERE category_id = :id';
                  $stmt1 = $pdo->prepare($sql1);
                  $stmt1->execute([':id' => $post_cat_id]);
                  while ($category = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                    $category_title = $category['category_title'];
                  }

                  echo $category_title;
                  ?>
                </h1>
                <h2 class="post-single-title">Title: <?php echo $post_title ?></h2>
                <div class="post-single-box">
                  Posted by <?php echo $post_author ?> at <?php echo $post_date ?>
                </div>
              </div>
            </div>
            <div class="post-main">
              <img class="d-block" style="width:100%;height:400px" src="./img/<?php echo $post_image ?>" alt="photo" />
              <p class="mt-4">
                <?php echo $post_desc ?>
              </p>
            </div>
    </div>

<?php }
        } else {
          echo "<p class ='alert alert-danger'>No page found! </p>";
        }
      }
?>



<div class="comments">
  <?php
  if (isset($_GET['id'])) {
    $sql2 = 'SELECT * FROM comments WHERE comment_post_id = :id';
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([
      ':id' => $_GET['id']
    ]);
    // Rest of your code...
    $comment_count = $stmt2->rowCount();
    if ($comment_count == 0) {
      echo "No comment";
    } else {
      echo '<h2 class="comment-count">' . $comment_count . ' Comments</h2>';
      while ($comment = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        $comment_author = $comment['comment_author'];
        $comment_desc = $comment['comment_desc'];
        $comment_date = $comment['comment_date']; ?>




        <div class="comment-box">
          <img src="./img/img-1.jpg" style="width:88px;height:88px;border-radius:50%" alt="Author photo" class="comment-photo">
          <div class="comment-content">
            <span class="comment-author"><b><?php echo $comment_author ?></b></span>
            <span class="comment-date"><?php echo $comment_date ?></span>
            <p class="comment-text">
              <?php echo $comment_desc ?>
            </p>
          </div>
        </div>


  <?php }
    }
  }

  ?>


  <div class="container">
    <h3 class="leave-comment">Leave a comment</h3>
    <?php
    if (isset($_POST['submit-comment'])) {
      $name = trim($_POST['name']);
      $comment = trim($_POST['comment']);
      $date = date('j Y F');
      if (empty($name) || empty($comment)) {
        echo '<div class="alert alert-danger">No comment</div>';
      } else {
        $sql4 = 'INSERT INTO comments (comment_desc, comment_date, comment_author, comment_post_id)
        VALUES (:comment,:date, :name, :comment_post_id)';
        $stmt4 = $pdo->prepare($sql4);
        if (isset($_GET['id'])) {
          $stmt4->execute([
            ':comment' => $comment,
            ':date' => $date,
            ':name' => $name,
            ':comment_post_id' => $_GET['id']
          ]);
          try {
            $sql5 = 'UPDATE posts SET post_comment = post_comment + 1 WHERE post_id = :id';
            $stmt5 = $pdo->prepare($sql5);
            $stmt5->execute([':id'=> $id]);
         } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
         }
         

          header("Location: single.php?id={$id}");
        }
      }
    }


    ?>
    <div class="comment-submit">
      <form action="http://localhost:3000/single.php?id=<?php echo $_GET['id'] ?>" class="comment-form" method="POST">
        <input class="input" type="text" placeholder="Enter Full Name" name="name">
        <textarea name="comment" id="" cols="20" rows="5" placeholder="Comment text"></textarea>
        <input type="submit" value="Submit" class="comment-btn" name="submit-comment">
      </form>
    </div>
  </div>
  </section>

  <?php require_once './includes/footer.php' ?>