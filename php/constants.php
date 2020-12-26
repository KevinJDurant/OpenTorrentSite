<?php
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config/config.ini.php');
    defined('FOOTER_TEXT') || define('FOOTER_TEXT', $config['footer']);
    defined('META_DESCRIPTION') || define('META_DESCRIPTION', $config['meta_description']);
    defined('SITE_NAME') || define('SITE_NAME', $config['name']);