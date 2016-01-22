<?php

include_once '../../config/config.php';
include_once $serverPath.'admin/login/requireAdmin.php';
include_once $serverPath.'utils/db_get.php';

echo json_encode(runQuery("SELECT id, username, email FROM ".getTableQuote('users')." WHERE username='".$_SESSION['user']['username']."';"));

?>
