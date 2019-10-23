<?php

class UserHelper
{
    /**
     * Verify that the logged in user is an administrator.
     *
     * @example UserHelper::verifyAdministrator($db, $_SESSION['userid'], $_SESSION["key"])
     *
     * @param $db
     * @param $user_id
     * @param $key
     * @return bool
     */
    public static function verifyAdministrator ($db, $user_id, $key) {
        $query = "SELECT count(user_id) as amount FROM users WHERE user_id=%d AND tempkey='%s' AND uploaderstatus = 99";
        $result = $db->select(sprintf($query, $user_id, $key));
        return $result[0]['amount'] === '1';
    }

    /**
     * Verify that the logged in user is the given role.
     *
     * @example UserHelper::verifyRole($db, $_SESSION['userid'], $_SESSION['key'], 99)
     *
     * @param $db
     * @param $user_id
     * @param $key
     * @param $roleNumber
     * @return bool
     */
    public static function verifyRole ($db, $user_id, $key, $roleNumber) {
        $query = "SELECT COUNT(user_id) as amount FROM users WHERE user_id=%d AND tempkey='%s' AND uploaderstatus = %d;";
        $result = $db->select(sprintf($query, $user_id, $key, $roleNumber));
        return $result[0]['amount'] === '1';
    }

    /**
     * Return Human readable user status string along with the database IDs.
     *
     * @example UserHelper::translateUserStatus(99);
     *
     * @param $uploaderstatus
     * @return string
     */
    public static function translateUserStatus ($uploaderstatus) {
        switch ($uploaderstatus) {
            case 99:
                return 'Administrator User (99)';
                break;
            case 3:
                return 'VIP User (3)';
                break;
            case 2:
                return 'Trusted User (2)';
                break;
            case -1:
                return 'Banned User (-1)';
                break;
            default:
                return 'Basic User (0)';
        }
    }

    /**
     * Returns the HTML string to display user icons.
     *
     * @example UserHelper::displayUserIcon(99);
     *
     * @param $status
     * @return string
     */
    public static function displayUserIcon ($status) {
        switch ($status) {
            case 99:
                return ' <img src="/css/vip.png" alt="Administrator User">';
                break;
            case 3:
                return ' <img src="/css/vip.png" alt="VIP User">';
                break;
            case 2:
                return ' <img src="/css/trusted.png" alt="Trusted User">';
                break;
            default:
                return '';
        }
    }
}