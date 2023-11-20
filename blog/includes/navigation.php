<a class="navbar-brand" href="index.php" style="font-size: 22px">Blog</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <?php
        $sql = 'SELECT * FROM categories';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        while ($category = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category_id = $category['category_id'];
            $category_title = $category['category_title']; ?>
            <li class="nav-item">
                <a class="nav-link" href="categories.php?id=<?php echo $category_id ?>"><?php echo $category_title ?></a>
            </li>

        <?php }
        ?>
    </ul>
    <form class="form-inline my-2 my-lg-0" method="POST" action="http://localhost:3000/search.php">
        <input class="form-control mr-sm-2" style="font-size: 14px" name="val" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
</div>