<?php
namespace Model\Hashtag;
/**
 * Hashtag model
 *
 * This file contains every db action regarding the hashtags
 */

/**
 * List hashtags
 * @return a list of hashtags names
 */
function list_hashtags() {
    return ["Test"];
}

/**
 * List hashtags sorted per popularity (number of posts using each)
 * @param length number of hashtags to get
 * @return a list of hashtags
 */
function list_popular_hashtags($length) {
    return ["Hallo"];
}

/**
 * Get posts for a hashtag
 * @param hashtag the hashtag's id
 * @return a list of posts objects or null if the hashtag doesn't exist
 */
function get_posts($hashtag_name) {
    return [\Model\Post\get(1)];
}

/** Get related hashtags
 * @param hashtag_name the hashtag name
 * @param length the size of the returned list
 * @return an array of hashtags names
 */
function get_related_hashtags($hashtag_name, $length) {
    return ["Hello"];
}

/**
 * Get or create a hashtag
 * @param name the name of the (possibly) new hashtag
 * @return the (possibly) new hashtag's id or null (if something went wrong)
 */
function get_or_create($hashtag_name) {
    return null;
}
