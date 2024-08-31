<?php
session_start();
// Create connection
$con = new mysqli("localhost", "root", "", "crud_expense_project");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$total = 0;
$update = false;
$id = 0;
$name = '';
$amount = '';

if (isset($_POST['save'])) {

    $budget = $_POST['budget'];
    $amount = $_POST['amount'];

    $query = mysqli_query($con, "INSERT INTO budget (name, amount) VALUE ('$budget', '$amount')");

    $_SESSION['massage'] = "Your record is now stored!";
    $_SESSION['msg_type'] = "primary";

    header("location: index.php?result=true");
}

//calculate Total budget
$result = mysqli_query($con, "SELECT * FROM budget");
while ($row = $result->fetch_assoc()) {
    $total = $total + $row['amount'];
}

//delete data

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = mysqli_query($con, "DELETE FROM budget WHERE id=$id");
    $_SESSION['massage'] = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";

    header("location: index.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = mysqli_query($con, "SELECT * FROM budget WHERE id=$id");


    if (mysqli_num_rows($result) == 1) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $amount = $row['amount'];
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $budget = $_POST['budget'];
    $amount = $_POST['amount'];

    $query = mysqli_query($con, "UPDATE budget SET name='$budget', amount='$amount' WHERE id='$id'");
    $_SESSION['massage'] = "Your record is now updated!";
    $_SESSION['msg_type'] = "success";
    header("location: index.php");
}
