<?php

function require_wildcard($w) {
    foreach (glob($w) as $filename)
    {
        require_once $filename;
    }
}

require "session.php";
require "db.php";

require_wildcard("../model/*.php");
require_wildcard("../controller/*.php");
require_wildcard("../view/partials/*.php");
