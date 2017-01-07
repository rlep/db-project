<?php
namespace Model\Post;
use \Db;
use \PDOException;
/**
 * Post
 *
 * This file contains every db action regarding the posts
 */

/**
 * Get a post in db
 * @param id the id of the post in db
 * @return an object containing the attributes of the post or false if error
 * @warning the author attribute is a user object
 * @warning the date attribute is a DateTime object
 */
function get($id) {
    $db = \Db::dbc();
    $result = $db->query("SELECT * from Post WHERE Post.id=".$id."");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
        $post =  (object) array(
        "id" => $row["id"],
        "text" => $row["text"],
        "date" => new DateTime('2011-01-01T15:03:01'),
        "author" => $row["author"]
        );
        }
        return $post;
    }
}

/**
 * Get a post with its likes, responses, the hashtags used and the post it was the response of
 * @param id the id of the post in db
 * @return an object containing the attributes of the post or false if error
 * @warning the author attribute is a user object
 * @warning the date attribute is a DateTime object
 * @warning the likes attribute is an array of users objects
 * @warning the hashtags attribute is an of hashtags objects
 * @warning the responds_to attribute is either null (if the post is not a response) or a post object
 */
function get_with_joins($id) {
    return (object) array(
        "id" => 1337,
        "text" => "Ima writing a post !",
        "date" => new \DateTime('2011-01-01T15:03:01'),
        "author" => \Model\User\get(2),
        "likes" => [],
        "hashtags" => [],
        "responds_to" => null
    );
}
 
/**
 * Create a post in db
 * @param author_id the author user's id
 * @param text the message
 * @param mentioned_authors the array of ids of users who are mentioned in the post
 * @param response_to the id of the post which the creating post responds to
 * @return the id which was assigned to the created post, null if anything got wrong
 * @warning this function computes the date
 * @warning this function adds the mentions (after checking the users' existence)
 * @warning this function adds the hashtags
 * @warning this function takes care to rollback if one of the queries comes to fail.
 */
function create($author_id, $text, $response_to=null) {
    return 1337;
}

/**
 * Get the list of used hashtags in message
 * @param text the message
 * @return an array of hashtags
 */
function extract_hashtags($text) {
    return array_filter(
        explode($text, " "),
        function($c) {
            return $c !== "" || $c[0] == "#";
        }
    );
}

/**
 * Get the list of mentioned users in message
 * @param text the message
 * @return an array of usernames
 */
function extract_mentions($text) {
    return array_filter(
        explode($text, " "),
        function($c) {
            return $c !== "" || $c[0] == "@";
        }
    );
}

/**
 * Mention a user in a post
 * @param pid the post id
 * @param uid the user id to mention
 * @return true if everything went ok, false else
 */
function mention_user($pid, $uid) {
    return false;
}

/**
 * Get mentioned user in post
 * @param pid the post id
 * @return the array of user objects mentioned
 */
function get_mentioned($pid) {
    return [];
}

/**
 * Delete a post in db
 * @param id the id of the post to delete
 * @return true if the post has been correctly deleted, false else
 */
function destroy($id) {
    return false;
}

/**
 * Search for posts
 * @param string the string to search in the text
 * @return an array of find objects
 */
function search($string) {
    return [get(1)];
}

/**
 * List posts
 * @param date_sorted the type of sorting on date (false if no sorting asked), "DESC" or "ASC" otherwise
 * @return an array of the objects of each post
 * @warning this function does not return the passwords
 */
function list_all($date_sorted=false) {
    return [get(1),get(1),get(1),get(1),get(1),get(1)];
}

/**
 * Get a user's posts
 * @param id the user's id
 * @param date_sorted the type of sorting on date (false if no sorting asked), "DESC" or "ASC" otherwise
 * @return the list of posts objects
 */
function list_user_posts($id, $date_sorted="DESC") {
    return [get(1)];
}

/**
 * Get a post's likes
 * @param pid the post's id
 * @return the users objects who liked the post
 */
function get_likes($pid) {
    return [\Model\User\get(2)];
}

/**
 * Get a post's responses
 * @param pid the post's id
 * @return the posts objects which are a response to the actual post
 */
function get_responses($pid) {
    return [get(2)];
}

/**
 * Get stats from a post (number of responses and number of likes
 */
function get_stats($pid) {
    return (object) array(
        "nb_likes" => 10,
        "nb_responses" => 40
    );
}

/**
 * Like a post
 * @param uid the user's id to like the post
 * @param pid the post's id to be liked
 * @return true if the post has been liked, false else
 */
function like($uid, $pid) {
    return false;
}

/**
 * Unlike a post
 * @param uid the user's id to unlike the post
 * @param pid the post's id to be unliked
 * @return true if the post has been unliked, false else
 */
function unlike($uid, $pid) {
    return false;
}

