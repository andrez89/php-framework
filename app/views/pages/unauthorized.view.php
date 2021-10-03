<!DOCTYPE html>
<html>

<head>
    <title><?= TITLE ?> | <?= _("Accesso non autorizzato") ?></title>

    <?php require(DIRECTORY . '/app/views/partials/head.php'); ?>

    <link rel="stylesheet" href="/<?= BASE_PATH ?>resources/css/app.css">
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
                ["", _("Accesso non autorizzato")]
            ];
            require(DIRECTORY . '/app/views/partials/subheader.php');
            ?>
            <div class="col-6 mb-12" style="margin: 0 auto; text-align: center">
                <h1><?= _('Non hai i permessi per accedere a questa pagina') ?></h1>
            </div>
        </section>
        <?php require(DIRECTORY . '/app/views/partials/footer.php'); ?>

    </main>
    <?php require(DIRECTORY . '/app/views/partials/footer.js.php'); ?>
</body>

</html>