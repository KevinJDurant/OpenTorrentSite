<?php

require_once '../php/libs/parser.php';
require_once '../php/libs/scraper.php';
require_once '../php/libs/database.php';

date_default_timezone_set('Europe/Brussels');

if (isset($_POST['magnet']) && !empty($_POST['magnet']) && isset($_POST['id']) && !empty($_POST['id']))
{
    $full = base64_decode($_POST['magnet']);
    $magnet = explode('&', $full);

    $trackers = [];

    if (count($magnet) > 0)
    {
        $hash = str_replace('magnet:?xt=urn:btih:','', $magnet[0]);

        unset($magnet[0]);

        foreach ($magnet as $key => $endpoint)
        {
            if (strpos($endpoint, 'dn=') !== false || strpos($endpoint, 'xl=') !== false)
            {
                unset($magnet[$key]);
            }
            else
            {
                $trackers[] = str_replace('tr=','', $endpoint);
            }
        }

        $scraper = new Scrapeer\Scraper();

        $info = $scraper->scrape( $hash, $trackers);

        if ($info)
        {
            $seeders = $info[$hash]['seeders'];
            $leechers = $info[$hash]['leechers'];

            $db = new Db();
            $result = $db->query('UPDATE torrents SET leechers = ' .  $db->escape($leechers) . ', seeders = ' . $db->escape($seeders) . ' WHERE userid = ' . $db->escape($_POST['id']) . ' AND hash = ' . $db->quote($hash));
        }
    }

    header('Content-Type: application/json');
    echo json_encode(['success' => $result,'seeders'=>$seeders,'leechers'=> $leechers]);
}

?>