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
</head>
    <body>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/jquery.dateFormat-1.0.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/main.js"></script>

        <div class="container">
            <h1>Timetracker</h1>
            <h2>New Entry</h2>
            <div id="message"></div>
            <div id="entry_form">
                <form name="entry" action="">
                    <fieldset>
                        <div class="input-append">
                            <input type="text" name="task" id="task" size="30" value="" placeholder="Task..." />
                            <input type="submit" name="submit" class="btn" id="submit_btn" value="Send" />
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
                    <tr>
                        <td>
                            <?php echo $value['Task'] ?>
                        </td>
                        <td>
                            <?php echo (new DateTime($value['Start']))->format('Y-m-d H:i'); ?>
                        </td>
                    </tr>
                <?php }
            ?>
            </table>
        </div>
    </body>
</html>








