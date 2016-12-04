<?php
require '../lib/main.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Controller\Post\post($_POST, $_FILES);
}
elseif(isset($_GET['id'])) {
    Controller\Post\post_page($_GET['id']);
}
else {
    header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
}
require '../lib/closure.php';
