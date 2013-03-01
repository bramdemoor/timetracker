<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

include('includes/DatabaseLayer.php');

$dbLayer = DatabaseLayer::getInstance();

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
        <script src="js/bootstrap.js"></script>

        <div class="container">

            <h1>Timetracker</h1>
            <h2>Entries</h2>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>
                            Taak
                        </th>
                        <th>
                            Start
                        </th>
                        <th>
                            Stop
                        </th>
                    </tr>
                </thead>
            <?php
                $entries = $dbLayer->getAllEntries();
                foreach($entries as &$value) { ?>
                    <tr>
                        <td>
                            <?php echo $value['Task'] ?>
                        </td>
                        <td>
                            <?php echo $value['Start'] ?>
                        </td>
                        <td>
                            <?php echo $value['Stop'] ?>
                        </td>
                    </tr>
                <?php }
            ?>
            </table>
        </div>
    </body>
</html>








