<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

include('includes/TaskController.php');

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
            <h1>Timetracker</h1>
            <h2>New Entry</h2>
            <div id="message"></div>
            <div id="entry_form">
                <form name="entry" action="">
                    <fieldset>
                        <div class="input-append">
                            <input type="text" name="task" id="tscode-txt" data-provide="typeahead" autocomplete="off" size="30" value="" placeholder="Timesheetcode..." />
                            <input type="text" name="task" id="task-txt" data-provide="typeahead" autocomplete="off" size="30" value="" placeholder="Task..." />
                            <button id="submit_btn" class="btn" type="button"><i class="icon-plus"></i></button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <h2>Entries</h2>

            <table id="table-entries" class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            Taak
                        </th>
                        <th>
                            Start
                        </th>
                    </tr>
                </thead>
            <?php
                $entries = getAllEntries();
                foreach($entries as &$value) { ?>
                    <tr class="task-entry">
                        <td class="tscode-field">
                            <?php echo $value['TSCode'] ?>
                        </td>
                        <td class="task-field" data-pk="<?php echo $value['Id'] ?>">
                            <?php echo $value['Task'] ?>
                        </td>
                        <td class="datetime-field">
                            <?php echo (new DateTime($value['Start']))->format('Y-m-d H:i'); ?>
                        </td>
                        <td class="button-group">
                            <a href="#" class="edit-btn"><i class="icon-edit"></i></a>
                            <a href="#" class="remove-btn"><i class="icon-remove"></i></a>
                        </td>
                    </tr>
                <?php }
            ?>
            </table>
        </div>
    </body>
</html>









