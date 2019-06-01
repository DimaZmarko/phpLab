<?php
if (!$_SERVER['QUERY_STRING'] || (strpos($_SERVER['QUERY_STRING'], 'page') === 0)) :?>
    <ul>
        <?php
        foreach ($quizes as $quiz) : ?>

            <li>
                <a href="<?= \core\router\generate('quiz_by_id', ['id' => $quiz['id']]) ?>">
                    <h2><?= $quiz{'quiz_title'}; ?></h2>
                    <div><?= $quiz{'quiz_desc'}; ?></div>
                </a>
            </li>

        <?php endforeach; ?>
    </ul>
<!--    <div class="pagination-page">-->
<!--        <nav aria-label="Page navigation example">-->
<!--            <ul class="pagination">-->
<!--                --><?php //for ($page = 1; $page <= 4; $page++) : ?>
<!--                    --><?php //if (isset($_GET['sort_by'])) : ?>
<!--                        <li class="page-item">-->
<!--                            <a class="page-link"-->
<!--                               href='?sort_by=--><?//= $_GET['sort_by'] ?><!--&page=--><?//= $page ?><!--'>--><?//= $page ?><!--</a>-->
<!--                        </li>-->
<!--                    --><?php //else: ?>
<!--                        <li class="page-item">-->
<!--                            <a class="page-link" href='?page=--><?//= $page ?><!--'>--><?//= $page ?><!--</a>-->
<!--                        </li>-->
<!--                    --><?php //endif; endfor; ?>
<!--            </ul>-->
<!--        </nav>-->
<!--    </div>-->
<?php endif; ?>