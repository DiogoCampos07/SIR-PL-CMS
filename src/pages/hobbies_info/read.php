<?php
require "../../utils/functions.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();
$id_hobbies = $_GET['id'];

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;

// Prepare the SQL statement and get records from our hobbies table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM hobbies_info where isdeleted = false and hobbies_id = :id_hobbies ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':id_hobbies', $id_hobbies, PDO::PARAM_INT);
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$hobbies_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of hobbies, this is so we can determine whether there should be a next and previous button
$num_hobbies_info = $pdo->prepare('SELECT  count(*) FROM hobbies_info where isdeleted = false and hobbies_id = :id_hobbies');
$num_hobbies_info->bindValue(':id_hobbies', $id_hobbies, PDO::PARAM_INT);
$num_hobbies_info->fetchColumn();
?>

<?=template_header('Read')?>

    <div class="content read">
        <h2>Hobbies Info</h2>
        <a href="create.php?id=<?=$id_hobbies?>" class="btn btn-dark mb-3">Create Hobbies Info</a>
        <table class="table table-hover text-center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Image</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($hobbies_info as $hobbies): ?>
                <tr>
                    <td><?=$hobbies['id']?></td>
                    <td><?=$hobbies['title']?></td>
                    <td><img src="../../<?=$hobbies['image']?>" alt="test" height="100" width="100"></td>
                    <td><?=$hobbies['description']?></td>
                    <td>
                        <a href="update.php?id=<?=$hobbies['id']?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                        <?php if ($_SESSION["role"] == 1): ?>
                            <a href="delete.php?id=<?=$hobbies['id']?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
            <?php endif; ?>
            <?php if ($page*$records_per_page < $num_hobbies_info): ?>
                <a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
        </div>
    </div>

<?=template_footer()?>