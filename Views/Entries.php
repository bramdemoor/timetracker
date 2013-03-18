<!DOCTYPE html>
<html>
<head>
    <?php include('Includes/Header.php'); ?>
</head>
<body>
    <div class="container">
        <?php include('Includes/Navigation.php') ?>
        <h3>New Entry</h3>

        <div id="message"></div>
        <div id="entry_form">
            <form name="entry" action="">
                <fieldset>
                    <div class="input-append">
                        <input type="text" name="task" id="tscode-txt" data-provide="typeahead" autocomplete="off" value=""
                               placeholder="Timesheetcode..."/>
                        <input type="text" name="task" id="task-txt" data-provide="typeahead" autocomplete="off" value=""
                               placeholder="Description..."/>
                        <button id="submit_btn" class="btn" type="button"><i class="icon-plus"></i></button>
                    </div>
                </fieldset>
            </form>
        </div>
        <h3>Entries</h3>

        <div id="table-entries">
            <?php
            $entries = $data['entries'];
            foreach ($entries as $key => $value) {
                ?>
                <h5><?php echo (new DateTime($key))->format('D d F Y');?></h5>
                <table class="table table-hover table-condensed">
                    <?php foreach ($value as &$task) { ?>
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
                    <?php } ?>
                </table>
             <?php }?>
        </div>
    </div>
</body>
</html>


