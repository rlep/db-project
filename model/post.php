<?php
namespace Model\Post;
use \Db;
use \PDOException;
include 'user.php';
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
        foreach ($result as $row) {
            $result2 = $db->query("SELECT * from User WHERE User.id=".$row["author_id"]."");
            if(!$result2){
                return null;
            }
            else{
                foreach ($result2 as $row2 ) {
                    $user =  (object) array(
                    "id" => $id,
                    "username" => $row2["username"],
                    "name" => $row2["name"],
                    "password" => $row2["password"],
                    "email" => $row2["email"],
                    "avatar" => $row2["avatar"] 
                    );
                }
            }
            $post =  (object) array(
            "id" => $id,
            "text" => $row["post_text"],
            "date" => $row["post_date"],
            "author" => $user
            );
            return $post;
        }
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
    $db = \Db::dbc();
    $post= get($id);
    $likes = [];
    $hashtags = [];
    $responds_to = [];

    // get likes of a Post
    $result = $db->query("SELECT * FROM Liked WHERE post_id=".$id."");
    if(!$result){   
    }
    else{
        foreach ($result as $row ) {
            $result2 = $db->query("SELECT * from User WHERE User.id=".$row["user_id"]."");
            if(!$result2){
                return false;
            }
            else{
                foreach ($result2 as $row2 ) {
                    $likes[] =  (object) array(
                    "id" => $row2["id"],
                    "username" => $row2["username"],
                    "name" => $row2["name"],
                    "password" => $row2["password"],
                    "email" => $row2["email"],
                    "avatar" => $row2["avatar"] 
                    );
                }
            }
        }
    }

    // get hashtags of a Post
    $result2 = $db -> query("SELECT * FROM Hashtag_with_post WHERE post_id=".$id."");
    if(!$result2){
    }
    else{
        foreach ($result2 as $row2 ) {
            $resultHash = $db->query("SELECT * from Hashtag WHERE Hashtag.id=".$row2["hashtag_id"]."");
            if(!$resultHash){
                return false;
            }
            else{
                foreach ($resultHash as $hash ) {
                $hashtags[] = $hash["hashtag_text"];
                }
            }
        }
    }

    //get responds_to on the Post
    $result3 = $db -> query("SELECT * FROM Respond WHERE response_id =".$id."");
    if(!$result3){
    }
    else{
        foreach ($result3 as $row3 ) {
            $responds_to = get($row3["post_init_id"]);
        }
        
    }
    return (object) array(
        $post,
        "likes" => $likes,
        "hashtags" => $hashtags,
        "responds_to" => $responds_to
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
    $db = \Db::dbc();
    $date =  date('Y-m-d H:i:s');
    $result = $db->query("INSERT INTO Post(post_text,post_date,author_id) Values('".$text."','".$date."','".$author_id."')");
    if(!$result){
        return null;
    }
    else {
        // add hashtags
        $postid = $db->lastInsertId();
        $hashtags = extract_hashtags($text);
        if ($hashtags!=[]){
            foreach ($hashtags as $hashtag ) {
                \Model\Hashtag\attach($postid,$hashtag);
            }
        }

        // add mentions
        $mentions = extract_mentions($text);
        if ($mentions!=[]){
            foreach ($mentions as $username ) {
                $resultIdUser = $db->query("SELECT * FROM User where User.username='".$username."'");
                foreach ($resultIdUser as $iduser) {
                    mention_user($postid,$iduser["id"]);  
                }
            }
        }

        if ($response_to!=null){
            $result2 = $db->query("INSERT INTO Respond(response_id,post_init_id) Values('".$postid."','".$response_to."')");
            if(!$result2){
                return null;
            }
        }
        return $postid;
    }
}

/**
 * Get the list of used hashtags in message
 * @param text the message
 * @return an array of hashtags
 */
function extract_hashtags($text) {
    return array_map(
        function($el) { return substr($el, 1); },
        array_filter(
            explode(" ", $text),
            function($c) {
                return $c !== "" && $c[0] == "#";
            }
        )
    );
}
/**
 * Get the list of mentioned users in message
 * @param text the message
 * @return an array of usernames
 */
function extract_mentions($text) {
    return array_map(
        function($el) { return substr($el, 1); },
        array_filter(
            explode(" ", $text),
            function($c) {
                return $c !== "" && $c[0] == "@";
            }
        )
    );
}

/**
 * Mention a user in a post
 * @param pid the post id
 * @param uid the user id to mention
 * @return true if everything went ok, false else
 */
function mention_user($pid, $uid) {
    $db = \Db::dbc();
    $result = $db->query("INSERT INTO Mentionned (post_id,user_id) Values('".$pid."','".$uid."')");
    if(!$result){
        return false;
    }
    else {
        return true;
    }
}

/**
 * Get mentioned user in post
 * @param pid the post id
 * @return the array of user objects mentioned
 */
function get_mentioned($pid) {
    $db = \Db::dbc();
    $result = $db->query("SELECT * FROM Mentionned WHERE Mentionned.post_id=".$pid."");
    if(!$result){
        return [];
    }
    else{
        foreach ($result as $row ) {
            $result2 = $db->query("SELECT * from User WHERE User.id=".$row["user_id"]."");
            if(!$result2){
                return false;
            }
            else{
                foreach ($result2 as $row2 ) {
                    $mentioned[] =  (object) array(
                    "id" => $row["user_id"],
                    "username" => $row2["username"],
                    "name" => $row2["name"],
                    "password" => $row2["password"],
                    "email" => $row2["email"],
                    "avatar" => $row2["avatar"] 
                    );
                }
            }
        }
        return $mentioned;
    }
    
}

/**
 * Delete a post in db
 * @param id the id of the post to delete
 * @return true if the post has been correctly deleted, false else
 */
