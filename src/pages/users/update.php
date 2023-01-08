<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
if ($_SESSION["role"] != 1) {
    header("location: ../dashboard/dashboard.php");
    exit;
}
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $username = $_POST['username'] ?? '';
        $role_id = $_POST['role_id'] ?? '';

        // Update the record
        //FIXME: CHANGE FIELDS
        $stmt = $pdo->prepare('UPDATE users SET username = ?, role_id = ? WHERE id = ?');
        $stmt->execute([$username, $role_id, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        exit('Language doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

    <div class="content update">
        <h2>Update User #<?=$user['id']?></h2>
        <form action="update.php?id=<?=$user['id']?>" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" value="<?=$user['username']?>" id="username">
            <label for="role_id">Role ID</label>
            <input type="text" name="role_id" placeholder="Role ID" value="<?=$user['role_id']?>" id="role_id">
            <input type="submit" value="Update">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer()?>