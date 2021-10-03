<!DOCTYPE html>
<html>

<head>
    <title><?= TITLE ?> | <?= _("Pagina Non Trovata") ?></title>

    <?php require(DIRECTORY . '/app/views/partials/head.php'); ?>

    <link rel="stylesheet" href="/<?= BASE_PATH ?>resources/css/sentinel2000.css">
</head>

<body>
    <main class=" main">
        <?php
        require(DIRECTORY . '/app/views/partials/head.loader.php');
        require(DIRECTORY . '/app/views/partials/nav.php');
        require(DIRECTORY . '/app/views/partials/side.php');
        ?>

        <section class="content content--full">
            <?php
            $layers = [
                ["", _("Pagina non trovata")]
            ];
            require(DIRECTORY . '/app/views/partials/subheader.php');
            ?>
            <div class="col-6 mb-12" style="margin: 0 auto; text-align: center">
                <h1><?= _('Pagina non trovata') ?></h1>
            </div>
        </section>
        <?php require(DIRECTORY . '/app/views/partials/footer.php'); ?>

    </main>
    <?php require(DIRECTORY . '/app/views/partials/footer.js.php'); ?>
</body>

</html>