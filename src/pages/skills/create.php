<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
if (!empty($_POST)) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $stmt = $pdo->prepare('INSERT INTO skills (title, description, me_id) VALUES (?, ?, ?)');
    $stmt->execute([$title, $description, 1]);
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

    <div class="content update">
        <h2>Create Skills</h2>
        <form action="create.php" method="post">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="Title" id="title">
            <label for="description">Description</label>
            <input type="text" name="description" placeholder="Description" id="description">
            <input type="submit" value="Create">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer()?>