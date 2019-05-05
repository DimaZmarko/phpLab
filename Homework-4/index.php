<?php require_once 'header.php'; ?>

    <main class="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 filters">
                    <div>
                        <h3>Books per page:</h3>
                        <form id="form-pagination" action="inc/filter.php" method="POST">
                            <input name="books_per_page" type="number" min="1" max="6" value="<?= $pagesInputValue ?>">
                            <button type="submit" class="btn btn-info">Apply</button>
                        </form>
                    </div>
                    <div>
                        <h3>Search a book:</h3>
                        <form id="form-search" action="inc/filter.php" method="POST">
                            <input name="search" type="text" required>
                            <button type="submit" class="btn btn-info">Search</button>
                        </form>
                    </div>
                    <div>
                        <h3>Order by:</h3>
                        <form action="inc/filter.php" class="order_by" method="POST">
                            <p>
                                <label><input name="price_name" type="radio"
                                              value="price" <?= checkOrderCookies('price') ?>>Price</label>
                                <label><input name="price_name" type="radio"
                                              value="name" <?= checkOrderCookies('name') ?>>Name</label></p>
                        </form>
                    </div>
                    <div>
                        <h3>Choose tags:</h3>
                        <form action="inc/filter.php" class="form_tags" method="POST">
                            <?php
                            foreach ($bookTags as $tag) {
                                ?>
                                <p><label><input type="checkbox" name="tag[<?= $tag ?>]"
                                                 value="<?= $tag ?>" <?= checkTagCookies($tag) ?>><?= $tag ?>
                                    </label></p>
                                <?php
                            }
                            ?>
                            <button type="submit" class="btn btn-info">Filter</button>
                        </form>
                        <?php
                        if (isset($_COOKIE['tags']) || isset($_COOKIE['price_name'])) {
                            ?>
                            <form id="reset_filters" action="inc/filter.php" method="POST">
                                <input type="hidden" name="reset_filters">
                                <button type="submit" class="btn btn-danger">Reset</button>
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-8 books">
                    <div class="container-fluid">
                        <?php
                        if (count($booksToDisplay) > 0) {
                            ?>
                            <div class="row message">

                                <?php
                                if (isset($_SESSION["books_search"])) {
                                    ?>
                                    <div class="col-12">
                                        <?php
                                        if ($searchResults === true) {
                                            ?>
                                            <div>You have been searching the
                                                <span>"<?= $_SESSION["books_search"] ?>"</span>
                                            </div>
                                            <form action="inc/filter.php" method="POST">
                                                <input name="reset_search" type="hidden">
                                                <button type="submit" class="btn btn-danger">Reset results</button>
                                            </form>
                                            <?php
                                        } else {
                                            unset($_SESSION["books_search"]);
                                            ?>
                                            <div>Your search returned no results</div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php
                                } ?>
                            </div>
                            <div class="row books_list">
                                <?php
                                for ($i = $pagesInputValue * ($currentPage - 1);
                                     $i < ($pagesInputValue + ($pagesInputValue * ($currentPage - 1)));
                                     $i++) {
                                    if (!isset($booksToDisplay[$i])) {
                                        break;
                                    }
                                    include 'loop/book.php';
                                }
                                ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row pages_nav">
                            <?php
                            if ($pageCount > 1) {
                                ?>
                                <ul>
                                    <?php
                                    for ($i = 1; $i <= $pageCount; $i++) {
                                        if ($i === 1) {
                                            ?>
                                            <li>
                                                <a href="?page=<?= $i ?>">&lt&lt</a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <li>
                                            <a href="?page=<?= $i ?>"
                                                <?= (isset($currentPage) && ($currentPage == $i))
                                                || (!isset($currentPage) && $i === 1) ? 'class="selected"' : '' ?>>
                                                <?= $i ?>
                                            </a>
                                        </li>
                                        <?php
                                        if ($i == $pageCount) {
                                            ?>
                                            <li><a href="?page=<?= $i ?>">&gt&gt</a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php require_once 'footer.php';
