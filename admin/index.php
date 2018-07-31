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
        if(isset($_POST['addPerson'])){
            addPersonToDB();
            addPersonSchedule();
        }else if(isset($_POST['deletePerson'])){
            deletePersonFromDB();
            deletePersonSchedule();
        }else if(isset($_POST['editPerson'])){
            editPersonFromDB();
        }
    ?>

</body>
</html>