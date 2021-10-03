<div>
    <?php
    foreach (ACCEPT_LANG as $l => $val) {
    ?>
        <a href="?lang=<?= $l ?>">
            <img title="<?= LANGUAGES[$l][0] ?>" alt="<?= LANGUAGES[$l][0] ?>" src="/<?= BASE_PATH ?>resources/flags/<?= $l ?>.png">
        </a> &nbsp;
    <?php
    }
    ?>
</div>