<?php
namespace Controller\User;

function user_page($username) {
    $user = \Model\User\get_by_username($username);
    if(!$user) {
        \Session\set_error("The user you've been searching for doesn't exist.");
        header("Location: index.php");
        return;
    }
    $posts = \Model\Post\list_user_posts($user->id);
    if (\Session\is_authentificated()) {
        $editable = \Session\get_user()->id == $user->id;
        $followable = !$editable;
    }
    else {
        $editable = false;
        $followable = false;
    }
    require "../view/user.php";
}

function follow($username) {
    if(!\Session\is_authentificated()) {
        header("Location: index.php");
        return;
    }
    $user = \Session\get_user();
    $to_follow = \Model\User\get_by_username($username);
    if(!$to_follow) {
        \Session\set_error("The user you've been searching for doesn't exist.");
        header("Location: index.php");
        return;
    }
    if(\Mode\User\follow($user->id, $to_follow->id)) {
        \Session\set_success("You are following " . $to_follow->username . ".");
    }
    else {
        \Session\set_error("An error occured while trying to follow.".$to_follow->username);
        header("Location: user.php?username=".$to_follow->username);
    }
}

function profile() {
    if(!\Session\is_authentificated()) {
        header("Location: index.php");
        return;
    }

    $user = \Session\get_user();
    $posts = \Model\Post\list_user_posts($user->id);
    $stats = \Model\User\get_stats($user->id);
    $editable = true;
    $followable = false;
    require "../view/user.php";
}

function signup_page() {
    if(\Session\is_authentificated()) {
        header("Location: index.php");
        return;
    }

    require "../view/signup.php";
}

function signup($form, $files) {
    if(\Session\is_authentificated()) {
        header("Location: index.php");
        return;
    }

    extract($form);
    if(\Model\User\get_by_username($username)) {
        \Session\set_error("There was an error during profile update : the username you've chosen has already been taken.");
        header("Location: signup.php");
        return;
    }
    if(\Model\User\create($username, $name, $password, $email, $files["avatar"] !== '' ? $files["avatar"]["tmp_name"] : '')) {
        \Session\set_success("Your account has been created. You can log in !");
        header("Location: index.php");
    }
    else {
        Session\set_error("There was an error during signup.");
        header("Location: signup.php");
    }
        
}

function login($username, $password) {
    if(\Session\is_authentificated()) {
        header("Location: index.php");
        return;
    }

    $u = \Model\User\check_auth($username, $password);
    if($u) {
        \Session\set_session_infos($u->id, \Model\User\hash_password($password));
        header("Location: index.php");
    }
    else {
        \Session\set_error("Login failed.");
        header("Location: login.php");
    }
}

function login_page() {
    if(\Session\is_authentificated()) {
        header("Location: index.php");
        return;
    }

    require "../view/login.php";
}

function logout() {
    Session\destroy();
    header("Location: index.php");
}

function update_profile($form, $files) {
    if(!\Session\is_authentificated()) {
        header("Location: index.php");
        return;
    }

    extract($form);
    $u = \Session\get_user();
    if($username != $u->username && \Model\User\get_by_username($username)) {
        \Session\set_error("There was an error during profile update : the username you've chosen has already been taken.");
        header("Location: update_profile.php");
        return;
    }
    if ($password !== '') {
        if(\Model\User\change_password($u->id, $password)) {
            \Session\set_password(\Model\User\hash_password($password));
        }
        else {
            \Session\set_error("There was an error during profile update : password couldn't be changed.");
            header("Location: update_profile.php");
            return;
        }
    }
    if ($files['avatar'] !== '') {
        if(!\Model\User\change_avatar($u->id, $files['avatar']['tmp_name'])) {
            \Session\set_error("There was an error during profile update : avatar couldn't be changed.");
            header("Location: update_profile.php");
            return;
        }
    }
    if(\Model\User\modify($u->id, $username, $name, $email)) {
        \Session\set_success("Profile has been modified successfully");
    }
    else {
        \Session\set_error("There was an error during profile update.");
    }
    header("Location: update_profile.php");
}

function update_profile_page() {
    if(!\Session\is_authentificated()) {
        header("Location: index.php");
        return;
    }

    $user = \Session\get_user();
    require "../view/update_profile.php";
}

