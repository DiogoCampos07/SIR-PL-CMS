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
    $stmt = $pdo->prepare('SELECT * FROM languages WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $languages = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$languages) {
        exit('Language doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('UPDATE languages l, languages_info li SET l.isdeleted = true, li.isdeleted = true, 
                                    li.languages_id = null
                                WHERE l.id = ? and li.languages_id = ?');
            $stmt->execute([$_GET['id'], $_GET['id']]);
            $msg = 'You have soft-deleted languagues and languages information!';
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
        <h2>Delete Languages, Languages Info#<?=$languages['id']?></h2>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php else: ?>
            <p>Are you sure you want to delete languages info #<?=$languages['id']?>?</p>
            <div class="yesno">
                <a href="delete.php?id=<?=$languages['id']?>&confirm=yes">Yes</a>
                <a href="delete.php?id=<?=$languages['id']?>&confirm=no">No</a>
            </div>
        <?php endif; ?>
    </div>

<?=template_footer()?>