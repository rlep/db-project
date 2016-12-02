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
 * Get posts for a hashtag
 * @param hashtag the hashtag's id
 * @return a list of posts objects
 */
function get_posts($hashtag) {
    return [];
}

/**
 * Get or create a hashtag
 * @param name the name of the (possibly) new hashtag
 * @return the (possibly) new hashtag's id or null (if something went wrong)
 */
function get_or_create($hashtag_name) {
    return null;
}
