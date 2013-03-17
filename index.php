<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

use Library\Loader\SplClassLoader,
    Library\Controllers\TaskController;

require_once __DIR__ . "/Library/Loader/SplClassLoader.php";
$autoloader = new SplClassLoader();
$autoloader->register();

$taskcontroller = new TaskController();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Timetracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="css/main.css" rel="stylesheet" media="screen">
    <link href="bootstrap-editable-1/bootstrap-editable/css/bootstrap-editable.css" rel="stylesheet">
</head>
    <body>
        <script src="js/jquery-1.9.1.min.js"></script>
        <script src="js/jquery.dateFormat-1.0.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/jquery-migrate-1.1.1.min.js"></script>
        <script src="js/bootstrap-typeahead.js"></script>
        <script src="bootstrap-editable-1/bootstrap-editable/js/bootstrap-editable.js"></script>
        <script src="js/main.js"></script>
        <div class="container">
            <div class="navbar">
                <div class="navbar-inner">
                    <a class="brand" href="#">Timetracker</a>
                    <ul class="nav">
                        <li class="active"><a href="#">Entries</a></li>
                        <li><a href="#">Reporting</a></li>
                        <li><a href="#">Export</a></li>
                    </ul>
                </div>
            </div>
            <h2>New Entry</h2>
            <div id="message"></div>
            <div id="entry_form">
                <form name="entry" action="">
                    <fieldset>
                        <div class="input-append">
                            <input type="text" name="task" id="tscode-txt" data-provide="typeahead" autocomplete="off" value="" placeholder="Timesheetcode..." />
                            <input type="text" name="task" id="task-txt" data-provide="typeahead" autocomplete="off" value="" placeholder="Description..." />
                            <button id="submit_btn" class="btn" type="button"><i class="icon-plus"></i></button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <h2>Entries</h2>
            <?php
                $entries = $taskcontroller->getAllEntries();
                foreach($entries as $key => $value) { ?>
                    <h4><?php echo (new DateTime($key))->format('D d F Y');?></h4>
                    <table id="table-entries" class="table table-hover table-condensed">
                    <?php foreach($value as &$task) { ?>
                            <tr class="task-entry">
                                <td class="tscode-field">
                                    <?php echo $task['TSCode'] ?>
                                </td>
                                <td class="task-field" data-pk="<?php echo $task['Id'] ?>">
                                    <?php echo $task['Task'] ?>
                                </td>
                                <td class="datetime-field">
                                    <small>Start:</small> <?php echo (new DateTime($task['Start']))->format('H:i'); ?>
                                </td>
                                <td class="button-group">
                                    <a href="#" class="edit-btn"><i class="icon-edit"></i></a>
                                    <a href="#" class="remove-btn"><i class="icon-remove"></i></a>
                                </td>
                            </tr>

                    <?php  } ?>
                    </table>
               <?php }?>
        </div>
    </body>
</html>









