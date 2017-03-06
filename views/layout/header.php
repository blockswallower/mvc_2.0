<!DOCTYPE html>
    <html lang="nl">
    <head>
        <title>website</title>
        <?php Link::google_font('https://fonts.googleapis.com/css?family=Pacifico"'); ?>
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

            body {
                background-color: whitesmoke;
            }
        </style>
        <?php Link::script('/jquery/JQuery.js')?>
        <?php Link::script('/snail/Snail.js')?>
        <?php Link::script('/script.js')?>
    </head>
    <body>
        <div id="error-handler"></div>


