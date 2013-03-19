<!DOCTYPE html>
<html>
<head>
    <?php include('Includes/Header.php'); ?>
</head>
<body>
    <div class="container">
        <?php include('Includes/Navigation.php') ?>
        <h3>Reports</h3>
        <div id="message"></div>
        <h4>Totals by task</h4>
        <?php
        $entries = $data['reportData'];
        foreach ($entries as $key => $value) {
            ?>
            <div class="report-group-header"><span class="date-label"><?php echo (new DateTime($key))->format('D d F Y'); ?></span><small> - Total time spent: <?php echo $value['TotalTimeSpent']->format("H:i"); ?></small></div>
            <table id="table-entries" class="table table-striped table-condensed">
                <?php foreach ($value['TSCodes'] as $taskKey => $taskValue) { ?>
                <tr class="task-entry">
                    <td class="tscode-field">
                        <blockquote>
                            <p>
                                <?php echo $taskKey ?>
                            </p>
                            <small>
                                <? if(count($taskValue) == 1) {
                                echo $taskValue[0];
                            } else {
                                foreach($taskValue['Summary'] as $descr) {
                                    echo $descr. ', ';
                                }
                            } ?>
                            </small>
                            <small>
                                <?  echo $taskValue['TimeSpent']->format("H:i"); ?>
                            </small>
                        </blockquote>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php }?>
    </div>
</body>
</html>


