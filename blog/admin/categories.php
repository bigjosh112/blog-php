<?php require_once './includes/header.php' ?>
<?php
if (!isset($_COOKIE['_ua_'])) {
    header("Location: sign-in.php");
}

?>
<div class="fluid-container">
    <?php require_once './includes/nav.php' ?>

    <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2">
        <?php
        if (isset($_POST['add-new-cat'])) {
            $cat_title = $_POST['cat_title'];
            $category_id = isset($category_id) ? $category_id : '0';
            if (empty($cat_title)) {
                echo '<div class="alert alert-danger">Field cannot be empty!</div>';
            } else {
                $sql2 = 'INSERT INTO categories (category_id, category_title) VALUE (:cat_id, :cat_t)';
                $stmt2 = $pdo->prepare($sql2);
                $stmt2->execute([
                    ':cat_id' => $category_id,
                    ':cat_t' => $cat_title
                ]);

                header("Location: categories.php");
            }
        }
        ?>
        <form class="py-4" method="POST" action="categories.php">
            <div class="row">
                <div class="col">
                    <input name="cat_title" type="text" class="form-control" placeholder="Enter category name">
                </div>
                <div class="col">
                    <input name="add-new-cat" type="submit" class="form-control btn btn-secondary" value="Add New Category">
                    <?php
                    if (isset($error)) {
                        echo $error;
                    }
                    ?>
                </div>
            </div>
        </form>
        <h2>All Categories</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Category name</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = 'SELECT * FROM categories';
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $cat_id = $category['category_id'];
                    $cat_title = $category['category_title']; ?>

                    <tr>
                        <td><?php echo $cat_id ?></td>
                        <td><?php echo $cat_title ?></td>
                        <td>
                            <form action="categories.php" method="POST">
                                <input type="hidden"  value="<?php echo $cat_id ?>" name="edit-cat-id">
                                <input type="submit" name="update-category" class="btn btn-link" value="Edit">
                            </form>
                        </td>

                        <td>
                            <form action="#" method="POST">
                                <input type="hidden" value="<?php echo $post_id ?>" name="val">
                                <input type="submit" name="delete-post" class="btn btn-link" value="Delete">
                            </form>
                        </td>
                    </tr>

                <?php }
                ?>
            </tbody>
        </table>
    </section>

</div>
<?php require_once './includes/footer.php' ?>