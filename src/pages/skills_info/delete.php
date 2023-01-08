<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
if ($_SESSION["role"] != 1) {
    header("location: ../dashboard/dashboard.php");
    exit;
}
$msg = '';
// Check that the language ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM skills_info WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $skills_info = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$skills_info) {
        exit('Language doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('UPDATE skills_info SET isdeleted = true WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have soft-deleted the about me information!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

    <div class="content delete">
        <h2>Delete skills info #<?=$skills_info['id']?></h2>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php else: ?>
            <p>Are you sure you want to delete skills info #<?=$skills_info['id']?>?</p>
            <div class="yesno">
                <a href="delete.php?id=<?=$skills_info['id']?>&confirm=yes">Yes</a>
                <a href="delete.php?id=<?=$skills_info['id']?>&confirm=no">No</a>
            </div>
        <?php endif; ?>
    </div>

<?=template_footer()?>