<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
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
            $name = $_POST['name'] ?? '';
            $age = $_POST['age'] ?? '';
            $nationality = $_POST['nationality'] ?? '';
            $address = $_POST['address'] ?? '';
            $course = $_POST['course'] ?? '';
            $stmt = $pdo->prepare('INSERT INTO me (name, age, nationality, address, course, image) VALUES (?, ?, ?, ?, ? ,?)');
            $stmt->execute([$name, $age, $nationality, $address, $course, $bd_upload.$_FILES["fileToUpload"]["name"]]);
            $msg = 'Created Successfully!';

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<?=template_header('Create')?>

    <div class="content update">
        <h2>Create about</h2>
        <form action="create.php" method="post"  enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Diogo" id="name">
            <label for="age">Age</label>
            <input type="text" name="age" placeholder="20 years old" id="age">
            <label for="nationality">Nationality</label>
            <input type="text" name="nationality" placeholder="Portuguese" id="nationality">
            <label for="address">Address</label>
            <input type="text" name="address" placeholder="Barcelos" id="address">
            <label for="course">Course</label>
            <input type="text" name="course" placeholder="Course" id="course">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Create" name="submit">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer()?>