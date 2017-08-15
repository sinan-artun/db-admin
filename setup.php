<?php
if (isset($_POST['are_you']) && $_POST['are_you'] === 'ready') {
    header('Content-Type: application/json');
    $re = new stdClass();
    $re->status = 'success';
    echo json_encode($re);
    die;
}

if (isset($_POST['test']) && $_POST['test'] === 'php_version') {
    header('Content-Type: application/json');
    $re = new stdClass();
    $re->status = 'success';
    if (version_compare(phpversion(), '5.3.10', '<')) {
        $re->status = 'error';
    }

    echo json_encode($re);
    die;
}

if (isset($_POST['test']) && $_POST['test'] === 'mysqli') {
    header('Content-Type: application/json');
    $re = new stdClass();
    $re->status = 'success';
    if (!function_exists('mysqli_connect')) {
        $re->status = 'error';
    }

    echo json_encode($re);
    die;
}
if (isset($_POST['test']) && $_POST['test'] === 'short_open_tag') {
    header('Content-Type: application/json');
    $re = new stdClass();
    $re->status = 'success';

    if (abs(ini_get('short_open_tag')) !== 1) {
        $re->status = 'error';
    }

    echo json_encode($re);
    die;
}


if (isset($_POST['build_tables']) && !empty($_POST['build_tables'])) {
    header('Content-Type: application/json');
    $re = new stdClass();



    $con = new mysqli($_POST['db_url'], $_POST['db_user_name'], $_POST['db_pass'], $_POST['db_name']);

    if (mysqli_connect_errno()) {
        $re->status = 'error';
        $re->msg = "Failed to connect to MySQL: " . mysqli_connect_error();
        echo  json_encode($re);
        return;

    }





    $sql = 'DROP TABLE IF EXISTS `___apis`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'CREATE TABLE `___apis` ( `id` int(9) unsigned NOT NULL AUTO_INCREMENT, `key` varchar(255) NOT NULL, `api_type` varchar(30) DEFAULT NULL, `table_name` varchar(100) NOT NULL, `cols` text, `user_id` int(9) unsigned DEFAULT NULL, `date_added` int(10) unsigned DEFAULT NULL, `description` varchar(255) DEFAULT NULL, `active` tinyint(1) unsigned NOT NULL DEFAULT "1", `request_type` varchar(20) DEFAULT NULL, `respond_type` varchar(20) DEFAULT NULL, `sql` text, `where_active` tinyint(1) unsigned NOT NULL DEFAULT "0", `where_col` varchar(70) DEFAULT NULL, `where_operator` varchar(10) DEFAULT NULL, `where_value_type` varchar(20) DEFAULT NULL, `where_constant` varchar(255) DEFAULT NULL, `order_by_active` tinyint(1) unsigned NOT NULL DEFAULT "0", `order_by` varchar(70) DEFAULT NULL, `order_way` varchar(10) DEFAULT NULL, `limit_active` tinyint(1) unsigned DEFAULT NULL, `limit_offset` smallint(5) unsigned NOT NULL DEFAULT "0", `limit_count` smallint(5) unsigned NOT NULL DEFAULT "1", `run_for` tinyint(1) unsigned NOT NULL DEFAULT "0", `run_for_val` varchar(20) DEFAULT NULL, `run_for_dead_time` int(10) unsigned DEFAULT NULL, `url` text NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'DROP TABLE IF EXISTS `___ci_session`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'CREATE TABLE `___ci_session` ( `id` varchar(40) NOT NULL, `ip_address` varchar(39) NOT NULL, `timestamp` int(10) unsigned NOT NULL DEFAULT "0", `data` blob NOT NULL, `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`), KEY `ci_sessions_timestamp` (`timestamp`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }


    $sql = 'DROP TABLE IF EXISTS `___general_config`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'CREATE TABLE `___general_config` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `option_name` varchar(100) CHARACTER SET latin1 NOT NULL, `option_value` text NOT NULL, `option_category` varchar(50) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }
    $sql = 'DROP TABLE IF EXISTS `___groups`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'CREATE TABLE `___groups` ( `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT, `name` varchar(20) NOT NULL, `description` varchar(250) NOT NULL, `group_level` smallint(5) NOT NULL, `date_added` int(10) DEFAULT "0", `date_updated` int(10) DEFAULT "0", `group_active` tinyint(1) NOT NULL DEFAULT "1", `total_users` smallint(5) unsigned DEFAULT "0", `wm_opacity` tinyint(3) unsigned NOT NULL DEFAULT "50", PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'INSERT INTO `___groups` (`id`, `name`, `description`, `group_level`, `date_added`, `date_updated`, `group_active`, `total_users`, `wm_opacity`) VALUES (1,"Administrator","This group cannot be edited.",99,1426269333,1452505640,1,1,50), (2,"Users","this group for newly registered users and cannot be edited.",0,1452741695,1452741695,1,0,50);';
    if ($con->query($sql) !== TRUE) {$re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'DROP TABLE IF EXISTS `___inbox_messages`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'CREATE TABLE `___inbox_messages` ( `id` int(9) unsigned NOT NULL AUTO_INCREMENT, `subject` varchar(255) DEFAULT NULL, `message` text, `from` int(9) NOT NULL, `to` int(9) NOT NULL, `date_sent` int(10) NOT NULL, `date_read` int(10) unsigned NOT NULL DEFAULT "0", `deleted` int(1) NOT NULL, `from_username` varchar(100) NOT NULL, `to_username` varchar(100) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }
    $sql = 'DROP TABLE IF EXISTS `___sent_messages`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'CREATE TABLE `___sent_messages` ( `id` int(9) unsigned NOT NULL AUTO_INCREMENT, `subject` varchar(255) DEFAULT NULL, `message` text, `from` int(9) NOT NULL, `to` int(9) NOT NULL, `date_sent` int(10) NOT NULL, `date_read` int(10) unsigned NOT NULL DEFAULT "0", `from_username` varchar(100) NOT NULL, `to_username` varchar(100) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }
    $sql = 'DROP TABLE IF EXISTS `___todo`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'CREATE TABLE `___todo` ( `id` int(9) unsigned NOT NULL AUTO_INCREMENT, `todo` text, `dead_line` int(10) DEFAULT NULL, `done` tinyint(1) unsigned NOT NULL DEFAULT "0", `date_added` int(10) unsigned NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'DROP TABLE IF EXISTS `___users`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }
    $sql = 'CREATE TABLE `___users` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `ip_address` varchar(15) NOT NULL, `username` varchar(100) NOT NULL, `password` varchar(255) NOT NULL, `salt` varchar(255) DEFAULT NULL, `email` varchar(100) NOT NULL, `activation_code` varchar(40) DEFAULT NULL, `forgotten_password_code` varchar(40) DEFAULT NULL, `forgotten_password_time` int(11) unsigned DEFAULT NULL, `remember_code` varchar(40) DEFAULT NULL, `created_on` int(11) unsigned NOT NULL, `user_updated` int(10) DEFAULT "0", `last_login` int(11) unsigned DEFAULT NULL, `active` tinyint(1) DEFAULT NULL, `first_name` varchar(50) DEFAULT NULL, `last_name` varchar(50) DEFAULT NULL, `company` varchar(100) DEFAULT NULL, `phone` varchar(20) DEFAULT NULL, `email_valid` tinyint(1) NOT NULL DEFAULT "0", `force_pass_update` tinyint(1) NOT NULL DEFAULT "0", `note` text, `website` varchar(255) DEFAULT NULL, `profile_pic` varchar(255) DEFAULT NULL, `table_add_advanced` tinyint(1) unsigned NOT NULL DEFAULT "0", `language` varchar(20) DEFAULT "english", `user_level` tinyint(1) NOT NULL DEFAULT "2", `smtp_username` varchar(255) NOT NULL, `smtp_server` varchar(255) NOT NULL, `smtp_password` varchar(255) NOT NULL, `smtp_port` smallint(5) unsigned DEFAULT NULL, `signature` text, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }



    $sql = 'INSERT INTO `___users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `user_updated`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `email_valid`, `force_pass_update`, `note`, `website`, `profile_pic`, `table_add_advanced`, `language`, `user_level`, `smtp_username`, `smtp_server`, `smtp_password`, `smtp_port`, `signature`) VALUES ("1","192.168.2.54","admin","$2y$08$gzAMDR4cLwrlo0KXAJhYaucaN9UXjzCTos6.pHwL7w2lUaAeuJMBG",NULL,"info@db-admin.net",NULL,NULL,NULL,"4oR/q0QldYbANByLtbQR8u",1451776916,0,1502563135,1,"admin","admin","Hero Company","5050542954",0,0,"this is an administrator account","",NULL,1,"english",1,"haziryapilmisivar","smtp.sendgrid.net","sa123654",2525,NULL);';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'DROP TABLE IF EXISTS `___users_groups`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $sql = 'CREATE TABLE `___users_groups` ( `id` int(11) NOT NULL AUTO_INCREMENT, `user_id` int(11) unsigned NOT NULL, `group_id` mediumint(8) unsigned NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`) USING BTREE, KEY `fk_users_groups_users1_idx` (`user_id`) USING BTREE, KEY `fk_users_groups_groups1_idx` (`group_id`) USING BTREE ) ENGINE=MyISAM DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
    $re->status = 'error';
    $re->msg = "Error creating table: " . $con->error;
    echo  json_encode($re);
    return;
}

    $sql = 'INSERT INTO `___users_groups` (`id`, `user_id`, `group_id`) VALUES (1,1,1);';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }
    $sql = 'DROP TABLE IF EXISTS `___login_attempts`;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }
    $sql = 'CREATE TABLE `___login_attempts` ( `id` int(11) unsigned NOT NULL AUTO_INCREMENT, `ip_address` varchar(15) NOT NULL, `login` varchar(100) NOT NULL, `time` int(11) unsigned DEFAULT NULL, PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
    if ($con->query($sql) !== TRUE) {
        $re->status = 'error';
        $re->msg = "Error creating table: " . $con->error;
        echo  json_encode($re);
        return;
    }

    $re->status = 'success';
    $re->msg = 'Database Tables Generated Successfully';
    echo  json_encode($re);
    return;



}


