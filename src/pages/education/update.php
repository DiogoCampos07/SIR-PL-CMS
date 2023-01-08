<?php
require "../../utils/functions.php";
require "../../db/connection.php";

$pdo = pdo_connect_mysql();
$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
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
                // This part is similar to the create.php, but instead we update a record and not insert
                $title = $_POST['title'] ?? '';
                $high_school = $_POST['high_school'] ?? '';
                $degree = $_POST['degree'] ?? '';

                // Update the record
                //FIXME: CHANGE FIELDS
                $stmt = $pdo->prepare('UPDATE education SET title = ?, image = ?, high_school = ?, degree = ? WHERE id = ?');
                $stmt->execute([$title, $bd_upload.$_FILES["fileToUpload"]["name"], $high_school, $degree, $_GET['id']]);
                $msg = 'Updated Successfully!';

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM education WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $education = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$education) {
        exit('Language doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

    <div class="content update">
        <h2>Update Education #<?=$education['id']?></h2>
        <form action="update.php?id=<?=$education['id']?>" method="post" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="title" placeholder="Title" value="<?=$education['title']?>" id="title">
            <label for="high_school">High School</label>
            <input type="text" name="high_school" placeholder="High School" value="<?=$education['high_school']?>" id="high_school">
            <label for="degree">Degree</label>
            <input type="text" name="degree" placeholder="Degree" value="<?=$education['degree']?>" id="degree">
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Update" name="submit">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer()?>