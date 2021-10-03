<?php
/*----------------------------------------------------------------------------\

    FILE        : usersSession.php
    AIM         : Include le funzioni per il controllo degli accessi per i vari
                  utenti.
    NOTE        : File da includere all'inizio delle view che devono discrimi-
                  nare le proprie azioni in base ai privilegi associati all'u-
                  tente di sessione.
\----------------------------------------------------------------------------*/

// Verifica che l'utente di id = user_id sia connesso.

function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

function userID()
{
    if (isset($_SESSION['user_id'])) {
        return intval($_SESSION['user_id']);
    } else {
        return -1;
    }
}

/*-----------------------------------------------------------------------------
-- Verifica che l'utente abbia il corretto livello di accesso.
-----------------------------------------------------------------------------*/

define("GRANTS", [
    1 => _("Monitoraggio"),
    2 => _("Installatore"),
    99 => _("Supervisore"),
    9999 => _("Amministratore")
]);

define("STATES", [
    1 => _("Attivo"),
    0 => _("Disattivato")
]);

function isAdmin()
{
    if (isset($_SESSION['user_level']) && $_SESSION['user_level'] == '9999') {
        return true;
    } else {
        return false;
    }
}

function isSupervisor()
{
    if (isset($_SESSION['user_level']) && $_SESSION['user_level'] == '99') {
        return true;
    } else {
        return false;
    }
}

function isInstallUser()
{
    if (isset($_SESSION['user_level']) && $_SESSION['user_level'] == '2') {
        return true;
    } else {
        return false;
    }
}

function isMonitoringUser()
{
    if (isset($_SESSION['user_level']) && $_SESSION['user_level'] == '1') {
        return true;
    } else {
        return false;
    }
}

//-----------------------------------------------------------------------------
