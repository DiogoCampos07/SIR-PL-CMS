<?php
require "db/connection.php";

$pdo = pdo_connect_mysql();

// ME
$stmt = $pdo->prepare('SELECT * FROM me WHERE id = 5 AND isdeleted = false');
$stmt->execute();
$me = $stmt->fetch(PDO::FETCH_ASSOC);

// EDUCATION
$stmt = $pdo->prepare('SELECT * from education WHERE me_id = 1 AND isdeleted = false');
$stmt->execute();
$educations = $stmt->fetch(PDO::FETCH_ASSOC);

// FOOTER
$stmt = $pdo->prepare('SELECT * from footer WHERE me_id = 1 AND isdeleted = false');
$stmt->execute();
$footer = $stmt->fetchAll(PDO::FETCH_ASSOC);

// SKILLS
$stmt = $pdo->prepare('SELECT * from skills WHERE me_id = 1 AND isdeleted = false');
$stmt->execute();
$skills = $stmt->fetch(PDO::FETCH_ASSOC);

// SKILLS_INFO
$stmt = $pdo->prepare('SELECT * from skills_info WHERE isdeleted = false AND skills_id = :id_skills');
$stmt->bindValue(':id_skills', $skills['id'], PDO::PARAM_INT);
$stmt->execute();
$skills_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

// LANGUAGES
$stmt = $pdo->prepare('SELECT * from languages WHERE me_id = 1 AND isdeleted = false');
$stmt->execute();
$languages = $stmt->fetch(PDO::FETCH_ASSOC);

// LANGUAGES_INFO
$stmt = $pdo->prepare('SELECT * from languages_info WHERE isdeleted = false AND languages_id = :id_languages');
$stmt->bindValue(':id_languages', $languages['id'], PDO::PARAM_INT);
$stmt->execute();
$languages_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

// HOBBIES
$stmt = $pdo->prepare('SELECT * from hobbies WHERE me_id = 1 AND isdeleted = false');
$stmt->execute();
$hobbies = $stmt->fetch(PDO::FETCH_ASSOC);

// HOBBIES_INFO
$stmt = $pdo->prepare('SELECT * from hobbies_info WHERE isdeleted = false AND hobbies_id = :id_hobbies');
$stmt->bindValue(':id_hobbies', $hobbies['id'], PDO::PARAM_INT);
$stmt->execute();
$hobbies_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

