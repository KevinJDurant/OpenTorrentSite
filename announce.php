<?php
/*
* Bitstorm - A small and fast Bittorrent tracker
* Copyright 2008 Peter Caprioli & Simon Sessingø
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/*************************
 ** Configuration start **
 *************************/

/*
 * Enable debugging?
 * This allows anyone to see the entire peer database by appending ?debug to the announce URL.
 * It will also create debugging file used to report php errors.
 */
define('__DEBUGGING_ENABLED', true);

/**
 * Version
 */
define('__VERSION', 1.5);

/**
 * How often should clients pull server for new clients? (Seconds)
 */
define('__INTERVAL', 1800);

/**
 * What's the minimum interval a client may pull the server? (Seconds)
 * Some bittorrent clients does not obey this
 */
define('__INTERVAL_MIN', 300);

/**
 * How long should we wait for a client to re-announce after the last announce expires? (Seconds)
 */
define('__CLIENT_TIMEOUT', 60);

/**
 * Skip sending the peer id if client does not want it?
 * Hint: Should be set to true
 */
define('__NO_PEER_ID', true);

/**
 * Should seeders not see each others?
 * Hint: Should be set to true
 */
define('__NO_SEED_P2P', true);

/**
 * Where should we save the peer database
 * On Linux, you should use /dev/shm as it is very fast.
 * On Windows, you will need to change this value to some other valid path such as C:/Peers.txt
 */
define('__LOCATION_PEERS', 'peers.txt');

/**
 * Should we enable short announces?
 * This allows NATed clients to get updates much faster, but it also
 * takes more load on the server. (This is just an experimental feature which may be turned off)
 */
define('__ENABLE_SHORT_ANNOUNCE', false);

/**
 * In case someone tries to access the tracker using a browser, redirect to this URL or file
 */
define('__REDIR_BROWSER', '');

define('__LOG_FILE', __DIR__ . 'error.log');

/***********************
 ** Configuration end **
 ***********************/

if(__DEBUGGING_ENABLED === true) {

    set_error_handler(function ($errno, $errstr, $errfile, $errline) {

        if (file_exists(__LOG_FILE) === false) {
            $handle = fopen(__LOG_FILE, 'w+b');
            fclose($handle);
        }

        file_put_contents(__LOG_FILE, sprintf('Line: %s - Error: %s', $errline, $errstr));

    }, E_ALL);

}

//Send response as text
header('Content-type: Text/Plain');
header('X-Tracker-Version: Bitstorm ' . __VERSION); //Please give me some credit

/**
 * If you *really* dont want to, comment this line out.
 * Bencoding function, returns a bencoded dictionary.
 * You may go ahead and enter custom keys in the dictionary in this function if you'd like.
 */

function track($list, $interval = 60, $min_ival = 0)
{
    if (is_string($list)) { //Did we get a string? Return an error to the client
        return 'd14:failure reason' . strlen($list) . ':' . $list . 'e';
    }

    $p = ''; //Peer directory
    $c = $i = 0; //Complete and Incomplete clients

    foreach ($list as $d) { //Runs for each client
        if ($d[7]) { //Are we seeding?
            $c++; //Seeding, add to complete list
            if (__NO_SEED_P2P && is_seed()) { //Seeds should not see each others
                continue;
            }
        } else {
            $i++; //Not seeding, add to incomplete list
        }

        //Do some bencoding
        $pid = '';

        if (isset($_GET['no_peer_id']) === false && __NO_PEER_ID) { //Shall we include the peer id
            $pid = '7:peer id' . strlen($d[1]) . ':' . $d[1];
        }

        $p .= 'd2:ip' . strlen($d[0]) . ':' . $d[0] . $pid . '4:porti' . $d[2] . 'ee';
    }

    //Add some other paramters in the dictionary and merge with peer list
    $r = 'd8:intervali' . $interval . 'e12:min intervali' . $min_ival . 'e8:completei' . $c . 'e10:incompletei' . $i . 'e5:peersl' . $p . 'ee';

    return $r;
}

//Find out if we are seeding or not. Assume not if unknown.
function is_seed()
{
    return (isset($_GET['left']) && (int)$_GET['left'] === 0);
}

/*
* Yeah, this is the database engine. It's pretty bad, uses files to store peers.
* Should be easy to rewrite to use SQL instead.
*
* Yes, sometimes collisions may occur and screw the DB over. It might or might not
* recover by itself.
*/

//Save database to file
function db_save($data)
{
    $b = serialize($data);
    $handle = fopen(__LOCATION_PEERS, 'wb');

    if ($handle === false) {
        return false;
    }

    if (flock($handle, LOCK_EX) === false) {
        return false;
    }

    fwrite($handle, $b);
    fclose($handle);

    return true;
}

//Load database from file
function db_open()
{
    $p = '';
    $handle = fopen(__LOCATION_PEERS, 'rb');
    if ($handle === false) {
        return false;
    }

    if (flock($handle, LOCK_EX) === false) {
        return false;
    }

    while (feof($handle) === false) {
        $p .= fread($handle, 512);
    }

    fclose($handle);

    return ((string)$p !== '') ? unserialize($p) : true;
}

