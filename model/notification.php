<?php
namespace Model\Notification;
/**
 * Notification model
 *
 * This file contains every db action regarding the notifications
 */

/**
 * Get a like notification in db
 * @param uid the id of the user in db
 * @return a list of objects for each like notification
 * @warning the post attribute is a post object
 * @warning the liked_by attribute is a user object
 * @warning the date attribute is a DateTime object
 * @warning the reading_date attribute is either a DateTime object or null (if it hasn't been read)
 */
function get_like_notifications($uid) {
    return [(object) array(
        "type" => "liked",
        "post" => \Model\Post\get(1),
        "liked_by" => \Model\User\get(3),
        "date" => new \DateTime("NOW"),
        "reading_date" => new \DateTime("NOW")
    )];
}

/**
 * Mark a like notification as read (with date of reading)
 * @param pid the post id that has been liked
 * @param uid the user id that has liked the post
 * @return true if everything went ok, false else
 */
function like_notification_seen($pid, $uid) {
    return false;
}

/**
 * Get a mention notification in db
 * @param uid the id of the user in db
 * @return a list of objects for each like notification
 * @warning the post attribute is a post object
 * @warning the mentioned_by attribute is a user object
 * @warning the reading_date object is either a DateTime object or null (if it hasn't been read)
 */
function get_mention_notifications($uid) {
    return [(object) array(
        "type" => "mentioned",
        "post" => \Model\Post\get(1),
        "mentioned_by" => \Model\User\get(3),
        "date" => new \DateTime("NOW"),
        "reading_date" => new \DateTime("NOW")
    )];
}

/**
 * Mark a mention notification as read (with date of reading)
 * @param uid the user that has been mentioned
 * @param pid the post where the user was mentioned
 * @return true if everything went ok, false else
 */
function mention_notification_seen($uid, $pid) {
    return false;
}

/**
 * Get a following notification in db
 * @param uid the id of the user in db
 * @return a list of objects for each like notification
 * @warning the user attribute is a user object
 * @warning the reading_date object is either a DateTime object or null (if it hasn't been read)
 */
function get_following_notifications($uid) {
    return [(object) array(
        "type" => "followed",
        "user" => \Model\User\get(1),
        "date" => new \DateTime("NOW"),
        "reading_date" => new \DateTime("NOW")
    )];
}

/**
 * Mark a following notification as read (with date of reading)
 * @param followed_id the user id which has been followed
 * @param follower_id the user id that is following
 * @return true if everything went ok, false else
 */
function following_notification_seen($followed_id, $follower_id) {
    return false;
}

/**
 * Get all the notifications sorted by time (descending order)
 * @param uid the user id
 * @return a sorted list of every notifications objects
 */
function list_all_notifications($uid) {
    return usort(
        array_merge(get_like_notifications($uid), get_following_notifications($uid), get_mention_notifications($uid)),
        function($a, $b) {
            return $b->date->format('U') - $a->date->format('U');
        }
    );
}
