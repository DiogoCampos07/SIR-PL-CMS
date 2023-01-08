<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';

        // Update the record
        //FIXME: CHANGE FIELDS
        $stmt = $pdo->prepare('UPDATE hobbies SET title = ?, description = ? WHERE id = ?');
        $stmt->execute([$title, $description, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the language from the hobbies table
    $stmt = $pdo->prepare('SELECT * FROM hobbies WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $hobbies = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$hobbies) {
        exit('Language doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

    <div class="content update">
        <h2>Update Hobbies #<?=$hobbies['id']?></h2>
        <form action="update.php?id=<?=$hobbies['id']?>" method="post">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="Title" value="<?=$hobbies['title']?>" id="title">
            <label for="description">Description</label>
            <input type="text" name="description" placeholder="Description" value="<?=$hobbies['description']?>" id="description">
            <input type="submit" value="Update">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer()?>