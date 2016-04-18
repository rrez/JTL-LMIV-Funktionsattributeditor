<?php

/**
 * Datei kopieren als database.php und eigene Einstellungen vornehmen.
 * Benötigt FreeDTS
 */

$server = 'SERVER';
$link = mssql_connect($server, 'USER', 'PASSWORD');
if (!$link) {
    die('Something went wrong while connecting to MSSQL');
}
mssql_select_db ('eazybusiness');
