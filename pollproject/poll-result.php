<?php
require 'config.php';
$pdo = pdo_connect_mysql();
//additional php code for this page goes here
if(isset($_GET['id'])){
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?')
    $stmt->execute([$_GET['id']])

    $poll = $stmt->fetch(PDO::FETCH_ASSOC)

    if($poll){
        $stmt = $pdo-> prepare('SELECT * FROM poll_answers WHERE poll_id = ? ORDER BY votes DESC')
        $stmt->execute([$_GET['id']])

        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC)

        $total_votes = 0;

        foreach($poll_answers as $poll_answer){
            $total_votes += $poll_answer['votes']
        }
    } else{
        die('The poll with that id does not exist');
    }
}else{
    die('No poll ID specified')
}
?>

<?= template_header('Results') ?>
<?= template_nav() ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Poll Results</h1>
    <h2 class="subtitle"><?=$poll['title']?> (Total Votes: <?=$total_votes?>)</h2>
    <div class="container">
        <?php foreach ($poll_answers as $poll_answer):?>
            <p><?=$poll_answers['title']?></p>
            <progress class="progress is-primary is-large" value="<?= @round(($poll_answer['votes'] / $total_votes) / 100)?>" max="<?=$total_votes * 2?>"></progress>
        <?php endforeach?>
    </div>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>