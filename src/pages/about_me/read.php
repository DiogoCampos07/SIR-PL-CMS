<?php
require "../../utils/functions.php";
require "../../db/connection.php";

// Connect to MySQL database
$pdo = pdo_connect_mysql();

// Get the page via GET request (URL param: page), if non exists default the page to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;

// Prepare the SQL statement and get records from our languages table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM me where isdeleted = false ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the records so we can display them in our template.
$about_me = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_me = $pdo->query('SELECT COUNT(*) FROM me where isdeleted = false')->fetchColumn();
?>

<?=template_header('Read')?>

    <div class="content read">
        <h2>About me</h2>
        <a href="create.php" class="btn btn-dark mb-3">Create Info About Me</a>
        <table class="table table-hover text-center">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Age</th>
                <th scope="col">Nationality</th>
                <th scope="col">Address</th>
                <th scope="col">Course</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($about_me as $me): ?>
                <tr>
                    <td><?=$me['id']?></td>
                    <td><?=$me['name']?></td>
                    <td><?=$me['age']?></td>
                    <td><?=$me['nationality']?></td>
                    <td><?=$me['address']?></td>
                    <td><?=$me['course']?></td>
                    <td><img src="../../<?=$me['image']?>" alt="test" height="100" width="100"></td>
                    <td>
                        <a href="update.php?id=<?=$me['id']?>" class="link-dark"><i class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                        <?php if ($_SESSION["role"] == 1): ?>
                            <a href="delete.php?id=<?=$me['id']?>" class="link-dark"><i class="fa-solid fa-trash fs-5"></i></a>
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
            <?php if ($page*$records_per_page < $num_me): ?>
                <a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
            <?php endif; ?>
        </div>
    </div>

<?=template_footer()?>