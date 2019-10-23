<?php
    include_once "../php/libs/database.php";
    include_once "../php/libs/UserHelper.php";

    date_default_timezone_set('Europe/Brussels');

    $db = new Db();

    if (!isset($_SESSION)) {
        session_start();
    }

    $message = 'Account Status Changed: ' . UserHelper::translateUserStatus($_GET['status']);

    if (UserHelper::verifyAdministrator($db, $_SESSION['userid'], $_SESSION["key"])) {
        $query = "UPDATE users SET uploaderstatus = %d WHERE user_id = %d;";
        $result = $db->query(sprintf($query, intval($_GET['status']),intval($_GET['user_id'])));
    } else {
        $message = 'Insufficient privileges!';
    }

    header("Location: /en/view/preferences.php?msg=" . $message);
