<?php
namespace Controller\Main;
function main() {
    $posts = \Model\Post\list_all("DESC");
    $popular_h = \Model\Hashtag\list_popular_hashtags(10);
    require "../view/timeline.php";
}
