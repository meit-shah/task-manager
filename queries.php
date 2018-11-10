<?php 
    class QueryBuilder
{
    protected $conn; // store the db username, dbname , password from pdo into this variable    
    public function __construct($conn) // contructor of the QueryBuilder class
    {
        $this->conn = $conn;
    }

 // Task Functions 

  public function insertTask($table_name, $task_column, $deadline_column){ // insert new task into db
    if(isset($_POST['submit'])){
      $taskInput = $_POST['taskInput'];
      $taskDeadLine = $_POST['taskDeadLine'];
      if(!empty($taskInput) && !empty($taskDeadLine)){//insert into db if inputs are not blank
        $sql = "INSERT into $table_name(`$task_column`,`$deadline_column`) values('$taskInput','$taskDeadLine')";
        $insertTaskSql = $this -> conn -> prepare($sql);
        $insertTaskSql-> execute();
      }else{
        echo "<script>alert('Blank inputs are not allowed. Please enter a task');</script>";
      }
    }
 }

  // delete function for on clicking the delete button
  // call the header function to input a raw data, which in this case is index.php
  // so when index.php is entered as raw data the page will refresh and data will be retrieved on the fly

  public function deleteTask($rowId){ 
    $deleteTaskSql = "DELETE from tasklist WHERE tasklist.`id` = $rowId" ;
    $prepareSql = $this -> conn -> prepare($deleteTaskSql);
    $prepareSql -> execute();
    header('location: index.php'); 
  }

  //function for deleting task value from task list when task completed button is clicked

  public function taskCompleted($taskValue){
    $taskCompletedSql = "DELETE FROM tasklist WHERE tasklist.`task`= '$taskValue'" ;
    $prepareSql = $this-> conn-> prepare($taskCompletedSql);
    $prepareSql-> execute();
  }

  //retrieve the tasks from db and display the total count of tasks in the list

  public function getTasksArray(){
    $tasksArraySql = "SELECT * from tasklist"; 
    $prepareSql = $this-> conn -> prepare($tasksArraySql);
    $prepareSql -> execute(); 
    $tasksArray = $prepareSql -> fetchAll(); // fetch all the data of the db in array
    return  $tasksArray; 
  }

  // display the tasks to users

  public function displayTaskList($task_column, $deadline, $id){ // fetch and display all the tasks form db
    $tasksArray = $this-> getTasksArray(); // fetch all the tasks from db in and array and store in php variable
    echo "<h4 class='text-center' style='background-color:#aaa;color:white;padding:10px;'> Total Pending Tasks = ".sizeof($tasksArray)."</h4>"; // display the count of pending tasks
    foreach($tasksArray as $task){
      $displayAllTasks = 
      '<li>
        <form action="#" name="taskCompleteForm" method="GET">
          <input type="text" value="'.$task[$task_column].'">
          <button class="btn btn-primary">'.$task[$deadline].'</button>
          <input name="hiddenInput" type="hidden" value="'.$task[$id].'">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
          <a href = "index.php?completed='.$task[$task_column].'" class="completeButton">Task Completed</a>
          <a href = "index.php?delete='.$task[$id].'" class="deleteButton">Delete</a>
        </form>
      </li>'; 

      if(isset($_GET['delete'])){
        $rowId = $_GET['delete'];
        $this-> deleteTask($rowId); // call the delete function on button click
      }

      if(isset($_GET['completed'])){
        $completedTask = $_GET['completed'];
        $this-> taskCompleted($completedTask);// delete the task from the list on clicking the complete button
        header("location: index.php");
      }
      echo $displayAllTasks;  // display all the tasks in form
    } 
  }

  // Goals List Functions , goals are nothing but the tasks that are completed

  public function getGoalsArray(){ // to the get the count of goals in the database
    $goalsArraySql = "SELECT * from goals";
    $prepareSql = $this-> conn -> prepare($goalsArraySql);
    $prepareSql->execute();
    $goalsArray = $prepareSql -> fetchAll();
    return $goalsArray;
  }

  public function insertIntoGoals($value){ // insert into database  a new goals
    $insertGoalSql = "INSERT INTO goals(`list`) values('$value')";
    $prepareSql = $this-> conn -> prepare($insertGoalSql);
    $prepareSql ->execute();
  }

  public function displayGoalsList(){ // display all goals from db   
    if(isset($_GET['completed'])){ // on clicking the task completed button the task will be deleted and added to goals completed list
      $completedTask = $_GET['completed'];
      $this-> insertIntoGoals($completedTask); // add the deleted task to the goals list
    }
    $goalsArray = $this-> getGoalsArray();
    for($table_row=0;$table_row<sizeof($goalsArray);$table_row++){
     echo "<li>".$goalsArray[$table_row]['list']."</li>"; // display all the tasks in the list
    }
  }
}