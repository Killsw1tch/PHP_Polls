<?php
require 'config.php';

//additional php code for this page goes here
$pdo = pdo_connect_mysql();

$msg ="";

if(!empty($_POST)){
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $title = isset($_POST['desc']) ? $_POST['desc'] : '';

    $stmt = $pdo->prepare('INSERT INTO polls VALUES (NULL, ?, ?)')
    $stmt->execute([$title, $desc])

    $poll_id = $pdo->lastInsertId();

    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';
    foreach($answers as $answer){
        if(empty($answers)) continue;
        $stmt = $pdo->prepare('INSERT INTO poll_answers VALUES (NULL, ?, ?, 0)')
        $stmt->execute([$poll_id, $answer])
    }
    $msg = "Poll created successfully!";
}

?>

<?= template_header('Create Poll') ?>
<?= template_nav() ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Create Poll</h1>
    <? php if ($msg)?>
        <div class="notification is-success">
            <h2 class="title is-2"><?php echo $msg; ?></h2>
        </div>
    <? php endif; ?>

    <form method="post" action="">
        <div class="field">
            <label class="label">Title</label>
            <div class="control">
            <input type="text" name="title" class="input" placeholder="Poll Title">
            </div>
        </div>
        <div class="field">
            <label class="label">Description</label>
            <div class="control">
            <input type="text" name="desc" class="input" placeholder="Poll Description">
            </div>
        </div>
        <div class="field">
            <label class="label">Answers (per line)</label>
            <div class="control">
            <textarea type="textarea" name="answers" class="textarea" placeholder="Answerts"></textarea>
            </div>
        </div>
        <div class="field">
            <label class="label">Description</label>
            <div class="control">
            <button class="button is-link">Submit</button>
            </div>
        </div>
    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>