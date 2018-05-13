<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8"/>
        <title><?= $title ?></title>
        <base href="http://localhost/projet_4/" />
        <link rel="stylesheet" href="public/css/blog.css"/>
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700|PT+Serif:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet">
        <?= $tinyMCE ?>

    </head>

    <body>
        <?php require('header.php'); ?>

        <div id="container">
            <section id="include">
                <?= $content ?>
            </section>

            <?php require('nav.php')?>
        </div>

        <?php require('footer.php'); ?>
    </body>

</html>
