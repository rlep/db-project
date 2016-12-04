<?php
namespace Controller\Post;

function post_page($id) {
    $post = \Model\Post\get($id);
    if(!$post) {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        return;
    }
    require '../view/post.php';
}

function post($form) {
    $user = \Session\get_user();
    if(!$user) {
        header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden", true, 403);
        return;
    }
    extract($form);
    if($pid = \Model\Post\create($user->id, $text)) {
        \Session\set_success("Your twirp has been published.");
        header("Location: post.php?id=".$pid);
    }
    else {
        \Session\set_error("An error occured while trying to publish your twirp.");
        header("Location: index.php");
    }
}

function respond($id, $form) {
    $post = \Model\Post\get($id);
    if(!$post) {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        return;
    }
    $user = \Session\get_user();
    if(!$user) {
        header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden", true, 403);
        return;
    }
    extract($form);
    if(\Model\Post\create($user->id, $text, $id)) {
        \Session\set_success("Your response has been published.");
        header("Location: post.php?id=".$id);
    }
    else {
        \Session\set_error("An error occured while trying to publish your twirp.");
        header("Location: post.php?id=".$id);        
    }

}

function destroy($id) {
    $post = \Model\Post\get($id);
    if(!$post) {
        header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
        return;
    }
    $user = \Session\get_user();
    if(!$user || $user->id !== $id) {
        header($_SERVER["SERVER_PROTOCOL"]." 403 Forbidden", true, 403);
        return;
    }

}

function like() {

}

