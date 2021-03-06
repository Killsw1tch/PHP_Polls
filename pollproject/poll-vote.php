<?php
require 'config.php';
$pdo = pdo_connect_mysql();
//additional php code for this page goes here

if(isset($_GET['id'])){
    $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?')
    $stmt->execute([$_GET['id']])

    $poll = $stmt->fetch(PDO::FETCH_ASSOC)

    if($poll){
        $stmt = $pdo-> prepare('SELECT * FROM poll_answers WHERE poll_id = ?')
        $stmt->execute([$_GET['id']])

        $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC)

        if(isset($_POST['poll_answer'])){
            $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?')
            $stmt->execute([$_POST['poll_answers']])
            header('Location: poll-result.php?id=' . $_GET['id'])
            exit;
        }
        
    }else{
            die('Poll with that id does not exist')
        }
    }else{
    die('No id is set');
}

?>

<?= template_header('Poll Vote') ?>
<?= template_nav() ?>

    <!-- START PAGE CONTENT -->
    <h1 class="title">Vote - <?= $poll['title']?></h1>
    <h2 class="subtitle"><?= $poll['desc']?></h2>
    <form action="poll-vote.php?id=<?=$_GET['id']?>" method="post">
        <? php for ($i = 0; $i < count($poll_answers); $i++)?>
        <div class="control">
            <label for="" class="radio">
                <input type="radio" name="poll_answer" value="<?=$poll_answers[$i]['id']?>" <?= $i == 0 ? 'checked' : '' ?>>
                <?=$poll_answers[$i]['title']?>
            </label>
        </div>
        <? php endfor; ?>
        <div class="field">
            <div class="control">
                <button class="button" value="Vote" type="submit">Vote</button>
            </div>
        </div>
    </form>
    <!-- END PAGE CONTENT -->

<?= template_footer() ?>