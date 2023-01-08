<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../auth/login.php");
    exit;
}

function template_header($title)
{
    $username = $_SESSION["username"];
    $role = $_SESSION["role"];

    echo sprintf('<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Diogo Campos - 24888 - CMS</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />		
		<link href="styles.css" rel="stylesheet" type="text/css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Hello %s</h1>
    		%s
    		%s
    		<a href="../about_me/read.php"><i class="fas fa-address-book"></i>About me</a>
    		<a href="../education/read.php"><i class="fas fa-address-book"></i>Education</a>
    		<a href="../skills/read.php"><i class="fas fa-address-book"></i>Skills</a>
    		<a href="../languages/read.php"><i class="fas fa-address-book"></i>Languages</a>
    		<a href="../hobbies/read.php"><i class="fas fa-address-book"></i>Hobbies</a>
            <a href="../footer/read.php"><i class="fas fa-address-book"></i>Footer</a>
            <a href="../salary/read.php"><i class="fas fa-address-book"></i>Salary</a>
			<a href="../../auth/logout.php">Logout</a>
    	</div>
    </nav>',
        $username,
        $role == 1 ? '<a href="../users/read.php"><i class="fas fa-address-book"></i>Users</a>' : '',
        $role == 1 ? '<a href="../contacts/read.php"><i class="fas fa-address-book"></i>Contacts</a>' : ''
    );
}
function template_footer() {
echo <<<EOT
    </body>
</html>
EOT;
}
