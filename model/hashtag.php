<?php
namespace Model\Hashtag;
use \Db;
use \PDOException;
/**
 * Hashtag model
 *
 * This file contains every db action regarding the hashtags
 */

/**
 * Attach a hashtag to a post
 * @param pid the post id to which attach the hashtag
 * @param hashtag_name the name of the hashtag to attach
 * @return true or false (if something went wrong)
 */
function attach($pid, $hashtag_name) {
    $db = \Db::dbc();
    $checkIfExist = $db->query("SELECT id From Hashtag where hashtag_text ='".$hashtag_name."'");
    if (!$checkIfExist->fetch()){
        $db->query("INSERT INTO Hashtag(hashtag_text) Values('".$hashtag_name."')"); 
        $hashtag_id = $db->lastInsertId();
    }
    else {
        $getHashtag = $db->query("SELECT id From Hashtag where hashtag_text ='".$hashtag_name."'");
        $hashtag_id = $getHashtag->fetch()["id"];
    }
    $result_hashtag_post = $db->query("INSERT INTO Hashtag_with_post (post_id,hashtag_id) Values('".$pid."','".$hashtag_id."')");
    if(!$result_hashtag_post){
        return false;
    }
    else {
        return true;
    }
}

/**
 * List hashtags
 * @return a list of hashtags names
 */
function list_hashtags() {
    $db = \Db::dbc();
    $hashtags = array();
    $result = $db->query("SELECT * FROM Hashtag");
    if(!$result){
        return array();
    }
    else {
        foreach ($result as $row ) {
            $hashtags[] =  $row["hashtag_text"];
        }
        return $hashtags;
    }
}

/**
 * List hashtags sorted per popularity (number of posts using each)
 * @param length number of hashtags to get at most
 * @return a list of hashtags
 */
function list_popular_hashtags($length) {
    $db = \Db::dbc();
    $hashtags = array();
    $result = $db->query("SELECT hashtag_text, count(hashtag_id) as nb FROM `Hashtag_with_post` inner join `Hashtag` on hashtag_id=id group by hashtag_id order by nb desc ");
    if(!$result){
        return array();
    }
    else {
        $cpt = 0;
        foreach ($result as $row ) {
            if ($length> $cpt){
                $hashtags[] =  $row["hashtag_text"];
                $cpt ++;
            }
        }
        return $hashtags;
    }
}

/**
 * Get posts for a hashtag
 * @param hashtag the hashtag name
 * @return a list of posts objects or null if the hashtag doesn't exist
 */
function get_posts($hashtag_name) {
    $db = \Db::dbc();
    $posts = array();
    $result = $db->query("SELECT post_id FROM `Hashtag` INNER JOIN Hashtag_with_post on id=hashtag_id where hashtag_text='".$hashtag_name."'" );
    if(!$result){
        return array();
    }
    else {
        foreach ($result as $row ) {
                $posts[]= \Model\Post\get($row["post_id"]);
        }
        return $posts;
    }
}

/** Get related hashtags
 * @param hashtag_name the hashtag name
 * @param length the size of the returned list at most
 * @return an array of hashtags names
 */
function get_related_hashtags($hashtag_name, $length) {
    $db = \Db::dbc();
    $hashtags = array();
    $result = $db->query("SELECT hashtag_text from Hashtag inner join Hashtag_with_post on Hashtag.id=hashtag_id inner join Post on Post.id=post_id where Post_id IN( SELECT post_id FROM                 Hashtag inner join Hashtag_with_post on Hashtag.id=hashtag_id inner join Post on Post.id=post_id where (hashtag_text='".$hashtag_name."'))");
    if(!$result){
        return array();
    }
    else {
        $cpt = 0;
        foreach ($result as $row ) {
            if ($length> $cpt && $row["hashtag_text"]!=$hashtag_name){
                $hashtags[] =  $row["hashtag_text"];
                $cpt ++;
            }
        }
        var_dump($hashtags);
        return $hashtags;
    }
}
