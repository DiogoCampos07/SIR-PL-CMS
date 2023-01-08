<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';

$id = $_GET['id'];

if (!empty($_POST)) {
    $target_dir = "../../assets/";


    $target_file = $target_dir . $_FILES["fileToUpload"]["name"];
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    $bd_upload = "assets/";

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $stmt = $pdo->prepare('INSERT INTO languages_info (title, image, description, languages_id) VALUES (?, ?, ?, ?)');
            $stmt->execute([$title, $bd_upload.$_FILES["fileToUpload"]["name"], $description, $id]);
            $msg = 'Created Successfully!';
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

}
?>


<?=template_header('Create')?>

    <div class="content update">
        <h2>Create Languages Info</h2>
        <form action="create.php?id=<?=$id?>" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="Title" id="title">
            <label for="description">Description</label>
            <input type="text" name="description" placeholder="Description" id="description">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Create" name="submit">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer()?>