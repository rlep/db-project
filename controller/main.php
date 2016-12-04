<?php
namespace Controller\Main;
function main() {
    $posts = \Model\Post\list_all("DESC");
    require "../view/timeline.php";
}
