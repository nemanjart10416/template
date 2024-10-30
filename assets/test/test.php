<?php
$answer = "";
include_once("../php/functions.php");

?>
<!doctype html>
<html lang="sr">
<head>
    <!-- meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="Index, Follow">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="copyright" content="">
    <meta name="Audience" content="all">
    <meta name="distribution" content="global">
    <meta name="theme-color" content="#EBEBEB" >
    <meta name="language" content="sr">

    <link rel="preload" as="image" href="important.png">

    <link href="" rel="canonical">

    <link href="" rel="icon">
    <link href="" rel="apple-touch-icon">

    <title>Hello, world!</title>

    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container-fluid">

    <div class="row">
        <?php include_once("..//components/navbar.php"); ?>
    </div>

    <div class="row">
        <div class="col-12">
            <?php echo $answer; ?>
        </div>
    </div>

    <div class="row">
        <?php include_once("..//components/footer.php"); ?>
    </div>
</div>

<script src="../js/script.js" defer></script>
</body>
</html>