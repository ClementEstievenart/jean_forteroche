<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8"/>
        <title><?= $title ?></title>
        <link rel="stylesheet" href="public/css/blog.css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700">
        <?= $tinyMCE ?>

    </head>

    <body>
        <?php require('header.php'); ?>

        <section id="include">
            <?= $content ?>
        </section>

        <?php require('footer.php'); ?>
    </body>

</html>
