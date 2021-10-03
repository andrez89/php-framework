<!DOCTYPE html>
<html>

<head>
    <title><?= TITLE ?> | <?= _("Accesso") ?></title>
    <?php require(DIRECTORY . '/app/views/partials/head.php'); ?>
</head>

<body>
    <main class="main">
        <div class="login">
            <!-- Login -->
            <div class="login__block <?php if (!isset($recover)) { ?>active<?php } ?>" id="l-login">
                <div class="login__block__header">
                    <?= _("Accedi") ?> - Rel. 1.1
                </div>
                <div class="login__block__body">
                    <form method="POST" action="/<?= BASE_PATH ?>">
                        <input type="hidden" name="url" value="<?= $url ?>">
                        <!-- Username -->
                        <div class="form-group">
                            <input type="text" id="username" name="email" class="form-control text-center btn-rounded" placeholder="<?= _("Utente") ?>">
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <input id="password" name="password" type="password" class="form-control text-center btn-rounded" placeholder="<?= _("Password") ?>">
                        </div>

                        <button name="submit" type="submit" class="btn btn-theme btn--sm btn-rounded"><?= _("Accedi") ?></button>

                        <div class="row"><br></div>
                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $error ?>
                            </div>
                        <?php } ?>
                        <?php if (isset($recoverOk)) { ?>
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <?= $recoverOk ?>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-forget-password" href=""><?= _("Password dimenticata?") ?></a>
                        </div>

                    </form>
                </div>

            </div>
            <!-- Forgot Password -->
            <div class="login__block <?php if (isset($recover)) { ?>active<?php } ?>" id="l-forget-password">
                <div class="login__block__header">
                    <?= _("Reset Password") ?>
                </div>

                <form class="login__block__body" method="POST" action="/<?= BASE_PATH ?>forget">
                    <p class="mb-5"><?= _("Inserisci il tuo indirizzo email per avviare la procedura di recupero password.") ?></p>

                    <div class="form-group">
                        <input type="text" name="email" class="form-control text-center" placeholder="<?= _("Indirizzo Email") ?>">
                    </div>

                    <button class="btn btn-theme btn--icon"><i class="zwicon-checkmark"></i></button>

                    <div class="row"><br></div>
                    <?php if (isset($recover)) { ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?= $recover ?>
                        </div>
                    <?php } ?>

                    <div class="row">
                        <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-login" href=""><?= _("Ho già un account?") ?></a>
                    </div>
                </form>
            </div>
        </div>

        <?php require(DIRECTORY . '/app/views/partials/footer.php'); ?>
    </main>
    <?php require(DIRECTORY . '/app/views/partials/footer.js.php'); ?>
</body>

</html>