<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <title><?= $title ?></title>
        <?= $tinyMCE ?>
        <link href="../public/css/blog.css" rel="stylesheet">
    </head>

    <body>
        <?php require('header.php'); ?>

        <section id="include">
            <?= $content ?>
        </section>

        <?php require('footer.php'); ?>
    </body>

</html>
