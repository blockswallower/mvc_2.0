<?php use Snail\App\Config\SNAIL, Snail\App\Utils\Link; ?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <title>website</title>
    <?php Link::google_font('https://fonts.googleapis.com/css?family=Pacifico"'); ?>
    <script src="./assets/ts/dist/bundle.js"></script>
    <style>
        .font {
            text-align: center;
            font-family: 'Pacifico', cursive;
        }
        #title {
            color: #1b6d85;
            font-size: 100px;
            text-align: center;
            font-family: 'Pacifico', cursive;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 id="title"><?= SNAIL::APP_NAME ?></h1>
        <h1 class="font"><?= SNAIL::APP_TAG ?></h1>
        <h1 class="font">V <?= SNAIL::APP_VERSION ?></h1>
    </div>
</body>
</html>