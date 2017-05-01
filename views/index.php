<!DOCTYPE html>
<html lang="nl">
<head>
    <title>website</title>
    <?php \Snail\App\Utils\Link::google_font('https://fonts.googleapis.com/css?family=Pacifico"'); ?>
    <script src="./assets/ts/Snail.js"></script>
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
    <script>
        getJson();
    </script>
</head>
<body>
    <div class="container">
        <h1 id="title">Snail</h1>
        <h1 class="font">PHP Framework</h1>
        <h1 class="font">V <?= \Snail\App\Config\SNAIL::APP_VERSION ?></h1>
    </div>
</body>
</html>