if (isset($_POST['connect_db']) && !empty($_POST['connect_db'])) {
    header('Content-Type: application/json');
    $re = new stdClass();
    if (!isset($_POST['db_url']) || empty($_POST['db_url'])) {

        $re->status = 'error';
        $re->msg = 'Please Enter Database URL !!!';
        $re->pulsate = 'db_url';
        echo  json_encode($re);
        return;
    }

    if (!isset($_POST['db_name']) || empty($_POST['db_name'])) {

        $re->status = 'error';
        $re->msg = 'Please Enter Database Name !!!';
        $re->pulsate = 'db_name';
        echo  json_encode($re);
        return;
    }
    if (!isset($_POST['db_user_name']) || empty($_POST['db_user_name'])) {

        $re->status = 'error';
        $re->msg = 'Please Enter Database User Name !!!';
        $re->pulsate = 'db_user_name';
        echo  json_encode($re);
        return;
    }
    if (!isset($_POST['db_url']) || empty($_POST['db_url'])) {

        $re->status = 'error';
        $re->msg = 'Please Enter Database URL !!!';
        $re->pulsate = 'db_url';
        echo  json_encode($re);
        return;
    }
    $con = mysqli_connect($_POST['db_url'], $_POST['db_user_name'], $_POST['db_pass'], $_POST['db_name']);

    if (mysqli_connect_errno()) {
        $re->status = 'error';
        $re->msg = "Failed to connect to MySQL: " . mysqli_connect_error();
        echo  json_encode($re);
        return;

    }



    $re->status = 'success';
    $re->msg = 'Successfully Connected to database';
    echo  json_encode($re);
    return;




}
//
//
//if(isset($_POST['db_url']) && !empty($_POST['db_url'])){
//if(function_exists('mysqli_connect')){
//
//}
//
//}


