<?php
namespace Model\Post;
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
    return (object) array(
        "id" => 1337,
        "post_content" => "Text",
        "date" => new \DateTime('2011-01-01T15:03:01'),
        "author" => \Model\User\get(2)
    );
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
        "post_content" => "Ima writing a post !",
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
 * @param name the user's name
 * @param mentioned_authors the array of ids of users who are mentioned in the post
 * @param response_to the id of the post which the creating post responds to
 * @return the id which was assigned to the created post
 * @warning this function computes the date
 * @warning this function extracts the mentioned users
 * @warning this function extracts the used hashtags
 */
function create($author_id, $text, $response_to=null) {
    return 1337;
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
 * Get a user's posts
 * @param id the user's id
 * @return the list of posts objects
 */
function list_user_posts($id) {
    return [get(1)];
}

/**
 * List posts
 * @param date_sorted the type of sorting on date (false if no sorting asked), "DESC" or "ASC" otherwise
 * @return an array of the objects of each post
 * @warning this function does not return the passwords
 */
function list_all($date_sorted=false) {
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
