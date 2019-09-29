<?php
require("config.php");
require("uploaded.class.php");
new uploaded(@$_GET["url"],@$_GET["folder"]);