//Check if DB file exists, otherwise create it
function db_exists($createEmpty = false)
{
    if (file_exists(__LOCATION_PEERS) === true) {
        return true;
    }

    if ($createEmpty === true) {
        return db_save([]);
    }

    return false;
}

//Default announce time
$interval = __INTERVAL;

//Minimal announce time (does not apply to short announces)
$interval_min = __INTERVAL_MIN;

/*
* This is a pretty smart feature not present in other tracker software.
* If you expect to have many NATed clients, add short as a GET parameter,
* and clients will pull much more often.
*
* This can be done automatically, simply try to open a TCP connection to
* the client and assume it is NATed if not successful.
*/
if (isset($_GET['short']) && __ENABLE_SHORT_ANNOUNCE) {
    $interval = 120;
    $interval_min = 30;
}

//Did we get any parameters at all?
//Client is  probably a web browser, do a redirect
if (empty($_GET)) {
    header('Location: ' . __REDIR_BROWSER);
    die();
}

//Create database if it does not exist
db_exists(true) or die(track('Unable to create database'));
$d = db_open();

//Do we want to debug? (Should not be used by default)
if (isset($_GET['debug']) && __DEBUGGING_ENABLED) {
    echo 'Connected peers:' . count($d) . "\n\n";
    die();
}

//Did we get a failure from the database?
if ($d === false) {
    die(track('Database failure'));
}

//Do some input validation
function valdata($g, $must_be_20_chars = false)
{
    if (!isset($_GET[$g])) {
        die(track('Missing one or more arguments'));
    }
    if (!is_string($_GET[$g])) {
        die(track('Invalid types on one or more arguments'));
    }
    if ($must_be_20_chars && strlen($_GET[$g]) != 20) {
        die(track('Invalid length on ' . $g . ' argument'));
    }
    if (strlen($_GET[$g]) > 128) { //128 chars should really be enough
        die(track('Argument ' . $g . ' is too large to handle'));
    }
}

//Inputs that are needed, do not continue without these
valdata('peer_id', true);
valdata('port');
valdata('info_hash', true);

//Use the tracker key extension. Makes it much harder to steal a session.
if (!isset($_GET['key'])) {
    $_GET['key'] = '';
}
valdata('key');

//Do we have a valid client port?
if (!ctype_digit($_GET['port']) || $_GET['port'] < 1 || $_GET['port'] > 65535) {
    die(track('Invalid client port'));
}

//Array key, unique for each client and torrent
$sum = sha1($_GET['peer_id'] . $_GET['info_hash']);

//Make sure we've got a user agent to avoid errors
//Used for debugging
if (!isset($_SERVER['HTTP_USER_AGENT'])) {
    $_SERVER['HTTP_USER_AGENT'] = ''; //Must always be set
}

//When should we remove the client?
$expire = time() + $interval;

//Have this client registered itself before? Check that it uses the same key
if (isset($d[$sum])) {
    if ((string)$d[$sum][6] !== (string)$_GET['key']) {
        sleep(3); //Anti brute force
        die(track('Access denied, authentication failed'));
    }
}

//Add/update the client in our global list of clients, with some information
$d[$sum] = [$_SERVER['REMOTE_ADDR'], $_GET['peer_id'], $_GET['port'], $expire, $_GET['info_hash'], $_SERVER['HTTP_USER_AGENT'], $_GET['key'], is_seed()];

//No point in saving the user agent, unless we are debugging
if (!__DEBUGGING_ENABLED) {
    unset($d[$sum][5]);
} elseif (!empty($_GET)) { //We are debugging, add GET parameters to database
    $d[$sum]['get_parm'] = $_GET;
}

//Did the client stop the torrent?
//We dont care about other events
if (isset($_GET['event']) && (string)$_GET['event'] === 'stopped') {
    unset($d[$sum]);
    db_save($d);
    die(track([])); //The RFC says its OK to return whatever we want when the client stops downloading,
    //however, some clients will complain about the tracker not working, hence we return
    //an empty bencoded peer list
}

//Check if any client timed out
foreach ($d as $k => $data) {
    if (time() > $data[3] + __CLIENT_TIMEOUT) { //Give the client some extra time before timeout
        unset($d[$k]); //Client has gone away, remove it
    }
}

//Save the client list
db_save($d);

//Compare info_hash to the rest of our clients and remove anyone who does not have the correct torrent
foreach ($d as $id => $info) {
    if ((string)$info[4] !== (string)$_GET['info_hash']) {
        unset($d[$id]);
    }
}

// Remove self from list, no point in having ourselfes in the client dictionary
unset($d[$sum]);

// Add a few more seconds on the timeout to balance the load
$interval += mt_rand(0, 10);

// Bencode the dictionary and send it back
echo track($d, $interval, $interval_min);
exit(0);