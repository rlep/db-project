<?php
namespace Model\Notification;
use \Db;
use \PDOException;
/**
 * Notification model
 *
 * This file contains every db action regarding the notifications
 */

/**
 * Get a liked notification in db
 * @param uid the id of the user in db
 * @return a list of objects for each like notification
 * @warning the post attribute is a post object
 * @warning the liked_by attribute is a user object
 * @warning the date attribute is a DateTime object
 * @warning the reading_date attribute is either a DateTime object or null (if it hasn't been read)
 */
function get_liked_notifications($uid) {
    $db = \Db::dbc();
    $notifications=array();
    $result = $db->query("SELECT * from Notification WHERE type='liked' and user_id!='".$uid."'");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
        $notifications[] =  (object) array(
        "type" => "liked",
        "post" => \Model\Post\get($row["post_id"]),
        "liked_by" => \Model\User\get($row["user_id"]),
        "date" => $row["notif_date"],
        "reading_date" => $row["reading_date"]
        );
        }
        return $notifications;
    }
}

/**
 * Mark a like notification as read (with date of reading)
 * @param pid the post id that has been liked
 * @param uid the user id that has liked the post
 * @return true if everything went ok, false else
 */
function liked_notification_seen($pid, $uid) {
    $db = \Db::dbc();
    $result = $db->query("UPDATE Notification SET reading_date='".date('Y-m-d H:i:s')."' WHERE (type='liked' and post_id='".$pid."' and user_id='".$uid."')");
    if(!$result){
        return false;
    }
    else{
        return true;
    }
}

/**
 * Get a mentioned notification in db
 * @param uid the id of the user in db
 * @return a list of objects for each like notification
 * @warning the post attribute is a post object
 * @warning the mentioned_by attribute is a user object
 * @warning the reading_date object is either a DateTime object or null (if it hasn't been read)
 */
function get_mentioned_notifications($uid) {
    $db = \Db::dbc();
    $notifications=array();
    $result = $db->query("SELECT * from Notification WHERE type='mentioned'");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
        $post = \Model\Post\get($row["post_id"]);
        $author = $post->author;    
        $notifications[] =  (object) array(
        "type" => "mentioned",
        "post" => $post,
        "mentioned_by" => $author,
        "date" => $row["notif_date"],
        "reading_date" => $row["reading_date"]
        );
        }
        return $notifications;
    }
}

/**
 * Mark a mentioned notification as read (with date of reading)
 * @param uid the user that has been mentioned
 * @param pid the post where the user was mentioned
 * @return true if everything went ok, false else
 */
function mentioned_notification_seen($uid, $pid) {
    $db = \Db::dbc();
    $result = $db->query("UPDATE Notification SET reading_date='".date('Y-m-d H:i:s')."' WHERE (type='mentioned' and post_id='".$pid."' and user_id='".$uid."')");
    if(!$result){
        return false;
    }
    else{
        return true;
    }
}

/**
 * Get a followed notification in db
 * @param uid the id of the user in db
 * @return a list of objects for each like notification
 * @warning the user attribute is a user object which corresponds to the user following.
 * @warning the reading_date object is either a DateTime object or null (if it hasn't been read)
 */
function get_followed_notifications($uid) {
    $db = \Db::dbc();
    $notifications=array();
    $result = $db->query("SELECT * from Notification WHERE type='followed'");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
        $notifications[] =  (object) array(
        "type" => "followed",
        "post" => \Model\Post\get($row["post_id"]),
        "followed_by" => \Model\User\get($row["user_id"]),
        "date" => $row["notif_date"],
        "reading_date" => $row["reading_date"]
        );
        }
        return $notifications;
    }
}

/**
 * Mark a followed notification as read (with date of reading)
 * @param followed_id the user id which has been followed
 * @param follower_id the user id that is following
 * @return true if everything went ok, false else
 */
function followed_notification_seen($followed_id, $follower_id) {
    $db = \Db::dbc();
    $result = $db->query("UPDATE Notification SET reading_date='".date('Y-m-d H:i:s')."' WHERE (type='followed' and post_id='".$pid."' and user_id='".$uid."')");
    if(!$result){
        return false;
    }
    else{
        return true;
    }}

/**
 * Get all the notifications sorted by time (descending order)
 * @param uid the user id
 * @return a sorted list of every notifications objects
 */
function list_all_notifications($uid) {
    $ary = array_merge(get_liked_notifications($uid), get_followed_notifications($uid), get_mentioned_notifications($uid));
    usort(
        $ary,
        function($a, $b) {
            return $b->date->format('U') - $a->date->format('U');
        }
    );
    return $ary;
}

/**
 * Mark a notification as read (with date of reading)
 * @param uid the user to whom modify the notifications
 * @param notification the notification object to mark as seen
 * @return true if everything went ok, false else
 */
function notification_seen($uid, $notification) {
    switch($notification->type) {
        case "liked":
            return liked_notification_seen($notification->post->id, $notification->liked_by->id);
        break;
        case "mentioned":
            return mentioned_notification_seen($uid, $notification->post->id);
        break;
        case "followed":
            return followed_notification_seen($uid, $notification->user->id);
        break;
    }
    return false;
}

