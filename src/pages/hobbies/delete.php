<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();

if ($_SESSION["role"] != 1) {
    header("location: ../dashboard/dashboard.php");
    exit;
}

$msg = '';
// Check that the hobbies ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM hobbies WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $hobbies = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$hobbies) {
        exit('Hobbies doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('UPDATE hobbies h, hobbies_info hi SET h.isdeleted = true, hi.isdeleted = true, 
                                    hi.hobbies_id = null
                                WHERE h.id = ? and hi.hobbies_id = ?');
            $stmt->execute([$_GET['id'], $_GET['id']]);
            $msg = 'You have soft-deleted hobbies and hobbies information!';
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
        <h2>Delete hobbies, hobbies Info#<?=$hobbies['id']?></h2>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php else: ?>
            <p>Are you sure you want to delete hobbies info #<?=$hobbies['id']?>?</p>
            <div class="yesno">
                <a href="delete.php?id=<?=$hobbies['id']?>&confirm=yes">Yes</a>
                <a href="delete.php?id=<?=$hobbies['id']?>&confirm=no">No</a>
            </div>
        <?php endif; ?>
    </div>

<?=template_footer()?>