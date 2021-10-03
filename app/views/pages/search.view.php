<!DOCTYPE html>
<html>

<head>
    <title><?= TITLE ?> | <?= _("Ricerca") ?></title>

    <?php require(DIRECTORY . '/app/views/partials/head.php'); ?>

    <link rel="stylesheet" href="/<?= BASE_PATH ?>resources/css/sentinel2000.css">
</head>

<body>
    <main class=" main">
        <?php
        require(DIRECTORY . '/app/views/partials/nav.php');
        require(DIRECTORY . '/app/views/partials/side.php');

        if ($q == "") {
            $mV = true; // map view ?
            $cE = !isMonitoringUser(); // customers enabled?
            $cV = false;
            $pV = false;
            $cnV = false;
            $iV = false;
        } else {
            $mV = false;
            if (!isMonitoringUser()) {
                $cE = true;
                $cV = sizeof($customers) > 0;
                $pV = !$cV && sizeof($plants) > 0;
                $cnV = !$cV && !$pV && sizeof($contacts) > 0;
                $iV = !$cV && !$pV && !$cnV && sizeof($instruments) > 0;
            } else {
                $cE = false;
                $cV = false;
                $pV = sizeof($plants) > 0;
                $cnV = !$pV && sizeof($contacts) > 0;
                $iV = !$pV && !$cnV && sizeof($instruments) > 0;
            }
        }
        $nR = !$mV && (!$cV && !$pV && !$cnV && !$iV);
        ?>

        <section class="content content--full">
            <?php
            $layers = [
                ["", _("Risultati della ricerca")]
            ];
            require(DIRECTORY . '/app/views/partials/subheader.php');
            ?>
            <div class="card results">
                <div class="results__header">
                    <form class="results__search" action="/<?= BASE_PATH ?>search">
                        <input name="q" type="text" placeholder="<?= _("Cerca di nuovo...") ?>" value="<?= $q ?>">
                    </form>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link text-teal <?= $mV ? "active show" : "" ?>" data-toggle="tab" href="#maps" role="tab"><?= _("Mappa") . " [" . sizeof($map_plants) ?>]</a>
                        </li>
                        <?php if ($cE) { ?>
                            <li class="nav-item">
                                <a class="nav-link text-teal <?= $cV ? "active show" : "" ?>" data-toggle="tab" href="#customers" role="tab"><?= _("Clienti") . " [" . sizeof($customers) ?>]</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link text-teal <?= $pV ? "active show" : "" ?>" data-toggle="tab" href="#plants" role="tab"><?= _("Scenari") . " [" . sizeof($plants) ?>]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-teal <?= $cnV ? "active show" : "" ?>" data-toggle="tab" href="#contacts" role="tab"><?= _("Contatti") . " [" . sizeof($contacts) ?>]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-teal <?= $iV ? "active show" : "" ?>" data-toggle="tab" href="#instruments" role="tab"><?= _("Strumenti in Uso") . " [" . sizeof($instruments) ?>]</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="maps" class="tab-pane fade <?= $mV ? "active show" : "" ?>" role="tabpanel">
                        <div class="col-12">
                            <?php
                            $lat = str_replace(',', '.', 45.4642035);
                            $lng = str_replace(',', '.', 9.189982);
                            $markers = $map_plants;
                            $function = "";
                            $link_m = "/" . BASE_PATH . (isMonitoringUser() ? "monitor/plants/view?id=" :  "anag/plants/edit?id=");
                            require(DIRECTORY . '/app/views/sections/map.markers.section.php');
                            ?>
                        </div>
                    </div>
                    <?php if ($cE) { ?>
                        <div id="customers" class="tab-pane fade <?= $cV ? "active show" : "" ?>" role="tabpanel">
                            <div class="col-12">
                                <table id="customers-table" class="table table-hover table-bordered table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-center"><?= _("Descrizione") ?></th>
                                            <th class="text-center"><?= _("Indirizzi") ?></th>
                                            <th class="text-center"><?= _("Contatti") ?></th>
                                            <th class="text-center"><?= _("Scenari") ?></th>
                                            <th class="text-center"><?= _("Strumenti") ?></th>
                                            <th class="text-center"><?= _("Data Creazione") ?></th>
                                            <th class="text-center"><?= _("Stato") ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($customers as $customer) : ?>
                                            <tr>
                                                <td class="text-center">
                                                    <a href="/<?= BASE_PATH ?>anag/customers/edit?id=<?= $customer["customer_id"]; ?>">
                                                        <?= _("Modifica") ?></a>
                                                </td>
                                                <td class="text-center"><?= $customer["customer_desc"]; ?></td>
                                                <td class="text-center"><?= $customer["addresses"]; ?></td>
                                                <td class="text-center"><?= $customer["contacts"]; ?></td>
                                                <td class="text-center"><?= $customer["plants"]; ?></td>
                                                <td class="text-center"><?= $customer["instruments"]; ?></td>
                                                <td class="text-center"><?= $customer["customer_created"]; ?></td>
                                                <td class="text-center"><?= STATES[$customer["customer_active"]]; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>

                    <div id="plants" class="tab-pane fade <?= $pV ? "active show" : "" ?>" role="tabpanel">
                        <div class="col-12">
                            <table id="plants-table" class="table table-hover table-bordered table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center"></th>
                                        <?php if (!isMonitoringUser()) { ?>
                                            <th><?= _("Cliente") ?></th>
                                        <?php } ?>
                                        <th class="text-center"><?= _("Tipologia Applicazione") ?></th>
                                        <th class="text-center"><?= _("Ramo Applicativo") ?></th>
                                        <th class="text-center"><?= _("Settore Applicativo") ?></th>
                                        <th class="text-center"><?= _("Città") ?></th>
                                        <th class="text-center"><?= _("Strumenti") ?></th>
                                        <th class="text-center"><?= _("Data Creazione") ?></th>
                                        <th class="text-center"><?= _("Stato") ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($plants as $plant) : ?>
                                        <tr>
                                            <?php if (!isMonitoringUser()) { ?>
                                                <td class="text-center">
                                                    <a href="/<?= BASE_PATH ?>anag/plants/edit?id=<?= $plant["plant_id"]; ?>">
                                                        <?= _("Modifica") ?></a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="/<?= BASE_PATH ?>anag/customers/edit?sec=log&id=<?= $plant["plant_customer"]; ?>">
                                                        <?= $plant["customer_desc"]; ?>
                                                    </a>
                                                </td>
                                            <?php } else { ?>
                                                <td>
                                                    <a href="/<?= BASE_PATH ?>monitor/plants/view?id=<?= $plant["plant_id"]; ?>">
                                                        <?= _("Visualizza") ?></a>
                                                </td>
                                            <?php } ?>
                                            <td class="text-center"><?= $plant["plant_tipology"]; ?></td>
                                            <td class="text-center"><?= $plant["plant_application"]; ?></td>
                                            <td class="text-center"><?= $plant["plant_area"]; ?></td>
                                            <td class="text-center"><?= isset($plant["address_town"]) ? $plant["address_town"] : ""; ?></td>
                                            <td class="text-center"><?= $plant["instruments"]; ?></td>
                                            <td class="text-center"><?= $plant["plant_created"]; ?></td>
                                            <td class="text-center"><?= STATES[$plant["plant_active"]]; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="contacts" class="tab-pane fade <?= $cnV ? "active show" : "" ?>" role="tabpanel">
                        <div class="col-12">
                            <table id="contacts-table" class="table table-hover table-bordered table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th class="text-center"><?= _("Cliente") ?></th>
                                        <th class="text-center"><?= _("Descrizione") ?></th>
                                        <th class="text-center"><?= _("Nome") ?></th>
                                        <th class="text-center"><?= _("Cognome") ?></th>
                                        <th class="text-center"><?= _("Email") ?></th>
                                        <th class="text-center"><?= _("Cellulare") ?></th>
                                        <th class="text-center"><?= _("Priorità") ?></th>
                                        <th class="text-center"><?= _("Segnalazioni") ?></th>
                                        <th class="text-center"><?= _("Stato") ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($contacts as $contact) : ?>
                                        <tr>
                                            <td class="text-center">
                                                <a href="/<?= BASE_PATH ?>anag/contacts/edit?id=<?= $contact["contact_id"]; ?>">
                                                    <?= _("Modifica") ?></a>
                                            </td>
                                            <td class="text-center"><a href="/<?= BASE_PATH ?>anag/customers/edit?sec=con&id=<?= $contact["contact_customer"]; ?>">
                                                    <?= $contact["customer_desc"]; ?></a></td>
                                            <td class="text-center"><?= $contact["contact_desc"]; ?></td>
                                            <td class="text-center"><?= $contact["contact_name"]; ?></td>
                                            <td class="text-center"><?= $contact["contact_surname"]; ?></td>
                                            <td class="text-center"><?= $contact["contact_email"]; ?></td>
                                            <td class="text-center" <?= $contact["contact_cell_nb"]; ?></td>
                                            <td class="text-center"><?= $contact["priority_desc"]; ?></td>
                                            <td class="text-center"><?= $contact["contact_mail"] || $contact["contact_sms"]
                                                                        ? ($contact["contact_mail"] ? "Mail " : "") . ($contact["contact_sms"] ? "SMS" : "")
                                                                        : _("Nessun messaggio"); ?></td>
                                            <td class="text-center"><?= STATES[$contact["contact_active"]]; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="instruments" class="tab-pane fade <?= $iV ? "active show" : "" ?>" role="tabpanel">
                        <div class="col-12">
                            <table id="instrument-table" class="table table-hover table-bordered table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center"><?= _("Monitoring") ?></th>
                                        <th class="text-center"><?= _("Modifica") ?></th>
                                        <th class="text-center"><?= _("Descrizione") ?></th>
                                        <th class="text-center"><?= _("Applicazione") ?></th>
                                        <th class="text-center"><?= _("Strumento") ?></th>
                                        <th class="text-center"><?= _("Data Creazione") ?></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $idSapp = "";
                                    $descSapp = "";
                                    foreach ($instruments as $app) : ?>
                                        <tr>
                                            <td class="text-center">
                                                <a href="/<?= BASE_PATH ?>monitor/plants/?id=<?= $app["plant_id"] ?>&sapp=<?= $app["sa_id"] ?>">
                                                    <?= _("Dati") ?></a>
                                            </td>
                                            <?php if (!isMonitoringUser()) { ?>
                                                <td class="text-center">
                                                    <a href="/<?= BASE_PATH ?>anag/installManager/edit?id=<?= $app["sa_id"] ?>">
                                                        <?= _("Modifica") ?></a>
                                                </td>
                                                </td><?php } ?>
                                            <td class="text-center"><?= $app["sa_description"]; ?></td>
                                            <td class="text-center"><?= $app["app_desc"]; ?></td>
                                            <td class="text-center"><?= $app["strmnt_desc"]; ?></td>
                                            <td class="text-center"><?= $app["inserted"]; ?></td>
                                            <?php
                                            if ($descSapp == "" || (isset($_GET["sapp"]) && $_GET["sapp"] == $app["sa_id"])) {
                                                $idSapp = $app["sa_id"];
                                                $descSapp = $app["sa_description"];
                                            }
                                            ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="no-results" class="tab-pane fade <?= $nR ? "active show" : "" ?>" role="tabpanel">
                        <div class="col-12">
                            <h3><?= _("Nessun risultato trovato!") ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <?php require(DIRECTORY . '/app/views/partials/footer.php'); ?>
        </section>

    </main>
    <?php require(DIRECTORY . '/app/views/partials/footer.js.php'); ?>

    <script src="/<?= BASE_PATH ?>resources/js/tableController/tables.js"></script>
</body>

</html>