?>


<!DOCTYPE html>
<html>
<head>
    <title>Db-admin.net</title>
    <meta charset="UTF-8">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="db-admin.net panel">
    <meta name="keywords" content="db-admin.net panel">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="skin-black">
<header class="header">
</header>


<div class="row">
    <br><br><br>
</div>
<div id="test_system_row" class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <header class="panel-heading">
                Testing System
            </header>
            <div class="panel-body">
                <div class="list-group">
                    <a id="php_version" href="#" class="list-group-item ">Php
                        version <?php $v = explode('.', PHP_VERSION);
                        echo $v[0] . '.' . $v[1] . '.' . abs($v[2]); ?> > 5.3.10 <span id="php_version_ok"
                                                                                       class="badge">?</span></a>
                    <a id="php_mysqli" href="#" class="list-group-item">Php Mysqli Extension <span id="php_mysqli_ok"
                                                                                                   class="badge">?</span></a>

                </div>


                <button id="test_system_next" class="btn btn-info pull-right" type="button" disabled>Next</button>

            </div>
        </div>
    </div>
</div>
<div id="connect_db_row" class="row" style="display: none;">
    <div class="col-md-4 col-md-offset-4">
        <section class="panel panel-primary">
            <header class="panel-heading">
                Build Database Form
            </header>
            <div class="panel-body">
                <form id="connect_db_form" action="setup.php" method="post">

                    <input class="hidden" name="connect_db"  value="1">
                    <div class="form-group">
                        <label for="db_url">Database URL ( usually: localhost )</label>
                        <input id="db_url" class="form-control" name="db_url" placeholder="Database URL" value="localhost">
                    </div>

                    <div class="form-group">
                        <label for="db_name">Database Name</label>
                        <input id="db_name"  class="form-control" name="db_name" placeholder="Database Name">
                    </div>

                    <div class="form-group">
                        <label for="db_user_name">Database User Name</label>
                        <input id="db_user_name" class="form-control" name="db_user_name" placeholder="Database User Name">
                    </div>
                    <div class="form-group">
                        <label for="db_pass">Database Password</label>
                        <input id="db_pass" type="password" class="form-control" name="db_pass" placeholder="Password">
                    </div>




