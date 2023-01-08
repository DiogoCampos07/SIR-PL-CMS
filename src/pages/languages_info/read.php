<?php
require "../../utils/functions.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();
$id_languages = $_GET['id'];

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;

// Prepare the SQL statement and get records from our languages table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM languages_info where isdeleted = false and languages_id = :id_languages ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':id_languages', $id_languages, PDO::PARAM_INT);
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$languages_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_languages_info = $pdo->prepare('SELECT  count(*) FROM languages_info where isdeleted = false and languages_id = :id_languages');
$num_languages_info->bindValue(':id_languages', $id_languages, PDO::PARAM_INT);
$num_languages_info->fetchColumn();
?>

<?=template_header('Read')?>

    <div class="content read">
        <h2>Languages Info</h2>
        <a href="create.php?id=<?=$id_languages?>" class="btn btn-dark mb-3">Create Languages Info</a>
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
            <?php foreach ($languages_info as $languages): ?>
                <tr>
                    <td><?=$languages['id']?></td>
                    <td><?=$languages['title']?></td>
                    <td><img src="../../<?=$languages['image']?>" alt="test" height="100" width="100"></td>
                    <td><?=$languages['description']?></td>
                    <td>
                        <a href="update.php?id=<?=$languages['id']?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                        <?php if ($_SESSION["role"] == 1): ?>
                            <a href="delete.php?id=<?=$languages['id']?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
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
            <?php if ($page*$records_per_page < $num_languages_info): ?>
                <a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
        </div>
    </div>

<?=template_footer()?>