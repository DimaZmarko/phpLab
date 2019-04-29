<?php
/**
 *
 * books loop part
 *
 **/
?>

<div class="col-12 col-md-6 d-flex" id="<?= $booksToDisplay[$i]['ISBN'] ?>">
    <div class="book_item">
        <h2><?= $booksToDisplay[$i]['name'] ?></h2>
        <?php
        if (isset($booksToDisplay[$i]['tags'])) :
            ?>
            <ul class="book_tags">
                <?php
                foreach ($booksToDisplay[$i]['tags'] as $tag) : ?>
                    <li>
                        <a href="#" data-target="<?= $tag ?>"><?= $tag ?></a>
                    </li>
                <?php
                endforeach;
                ?>
            </ul>
        <?php
        endif;
        ?>
        <p class="book_image">
            <a target="_blank" href="<?= $booksToDisplay[$i]['poster'] ?>">
                <img src="<?= $booksToDisplay[$i]['poster'] ?>" alt="poster">
            </a>
        </p>
        <p class="book_url">
            <span>URL: </span>
            <a target="_blank" href="<?= $booksToDisplay[$i]['url'] ?>">
                <?= $booksToDisplay[$i]['url'] ?>
            </a>
        </p>
        <p class="book_price">PRICE:
            <span><?= $booksToDisplay[$i]['price'] ?></span>
        </p>
    </div>
</div>