<!DOCTYPE html>
<html>

<head>
    <title><?= TITLE ?> | <?= _("Informazioni di Sistema") ?></title>

    <?php require(DIRECTORY . '/app/views/partials/head.php'); ?>
</head>

<body>
    <main class=" main">
        <?php
        require(DIRECTORY . '/app/views/partials/nav.php');
        require(DIRECTORY . '/app/views/partials/side.php');
        ?>

        <section class="content content--full">
            <?php
            $layers = [
                ["", _("Informazioni di Sistema")]
            ];
            require(DIRECTORY . '/app/views/partials/subheader.php');
            ?>
            <div class="col-6 mb-12" style="margin: 0 auto; text-align: center">
                <h1>Sentinel</h1>

                <p>Sentinel è un sistema di monitoraggio...</p>
                <?php if (isAdmin()) { ?>
                    <h2><?= _("Variabili di ambiente") ?></h2>
                    <p>
                        <b>Ambiente:</b> <?= CFG ?><br>
                        <b>BASE PATH:</b> <?= BASE_PATH ?><br>
                        <b>SITE_URL:</b> <?= SITE_URL ?><br>
                        <b>SERVER:</b> <?= SITE_URL ?><br>
                    </p>
                <?php } ?>
            </div>
        </section>
        <?php require(DIRECTORY . '/app/views/partials/footer.php'); ?>

    </main>
    <?php require(DIRECTORY . '/app/views/partials/footer.js.php'); ?>
</body>

</html>