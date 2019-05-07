<?php
/**
 *
 * books loop part
 *
 **/
?>

<div class="col-12 col-md-6 d-flex" id="<?= $book['ISBN'] ?>">
    <div class="book_item">
        <h2><?= $book['name'] ?></h2>
        <?php
        if (isset($book['tags'])) :
            ?>
            <ul class="book_tags">
                <?php
                foreach ($book['tags'] as $tag) : ?>
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
            <a target="_blank" href="<?= $book['poster'] ?>">
                <img src="<?= $book['poster'] ?>" alt="poster">
            </a>
        </p>
        <p class="book_url">
            <span>URL: </span>
            <a target="_blank" href="<?= $book['url'] ?>">
                <?= $book['url'] ?>
            </a>
        </p>
        <p class="book_price">PRICE:
            <span><?= $book['price'] ?></span>
        </p>
    </div>
</div>