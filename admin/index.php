<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin page</title>
</head>
<body>
    <div class="header">
        <h1>Admin page</h1>
    </div>

    <div class="main-content">
        <div id="add-person">
            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">
                <label>Name: </label>
                    <input type="text" name="person_name" size="10" />
                <label>ID: </label>
                    <input type="text" name="person_id" size="10" />
                <label>Section: </label>
                    <select name="person_section">
                        <option value="0" selected></option>
                        <option value="1">Section 1</option>
                        <option value="2">Section 2</option>
                        <option value="3">Section 3</option>
                        <option value="4">Section 4</option>
                    </select>
                <label>Role: </label>
                    <select name="person_role">
                        <option value="0" selected></option>
                        <option value="1">Role 1</option>
                        <option value="2">Role 2</option>
                        <option value="3">Role 3</option>
                        <option value="4">Role 4</option>
                        <option value="5">Role 5</option>
                    </select>
                <label>Rank: </label>
                    <select name="person_rank">
                        <option value="0" selected></option>
                        <option value="1">Rank 1</option>
                        <option value="2">Rank 2</option>
                        <option value="3">Rank 3</option>
                        <option value="4">Rank 4</option>
                    </select>
                <input type="submit" name="addPerson" value="Add Person" />
            </form>
        </div>
    </div>

    
    <?php
        checkDBforTable();

        if(isset($_POST['addPerson'])){
            addPersonToDB();
            addPersonSchedule();
        }else if(isset($_POST['deletePerson'])){
            deletePersonFromDB();
            deletePersonSchedule();
        }else if(isset($_POST['editPerson'])){
            editPersonFromDB();
        }

        function checkDBforTable(){
            //check if table exists in DB
            //otherwise create table
            $db = new SQLite3('mydb.sq3');
            $sql_query = "CREATE TABLE IF NOT EXISTS MyTeam 
                        (name TEXT, 
                        id TEXT, 
                        section INTEGER,
                        role INTEGER,
                        rank INTEGER
                        );";
            $sql_query .= "CREATE TABLE IF NOT EXISTS MyTeamSchedule 
                            (id TEXT, 
                            year TEXT,
                            week INTEGER,
                            status_mon INTEGER,
                            status_tue INTEGER,
                            status_wed INTEGER,
                            status_thu INTEGER,
                            status_fri INTEGER,
                            status_sat INTEGER,
                            status_sun INTEGER
                            );"; 
            $db -> query($sql_query);
        }

        function addPersonToDB(){
            //add new person's info into database
            $person_name = $_POST['person_name'];
            $person_id = $_POST['person_id'];
            $person_section = $_POST['person_section'];
            $person_role = $_POST['person_role'];
            $person_rank = $_POST['person_rank'];
            $sql_query =    "INSERT INTO MyTeam
                            VALUES(
                            '".trim($person_name)."',
                            '".trim($person_id)."',
                            '".$person_section."',
                            '".$person_role."',
                            '".$person_rank."');";
            $db = new SQLite3('mydb.sq3');
            $db -> query($sql_query);
        }

        function addPersonSchedule(){
            //initialize schedule of added person
            $db=new SQLite3('mydb.sq3');
            $person_id = $_POST['person_id'];
            $sql_query = "";
            for($week =1; $week<=52; $week++){
                $sql_query =  "INSERT INTO MyTeamSchedule
                                (id, 
                                year, 
                                week, 
                                status_mon, 
                                status_tue, 
                                status_wed,
                                status_thu,
                                status_fri,
                                status_sat,
                                status_sun)
                                VALUES
                                ('".trim($person_id)."',
                                '".date("Y")."',
                                ".$week.",
                                0,
                                0,
                                0,
                                0,
                                0,
                                0,
                                0);";
                $db->query($sql_query);
            }

        }

        function deletePersonFromDB(){
            //Permanently deletes a person's info from the DB
            $person_id = $_POST['person_id_edit'];
            $sql_query = "DELETE FROM MyTeam
                          WHERE id = '".$person_id."';";
            $db = new SQLite3('mydb.sq3');
            $db->query($sql_query);
        }

        function deletePersonSchedule(){
            //Permanently deletes a person's schedule from the DB
            $person_id = $_POST['person_id_edit'];
            $sql_query = "DELETE FROM MyTeamSchedule
                          WHERE id = '".$person_id."';";
            $db = new SQLite3('mydb.sq3');
            $db->query($sql_query);
        }

        function editPersonFromDB(){
            //Edit person's info
            $person_id = $_POST['person_id_edit'];
            $person_section = $_POST['person_section_edit'];
            $person_role = $_POST['person_role_edit'];
            $person_rank = $_POST['person_rank_edit'];
            $sql_query = "UPDATE MyTeam
                            SET 
                            section = ".$person_section.",
                            role = ".$person_role.",
                            rank = ".$person_rank."
                            WHERE 
                            id='".$person_id."';";
            $db = new SQLite3('mydb.sq3');
            $db->query($sql_query);
        }

        function showTable(){
            $db = new SQLite3("mydb.sq3");
            $sql_query = "SELECT *
                            FROM
                                MyTeam
                            ORDER BY
                                section ASC,
                                role ASC,
                                rank ASC,
                                id ASC";
            $result = $db ->query($sql_query);

            //Table Header
            echo "<table>";
            echo "<tr>";
            echo "  <th>Name</th>
                    <th>ID</th>
                    <th>Section</th>
                    <th>Role</th>
                    <th>Rank</th>
                    <th>Modify</th>";
            echo "</tr>";

            //Table Body
            echo "<tbody>";
                while($row = $result->fetchArray(SQLITE3_ASSOC)){
                    echo "<tr>";
                    echo "<form method ='post' action=".htmlentities($_SERVER['PHP_SELF']).">";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>
                            <select class='editPerson' name='person_section_edit'>
                                <option value='1' ".($row['section']=='1'? "selected='selected'":"").">Section 1</option>
                                <option value='2' ".($row['section']=='2'? "selected='selected'":"").">Section 2</option>
                                <option value='3' ".($row['section']=='3'? "selected='selected'":"").">Section 3</option>
                                <option value='4' ".($row['section']=='4'? "selected='selected'":"").">Section 4</option>
                            </select>
                          </td>";

                    echo "<td>
                          <select class='editPerson' name='person_role_edit'>
                              <option value='1' ".($row['role']=='1'? "selected='selected'":"").">Role 1</option>
                              <option value='2' ".($row['role']=='2'? "selected='selected'":"").">Role 2</option>
                              <option value='3' ".($row['role']=='3'? "selected='selected'":"").">Role 3</option>
                              <option value='4' ".($row['role']=='4'? "selected='selected'":"").">Role 4</option>
                              <option value='5' ".($row['role']=='5'? "selected='selected'":"").">Role 5</option>
                          </select>
                        </td>";

                    echo "<td>
                        <select class='editPerson' name='person_rank_edit'>
                            <option value='1' ".($row['rank']=='1'? "selected='selected'":"").">Rank 1</option>
                            <option value='2' ".($row['rank']=='2'? "selected='selected'":"").">Rank 2</option>
                            <option value='3' ".($row['rank']=='3'? "selected='selected'":"").">Rank 3</option>
                            <option value='4' ".($row['rank']=='4'? "selected='selected'":"").">Rank 4</option>
                        </select>
                      </td>";

                      echo "<td>";
                      echo "<input type='submit' value='Edit' name='editPerson'>";
                      echo "<input type='submit' value='Delete' name='deletePerson' onclick=\"return confirm('Are you sure?');\">";
                      echo "<input type='hidden' value='".$row['id']."' name='person_id_edit'>";
                      echo "</td>";
                      echo "</form>";
                      echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                unset($db);
        }
        showTable();
    ?>

</body>
</html>