<!--                    <label class="checkbox-custom checkbox-inline" data-initialize="checkbox" id="remember">-->
<!--                                                <input class="sr-only" type="checkbox" name="remember" checked> <span class="checkbox-label"> Remember me</span>-->
<!--                    </label>-->

                        <a id="db_connect_result" href="#" class="list-group-item hidden" style="margin:5px">  <span id="db_connect_result_ok"
                                                                                                                  class="badge">?</span></a>


                    <button id="connect_db" class="btn btn-info pull-right" type="button">Connect Database</button>


                </form>

            </div>
        </section>

    </div>

</div>


<div id="generate_tables_row" class="row" style="display: none;">
    <div class="col-md-4 col-md-offset-4">
        <section class="panel panel-primary">
            <header class="panel-heading">
                Build Database Form
            </header>
            <div class="panel-body">
                <form id="generate_tables_form" action="setup.php" method="post">

                    <input class="hidden" name="connect_db"  value="1">
                    <div class="form-group">
                        <label for="db_url">Database URL ( usually: localhost )</label>
                        <input id="db_url" class="form-control" name="db_url" placeholder="Database URL" value="localhost">
                    </div>

                    <div class="form-group">
                        <label for="db_name">Database Name</label>
                        <input id="db_name"  class="form-control" name="db_name" placeholder="Database Name">
                    </div>

                    <div class="form-group">
                        <label for="db_user_name">Database User Name</label>
                        <input id="db_user_name" class="form-control" name="db_user_name" placeholder="Database User Name">
                    </div>
                    <div class="form-group">
                        <label for="db_pass">Database Password</label>
                        <input id="db_pass" type="password" class="form-control" name="db_pass" placeholder="Password">
                    </div>




                    <!--                    <label class="checkbox-custom checkbox-inline" data-initialize="checkbox" id="remember">-->
                    <!--                                                <input class="sr-only" type="checkbox" name="remember" checked> <span class="checkbox-label"> Remember me</span>-->
                    <!--                    </label>-->

                    <a id="db_connect_result" href="#" class="list-group-item hidden" style="margin:5px">  <span id="db_connect_result_ok"
                                                                                                                 class="badge">?</span></a>


                    <button id="build_db_submit" class="btn btn-info pull-right" type="button">Build Database</button>


                </form>

            </div>
        </section>

    </div>

</div>

<div id="build_db_row" class="row hidden">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-primary">
            <header class="panel-heading">
                Testing System
            </header>
            <div class="panel-body">
                <div class="list-group" id="build_db_list">

                    <a id="php_mysqli" href="#" class="list-group-item">Php Mysqli Extension <span id="php_mysqli_ok" class="badge">?</span></a>

                </div>
            </div>
        </div>
    </div>
</div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="setup.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $('input').off().iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
    });

</script>


</html>
