<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=500, initial-scale=1">
        <title><?= $title ?></title>
        <base href="<?= $this->_url ?>/" />
        <link rel="stylesheet" href="public/css/blog.css"/>
        <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=PT+Serif:400" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet">
        <link href="public/font/css/fontawesome-all.css" rel="stylesheet">
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

        <script src="public/js/blog.js"></script>
    </body>
</html>
