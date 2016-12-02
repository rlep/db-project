<?php
namespace Modules\User;
/**
 * User functions
 *
 * This file contains every action regarding the users
 */

/**
 * Get a user in db
 * @param id the id of the user in db
 * @return an object containing the attributes of the user or false if error
 * @warning this function must avoid showing the password
 */
function get($id) {
    return (object) array(
        "id" => 1337,
        "username" => "yrlgtm",
        "name" => "User 1",
        "email" => "yrlgtm@gmail.com",
        "avatar" => "" 
    );
}

/**
 * Create a user in db
 * @param username the user's username
 * @param name the user's name
 * @param password the user's password
 * @param email the user's email
 * @return the id which was assigned to the created user
 * @warning this function enciphers the password
 */
function create($username, $name, $password, $email, $avatar) {
    return 1337;
}

/**
 * Modify a user in db
 * @param username the user's username
 * @param name the user's name
 * @param password the user's password
 * @param email the user's email
 * @return true if everything went fine, false else
 * @warning this function enciphers the password
 */
function modify($username, $name, $email, $avatar) {
    return false;
}

/**
 * Modify

/**
 * Delete a user in db
 * @param id the id of the user to delete
 * @return true if the user has been correctly deleted, false else
 */
function destroy($id) {
    return false;
}

/**
 * Search a user
 * @param string the string to search in the name or username
 * @return an array of the objects of find objects
 */
function search($string) {
    return array((object) array(
        "id" => 1337,
        "username" => "yrlgtm",
        "name" => "User 1",
        "email" => "yrlgtm@gmail.com"
    ));
}

/**
 * Verify the user authentification
 * @param username
 * @param password
 * @return the user object or false if authentification failed
 * @warning this function enciphers the password
 */
function check_auth($username, $password) {
    return false;
}

/**
 * Follow another user
 * @param id the current user's id
 * @param id_to_follow the user's id to follow
 * @return true if the user has been followed, false else
 */
function follow($id, $id_to_follow) {
    return false;
}
