<?php
require_once(__DIR__ . '/../initialize.php');
?>

<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hybelutleie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> 
    <link rel="stylesheet" href="<?php echo urlFor('assets/css/style.css'); ?>">
</head>

<body class="d-flex flex-column h-100">

    <!--header-->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="<?php echo urlFor('/index.php'); ?>">Hybelutleie AS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo urlFor('/index.php'); ?>">Se annonser</a>
                        </li>
                        <?php if ($session->is_logged_in()) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo urlFor('/pages/createAd.php'); ?>">Lag ny annonse</a>
                        </li>
                        <div class="">
                            <a class="btn btn-outline-primary btn-sm me-2" href="<?php echo urlFor('/pages/login.php'); ?>"><i class="fa-solid fa-user"></i>Min Profil</a>
                            <a class="btn btn-primary btn-sm" href="<?php echo urlFor('/pages/register.php'); ?>">Logg ut</a>
                        </div>
                        <?php } else { ?>
                        <div class="">
                            <a class="btn btn-outline-primary btn-sm me-2" href="<?php echo urlFor('/pages/login.php'); ?>">Logg inn</a>
                            <a class="btn btn-primary btn-sm" href="<?php echo urlFor('/pages/logout.php'); ?>">Registrer</a>
                        </div>
                    <?php }
                         ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>