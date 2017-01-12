<?php
namespace Model\User;
use \Db;
use \PDOException;
/**
 * User model
 *
 * This file contains every db action regarding the users
 */

/**
 * Get a user in db
 * @param id the id of the user in db
 * @return an object containing the attributes of the user or null if error or the user doesn't exist
 */
function get($id) {
    $db = \Db::dbc();
    $result = $db->query("SELECT * from User WHERE User.id=".$id."");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row ) {
            $user =  (object) array(
            "id" => $id,
            "username" => $row["username"],
            "name" => $row["name"],
            "password" => $row["password"],
            "email" => $row["email"],
            "avatar" => $row["avatar"] 
            );
            return $user;
        }
    }
}

/**
 * Create a user in db
 * @param username the user's username
 * @param name the user's name
 * @param password the user's password
 * @param email the user's email
 * @param avatar_path the temporary path to the user's avatar
 * @return the id which was assigned to the created user, null if an error occured
 * @warning this function doesn't check whether a user with a similar username exists
 * @warning this function hashes the password
 */
function create($username, $name, $password, $email, $avatar_path) {
    $db = \Db::dbc();
    $result = $db->query("INSERT INTO User (username,name,password,email,avatar) Values('".$username."','".$name."','".hash_password($password)."','".$email."','".$avatar_path."')");
    if(!$result){
        return null;
    }
    else {
        return $db->lastInsertId();
    }
}

/**
 * Modify a user in db
 * @param uid the user's id to modify
 * @param username the user's username
 * @param name the user's name
 * @param email the user's email
 * @return true if everything went fine, false else
 * @warning this function doesn't check whether a user with a similar username exists
 */
function modify($uid, $username, $name, $email) {
    $user = get($uid);
    if($user){
        $db = \Db::dbc();
        $result = $db->query("UPDATE User SET username='".$username."',name ='".$name."',email ='".$email."' WHERE id=".$uid."");
        if(!$result){
            return null;
        }
        else{
            return true;
        }
    }
    else {
        return false;
    }
}

/**
 * Modify a user in db
 * @param uid the user's id to modify
 * @param new_password the new password
 * @return true if everything went fine, false else
 * @warning this function hashes the password
 */
function change_password($uid, $new_password) {
    $user = get($uid);
    if($user){
        $db = \Db::dbc();
        $result = $db->query("UPDATE User SET password='".hash_password($new_password)."' WHERE id=".$uid."");
        return true;
    }
    else {
        return false;
    }
}

/**
 * Modify a user in db
 * @param uid the user's id to modify
 * @param avatar_path the temporary path to the user's avatar
 * @return true if everything went fine, false else
 */
function change_avatar($uid, $avatar_path) {
    $user = get($uid);
    if($user){
        $db = \Db::dbc();
        $result = $db->query("UPDATE User SET avatar='".$avatar_path."' WHERE id=".$uid."");
        return true;
    }
    else {
        return false;
    }
}

/**
 * Delete a user in db
 * @param id the id of the user to delete
 * @return true if the user has been correctly deleted, false else
 */
function destroy($id) {
    $db = \Db::dbc();
    $result = $db->query("DELETE FROM User where User.id=".$id."");
    if(!$result){
        return false;
    }
    else {
        return true;
    }
}

/**
 * Hash a user password
 * @param password the clear password to hash
 * @return the hashed password
 */
function hash_password($password) {
    return hash('sha512', $password);
}

/**
 * Search a user
 * @param string the string to search in the name or username
 * @return an array of find objects
 */
function search($string) {
    $db = \Db::dbc();
    $result = $db->query("SELECT * FROM User where User.name LIKE'%".$string."%' or User.username LIKE '%".$string."%'");
    $users = array();
    foreach ($result as $row) {
        $users[] = (Object) array(
        "id" => $row["id"],
        "username" => $row["username"],
        "name" => $row["name"],
        "password" => $row["password"],
        "email" => $row["email"],
        "avatar" => $row["avatar"] 
        );
    }
    return $users;
}

/**
 * List users
 * @return an array of the objects of every users
 */
