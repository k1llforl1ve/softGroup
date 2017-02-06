<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="content-type" content="text/html"/>
    <base href="<?= SITE_URL?>">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL . 'assets/css/style.css' ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <?  setlocale(LC_ALL, 'uk_UA.UTF-8');?>
</head>
<body>

<? include $view; ?>
<script
    src="https://code.jquery.com/jquery-3.1.1.min.js"
    integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
    crossorigin="anonymous"></script>
<script src="<?php echo SITE_URL . 'assets/js/script.js' ?>"></script>
<script src="<?php echo SITE_URL . 'assets/js/stars.js' ?>"></script>
</body>
</html>