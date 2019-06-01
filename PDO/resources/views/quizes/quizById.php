<ol class="my-breadcrumb">
    <li><a href="<?= \core\router\generate('quizes') ?>">Quizes</a></li>
</ol>

<form action="<?= \core\router\generate('result') ?>" method="get">
    <ul>
        <?php foreach ($questions as $question): ?>
            <input type="hidden" name="questionId[]" value="<?= $question['question_id']; ?>">
            <li><?= $question['question_name']; ?>
                <ol>
                    <?php foreach ($question['answers'] as $answer): ?>

                        <li>
                            <input type="radio" name="question_<?= $question['question_id']; ?>"
                                   value="<?= $answer['id'] ?>">

                            <?= $answer['content']; ?>
                        </li>

                    <?php endforeach; ?>
                </ol>
            </li>
        <?php endforeach; ?>
    </ul>
    <input type="submit" value="Submit">
</form>