// SUBMIT MESSAGE
if (!empty($_POST)) {
    $name = $_POST['name'] ?? '';
    $email= $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    $stmt = $pdo->prepare('INSERT INTO contacts (name, email, message, me_id) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $email,$message, 1]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <script src="navbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Ficha 4, 5, 6 Bootstrap</title>

    <nav id="navbar" class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand text-white" href="#"><span class="blue">Diogo </span> Campos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 nav-style bg-blue">
                    <li>
                        <a class="nav-link text-white mx-3" href="#info">About me</a>
                    </li>
                    <li>
                        <a class="nav-link text-white mx-2" href="#educacao">Education</a>
                    </li>
                    <li>
                        <a class="nav-link text-white mx-2" href="#skills">Skills</a>
                    </li>
                    <li>
                        <a class="nav-link text-white mx-2" href="#linguagens">Languages</a>
                    </li>
                    <li>
                        <a class="nav-link text-white mx-2" href="#hobbies">Hobbies</a>
                    </li>
                    <li>
                        <a class="nav-link text-white mx-3" href="#contactos">Contacts</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</head>

<body>

<!-- Informacao Pessoal section -->

<div>
    <section id="info" class="info">
        <div class="container">
            <div class="row justify-content-center">
                <div class="cold-11 col-sm-9 col-md-6 col-lg-6">
                    <div class="text-center justify-content-center">
                        <h2 class="text-white mt-5">Hi, I'm <span class="blue"><?= $me["name"] ?>,</span></h2>
                            <h3 class="text-white mt-2">I'm <span class="blue"><?= $me["nationality"] ?>,</span></h3>
                                <h3 class="text-white mt-2">I'm <span class="blue"><?= $me["age"] ?> years old</span> and I live in <span
                                        class="blue"><?= $me["address"] ?>,</span></h3>
                                    <h2 class="text-white mt-2">I'm studying  <span class="blue"><?= $me["course"] ?></span></h2>
                    </div>
                </div>
                <div class="col-10 col-md-6 col-lg-5">
                    <img src="<?= $me["image"] ?>" alt="Campos" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
</div>

<!-- educacao section -->

<section id="educacao" class="educacao section-padding">
    <div class="container margins">
        <div class="row">
            <div class="col-lg-5 col-md-7 col-12">
                <div class="about-img">
                    <img src="<?= $educations["image"] ?>" alt="" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-12">
                <div class="about-next">
                    <h2 class="blue mt-lg-5 pt-xl-5"><?= $educations["title"] ?></h2>
                    <p class="lead"><?= $educations["degree"] ?>.</p>
                    <p class="lead"><?= $educations["high_school"] ?>.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- skills section -->

<div class="bg-grey">
    <section id="skills" class="skills section-padding">
        <div class="container margins">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <div class="about-next">
                            <h2 class="blue"><?= $skills["title"] ?></h2>
                            <p class="lead"><?= $skills["description"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($skills_info as $skills_inf): ?>
                    <div class="col-12 col-md-12 col-lg-4 mt-4">
                        <div class="card text-center bg-white pb-2">
                            <div class="card-body">
                                <div class="img-area mb-4">
                                    <img src=<?= $skills_inf["image"] ?> alt="" class="img-fluid">
                                </div>
                                <h3 class="card-title blue"><?= $skills_inf["title"] ?></h3>
                                <p class="lead"> <?= $skills_inf["description"] ?>.
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<!-- Linguagens section -->

<section id="linguagens" class="linguagens section-padding">
    <div class="container margins">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header text-center pb-5">
                    <h2 class="blue"><?= $languages["title"] ?></h2>
                    <p class="lead"><?= $languages["description"] ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($languages_info as $languages_inf): ?>
                <div class="col-12 col-md-6 col-lg-4 mt-4">
                    <div class="card text-center pb-2">
                        <div class="card-body">
                            <img src="<?= $languages_inf["image"] ?>" alt="" class="img-fluid">
                            <h3 class="card-title blue"><?= $languages_inf["title"] ?></h3>
                            <p class="lead"><?= $languages_inf["description"] ?>.</p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- hobbies section -->

<div class="bg-grey">
    <section id="hobbies" class="hobbies section-padding">
        <div class="container margins">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center pb-5">
                        <div class="about-next">
                            <h2 class="blue"><?= $hobbies["title"] ?></h2>
                            <p class="lead"><?= $hobbies["description"] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($hobbies_info as $hobbies_inf): ?>
                    <div class="col-12 col-md-6 col-lg-3 mt-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <img src="<?= $hobbies_inf["image"] ?>" alt="" class="img-fluid">
                                <h3 class="card-title py-2 blue"><?= $hobbies_inf["title"] ?></h3>
                                <p class="lead"><?= $hobbies_inf["description"] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<!-- contact section -->

<section id="contactos" class="contact section-padding">
    <div class="container margins">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header text-center pb-5">
                    <div class="about-next">
                        <h2 class="blue">Contact Me</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-md-12 p-0 pt-4 pb-4">
                <form action="index.php" method="post" class="p-4.m-auto">
                    <div class="row">
                        <div class="cold-md-12">
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control" required placeholder="Your Full Name"/>
                            </div>
                        </div>
                        <div class="cold-md-12">
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" required placeholder="Your Email Here">
                            </div>
                            <div class="cold-md-12">
                                <div class="mb-3">
                                            <textarea rows="3" required class="form-control"
                                                      placeholder="Your Query Here" name="message"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="btn bg-blue btn-lg btn-block mt-3 text-white">Send Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- footer -->

<footer class="bg-blue p-4 text-center">
    <div class="container">
        <div class="displayFlex justify-content-center">
            <p class="text-white p-2 lead">All Right Reserved</p>

            <?php foreach ($footer as $foo): ?>
                <a class="px-2 iconSize" href="<?= $foo["link"] ?>" target="_blank">
                    <img src="<?= $foo["image"] ?>" alt="" class="img-fluid">
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</footer>
</body>
</html>