function list_all() {
    $db = \Db::dbc();
    $result = $db->query("SELECT * FROM User");
    $users = array();
    foreach ($result as $row) {
        $users[] = (Object) array(
        "id" => $row["id"],
        "username" => $row["username"],
        "name" => $row["name"],
        "password" => $row["password"],
        "email" => $row["email"],
        "avatar" => $row["avatar"] 
        );
        }
    return $users;
}

/**
 * Get a user from its username
 * @param username the searched user's username
 * @return the user object or null if the user doesn't exist
 */
function get_by_username($username) {
    $db = \Db::dbc();
    $result = $db->query("SELECT * from User WHERE User.username='".$username."'");
    if(!$result){
        return null;
    }
    else{
        foreach ($result as $row) {
            $user = (object) array(
            "id" => $row["id"],
            "username" => $row["username"],
            "name" => $row["name"],
            "password" => $row["password"],
            "email" => $row["email"],
            "avatar" => $row["avatar"] 
            );    
            return $user;
        }
    }
}

/**
 * Get a user's followers
 * @param uid the user's id
 * @return a list of users objects
 */
function get_followers($uid) {
    $db = \Db::dbc();
    $result = $db->query("SELECT follower from Following WHERE Following.followed=".$uid."");
    if(!$result){
        return null;
    }
    else{
        $followers = array();
        foreach($result as $row){
            $followers[] = get($row["follower"]);
        }
        return $followers;
    }
}

/**
 * Get the users our user is following
 * @param uid the user's id
 * @return a list of users objects
 */
function get_followings($uid) {
    $db = \Db::dbc();
    $result = $db->query("SELECT followed from Following WHERE Following.follower=".$uid."");
    if(!$result){
        return null;
    }
    else{
        $followeds = array();
        foreach($result as $row){
            $followeds[]= get($row["followed"]);
        }
        return $followeds;
    }
}

/**
 * Get a user's stats
 * @param uid the user's id
 * @return an object which describes the stats
 */
function get_stats($uid) {
    return (object) array(
        "nb_posts" => 10,
        "nb_followers" => 50,
        "nb_following" => 66
    );
}

/**
 * Verify the user authentification
 * @param username the user's username
 * @param password the user's password
 * @return the user object or null if authentification failed
 * @warning this function must perform the password hashing   
 */
function check_auth($username, $password) {
    $db = \Db::dbc();
    $password_new = hash_password($password);
    $info = $db->prepare('SELECT * FROM User WHERE username = :username AND password = :password');
    $info->execute(array( ':username' => $username, ':password' => $password_new));
    $data=$info->fetch();
    return (object) (array(
                            "id" => $data["id"],
                            "username" => $username,
                            "name" =>  $data['name'],
                            "password" =>  $data['password'],
                            "email" =>  $data['email'],
                            "avatar" =>  $data['avatar'], 
    ));
}

/**
 * Verify the user authentification based on id
 * @param id the user's id
 * @param password the user's password (already hashed)
 * @return the user object or null if authentification failed
 */
function check_auth_id($id, $password) {
    $user = get($id);
    if (!$user){
        return null;
    }
    else{    
        if ($password==$user->password){
            return $user;
        }
        else {
            return null;
        }
    }   
}

/**
 * Follow another user
 * @param id the current user's id
 * @param id_to_follow the user's id to follow
 * @return true if the user has been followed, false else
 */
function follow($id, $id_to_follow) {
    $db = \Db::dbc();
    $result = $db->query("INSERT INTO Following (follower,followed) Values (".$id.",".$id_to_follow.")");
    if(!$result){
        return false;
    }
    else {
        return true;
    }
}

/**
 * Unfollow a user
 * @param id the current user's id
 * @param id_to_follow the user's id to unfollow
 * @return true if the user has been unfollowed, false else
 */
function unfollow($id, $id_to_unfollow) {
    $db = \Db::dbc();
    $result = $db->query("DELETE FROM Following WHERE Following.follower=".$id." and Following.followed=".$id_to_unfollow."");
    if(!$result){
        return false;
    }
    else {
        return true;
    }
}
