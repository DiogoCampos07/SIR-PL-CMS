<?php

require "../../utils/functions.php";
require "../../db/connection.php";
$pdo = pdo_connect_mysql();

if ($_SESSION["role"] != 1) {
    header("location: ../dashboard/dashboard.php");
    exit;
}

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please fill username.";
    }
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Wrong username pattern!";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);

            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "Username already exists!";
                }
                else{
                    $username = trim($_POST["username"]);
                }
            }
            else{
                echo "Ups! Try again please.";
            }

            unset($stmt);
        }
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Pelase fill password.";
    }
    elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password need to be at least 6 chareters.";
    }
    else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please fill confirm password.";
    }
    else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords missmatch!";
        }
    }

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        $sql = "INSERT INTO users (username, password, role_id, me_id) VALUES (:username, :password, :role_id, :me_id)";

        if($stmt = $pdo->prepare($sql)){
            $param_me_id = 1;
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":role_id", $param_role_id, PDO::PARAM_STR);
            $stmt->bindParam(":me_id", $param_me_id, PDO::PARAM_STR);


            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_role_id = $_POST["role_id"];

            if($stmt->execute()){
                header("location: read.php");
            }
            else{
                echo "Ups! Try again please.";
            }

            unset($stmt);
        }
    }

    unset($pdo);
}
?>

<?=template_header('Create')?>

    <div class="content update">
        <h2>Create User</h2>
        <form action="create.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="Username" id="username" <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" id="password" <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>

            <div class="form-group mb-3">
                <label>Role:</label> &nbsp;
                <input type="radio" name="role_id" id="admin" class="form-check-input" value=1>
                <label class="form-input-label" for="admin">Admin</label>
                &nbsp;
                <input type="radio" name="role_id" id="manager" class="form-check-input" value=2>
                <label class="form-input-label" for="manager">Manager</label>
            </div>

            <input type="submit" value="Create">
        </form>
    </div>

<?=template_footer()?>