function destroy($id) { //check fk liked, mentionned
    $db = \Db::dbc();
    $result = $db->query("DELETE FROM Liked where Liked.post_id=".$id."");
    $result = $db->query("DELETE FROM Mentionned where Mentionned.post_id=".$id."");
    $result = $db->query("DELETE FROM Respond where Respond.post_init_id=".$id."");
    $result = $db->query("DELETE FROM Post where Post.id=".$id."");
    if(!$result){
        return false;
    }
    else {
        return true;
    }
}

/**
 * Search for posts
 * @param string the string to search in the text
 * @return an array of find objects
 */
function search($string) {
    $db = \Db::dbc();
    $post =array();
    $result = $db->query("SELECT * from Post WHERE Post.post_text LIKE '%".$string."%'");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
        $result2 = $db->query("SELECT * from User WHERE User.id=".$row["author_id"]."");
            if(!$result2){
                return null;
            }
            else{
                foreach ($result2 as $row2 ) {
                    $user =  (object) array(
                    "id" => $row2["id"],
                    "username" => $row2["username"],
                    "name" => $row2["name"],
                    "password" => $row2["password"],
                    "email" => $row2["email"],
                    "avatar" => $row2["avatar"] 
                    );
                }
            }
        $post[] =  (object) array(
        "id" => $row["id"],
        "post_text" => $row["post_text"],
        "post_date" => $row["post_date"],
        "author" => $user
        );
        }
        return $post;
    }
}

/**
 * List posts
 * @param date_sorted the type of sorting on date (false if no sorting asked), "DESC" or "ASC" otherwise
 * @return an array of the objects of each post
 * @warning this function does not return the passwords
 */
function list_all($date_sorted=false) {
    $db = \Db::dbc();
    $post = array();
    if ($date_sorted=="ASC"){
        $result = $db->query("SELECT * from Post ORDER BY Post.post_date ASC");
    }
    else {
        $result = $db->query("SELECT * from Post ORDER BY Post.post_date DESC");
    }
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
            $result2 = $db->query("SELECT * from User WHERE User.id=".$row["author_id"]."");
            if(!$result2){
                return null;
            }
            else{
                foreach ($result2 as $row2 ) {
                    $user =  (object) array(
                    "id" => $row2["id"],
                    "username" => $row2["username"],
                    "name" => $row2["name"],
                    "password" => $row2["password"],
                    "email" => $row2["email"],
                    "avatar" => $row2["avatar"] 
                    );
                }
            }
            $post[] =  (object) array(
            "id" => $row["id"],
            "post_text" => $row["post_text"],
            "post_date" => $row["post_date"],
            "author" => $user
            );
        }
        return $post;
    }
}

/**
 * Get a user's posts
 * @param id the user's id
 * @param date_sorted the type of sorting on date (false if no sorting asked), "DESC" or "ASC" otherwise
 * @return the list of posts objects
 */
function list_user_posts($id, $date_sorted="DESC") {
    $db = \Db::dbc();
    $result = $db->query("SELECT * from Post WHERE Post.author =".$id."");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
        $posts[] =  (object) array(
        "id" => $row["id"],
        "post_text" => $row["post_text"],
        "post_date" => $row["post_date"],
        "author" => $row["author"]
        );
        }
        return $posts;
    }
}

/**
 * Get a post's likes
 * @param pid the post's id
 * @return the users objects who liked the post
 */
function get_likes($pid) {
    $db = \Db::dbc();
    $result = $db->query("SELECT * from Liked WHERE Liked.post_id =".$pid."");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
        $liker[] =  (object) array(
            User.get(row["user_id"])
         );
        }
        return $liker;
    }
}

/**
 * Get a post's responses
 * @param pid the post's id
 * @return the posts objects which are a response to the actual post
 */
function get_responses($pid) {
    $db = \Db::dbc();
    $result = $db->query("SELECT * from Respond WHERE Respond.post_init_id =".$pid."");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
            $responses[] = get($row["response_id"]);
        }
        return $responses;
    }
}

/**
 * Get stats from a post (number of responses and number of likes
 */
function get_stats($pid) {
    // get responses
    $db = \Db::dbc();
    $result = $db->query("SELECT COUNT(*) as nb_rep from Respond WHERE Respond.post_init_id =".$pid."");
    if(!$result){
        $nb_responses = 0;
    }
    else{
        foreach ($result as $row ) {
            $nb_responses[] = $row["nb_rep"];
        }
    }

    // get likes
    $db = \Db::dbc();
    $result = $db->query("SELECT COUNT(*) as nb_like from Liked WHERE Liked.post_id =".$pid."");
    if(!$result){
        $nb_likes = 0;
    }
    else{
        foreach ($result as $row ) {
        $nb_likes = $row["nb_like"];
        }
    }

    return (object) array(
        "nb_likes" => $nb_likes,
        "nb_responses" => $nb_responses
    );
}

/**
 * Like a post
 * @param uid the user's id to like the post
 * @param pid the post's id to be liked
 * @return true if the post has been liked, false else
 */
function like($uid, $pid) {
    $db = \Db::dbc();
    $result = $db->query("INSERT INTO Liked (user_id,post_id) Values (".$uid.",".$pid.")");
    if(!$result){
        return false;
    }
    else {
        return true;
    }
}

/**
 * Unlike a post
 * @param uid the user's id to unlike the post
 * @param pid the post's id to be unliked
 * @return true if the post has been unliked, false else
 */
function unlike($uid, $pid) {
    $db = \Db::dbc();
    $result = $db->query("DELETE FROM Liked WHERE Liked.user_id=".$uid." and Liked.post_id=".$pid."");
    if(!$result){
        return false;
    }
    else{
        return true;
    }
}