<?php require 'dbconn.php'?>
<?php require 'queries.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Task Tracker App</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <header><h1><center>Task Tracker</center></h1></header>
    <hr>
    <main>
        <section id="taskInput" style="margin:20px 0px 20px 0px; padding:20px;">
            <form action="#" name="taskInputForm" class="form-inline" method="POST">
                <div class="container">
                    <div class="row text-center">
                        <div class="col-lg-4 col-xs-12">
                            <div class="form-group">
                              <label for="taskInput"><b>Enter a New Task</b> - </label>
                              <input type="text" id="taskInput" name="taskInput" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">            
                            <div class="form-group">
                                <label for="taskDeadLine"><b>Complete by</b> - </label>
                                <input type="date" id="taskDeadLine" name="taskDeadLine" placeholder="--Select deadline--" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 text-center">
                            <button type="submit" name="submit" class="btn btn-success">Add Task</button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
        <hr>
        <section id="taskListBox">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                     <h2>Task List</h2>
                        <ol id="taskList">
                        <?php          
                            $query = new QueryBuilder($conn); // connect to the db using query builder object
                            $insertTaskQuery = $query->insertTask('tasklist','task','deadline'); // insert a  new task
                            $displayTaskQuery = $query->displayTaskList('task','deadline','id'); // display all the tasks
                        ?>
                        </ol>
                    </div>
                    <div class="col-lg-4">
                      <h2>Tasks Completed</h2>
                        <ol id="taskCompleted">
                            <?php
                            $displayGoalsQuery = $query-> displayGoalsList(); // display the goals in a list form
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <hr>
        <section id="quotes">
            <center><h3>Quote of the day : <q><?= "yolo"; ?></q></h3></center>
        </section>
        <hr>
    </main>
</body>
</html>