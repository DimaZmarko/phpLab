<div class="sort-items">
    <span class="sort-items-desc">Results for: <span class="badge badge-warning"
                                                     id="find-name"><?= $_GET['search'] ?></span></span>
</div>
<?php

if (count($result) == 0) :
    echo 'No results for <b>' . $_GET['search'] . '</b>.</br>';
    echo 'Try checking your spelling or use more general terms';
else: ?>

    <?php foreach ($result as $quiz): ?>
        <li>
            <a href="<?= \core\router\generate('quiz_by_id', ['id' => $quiz['id']]) ?>">
                <h2><?= $quiz{'quiz_title'}; ?></h2>
                <div><?= $quiz{'quiz_desc'}; ?></div>
            </a>
        </li>

    <?php endforeach;
endif;
