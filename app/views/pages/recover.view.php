<!DOCTYPE html>
<html>

<head>
    <title><?= TITLE ?> | <?= _("Recupero Password") ?></title>

    <?php require(DIRECTORY . '/app/views/partials/head.php'); ?>
</head>

<body>
    <main class=" main">
        <?php
        require(DIRECTORY . '/app/views/partials/head.loader.php');
        ?>

        <div class="login">
            <!-- Login Recovery -->
            <div class="login__block active" id="l-login">
                <div class="login__block__header">
                    <img src="/<?= BASE_PATH . 'resources/img/LogoSentinel.png' ?>" alt="Sentinel" style="width:100px; height:55px;">
                    <?= _("Crea nuova password") ?>
                </div>
                <?php if (isset($error)) { ?>
                    <h4 class="bg-danger"><?= $error ?></h4> <!-- eventuale popup -->
                <?php } ?>
                <div class="login__block__body">
                    <form method="POST">
                        <input type="hidden" name="token" value="{$token}">
                        <!-- Password -->
                        <div class="form-group">
                            <input id="password" name="password" type="password" class="form-control text-center btn-rounded" placeholder="<?= _("Nuova Password") ?>">
                        </div>
                        <div class="form-group">
                            <input id="password2" name="password2" type="password" class="form-control text-center btn-rounded" placeholder="<?= _("Conferma Password") ?>">
                        </div>

                        <button name="submit" type="submit" class="btn btn-theme btn--sm btn-rounded"><?= _("Invia") ?></i>
                    </form>
                </div>

            </div>
        </div>

        <?php require(DIRECTORY . '/app/views/partials/footer.php'); ?>
    </main>
    <?php require(DIRECTORY . '/app/views/partials/footer.js.php'); ?>
</body>

</html>