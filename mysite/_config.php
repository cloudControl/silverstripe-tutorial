<?php

global $project;
$project = 'mysite';

$string = file_get_contents($_ENV['CRED_FILE'], false);
if ($string == false) {
    die('FATAL: Could not read credentials file');
}

# the file contains a JSON string, decode it and return an associative array
$creds = json_decode($string, true);

global $databaseConfig;
$databaseConfig = array(
    "type" => "MySQLDatabase",
    "server" => $creds['MYSQLS']['MYSQLS_HOSTNAME'],
    "username" => $creds['MYSQLS']['MYSQLS_USERNAME'],
    "password" => $creds['MYSQLS']['MYSQLS_PASSWORD'],
    "database" => $creds['MYSQLS']['MYSQLS_DATABASE'],
    "path" => ""
);

require_once('conf/ConfigureFromEnv.php');

Security::setDefaultAdmin('username', 'password');

MySQLDatabase::set_connection_charset('utf8');

// Set the current theme. More themes can be downloaded from
// http://www.silverstripe.org/themes/
SSViewer::set_theme('simple');

// Enable nested URLs for this site (e.g. page/sub-page/)
if(class_exists('SiteTree')) SiteTree::enable_nested_urls();
