<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Schedule Tracker PHP</title>
</head>
<body>

    <div class="header">
    <h1>Schedule Tracker in PHP</h1>
    </div>

    <?php 
        //Get today's date
        date_default_timezone_set("Asia/Seoul");
        $date_today = date("Y-m-d", time());
        $daysInAWeek=array("mon","tue","wed","thu","fri","sat","sun");
        $selected_week = thisWeek($date_today);

        function thisWeek($date_today){
            $result = date("W", strtotime($date_today));
            return $result;
        }
    ?>
    <div id="week-selector">
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
        <span>
            <input type="submit" name="lastWeek" id="week-shortcut" value="Last Week"/>
        </span>s
        <span>
            <select name="select_week" id="week_select">
                <?php 
                    for($week=1;$week<=52;$week++){
                        echo "<option class='' value='".$week."'";
                            if ($selected_week==$week){
                                echo "selected";
                            }
                            echo ">Week ".$week."</option>";
                    }
                ?>
            </select>
            <input type="submit" name="formSubmit" value="Show" />
            <input type="submit" name="formSave" value="Save" />
        </span>

        <span>
            <input type="submit" name="nextWeek" id="week-shortcut" value="Next Week"/>
        </span>
    </div>
</body>
</html>