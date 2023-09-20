<?php
session_start();
include "connect_db.php";

$NIP = $_POST["NIP"];
$Password = $_POST["Password"];
$sql = "SELECT UserID, Name, Type FROM users WHERE NIP = '$NIP' AND Password = '$Password'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$name = $row["Name"];
$type = $row["Type"];

if ($result->num_rows <> 0) {
    header("Location: dashboardPage.php");
    $_SESSION["NIP"] = $NIP;
    $_SESSION["Username"] = $name;
    $_SESSION["UserType"] = $type;
} else {
    header("Location: LoginPage.php?isError=404");
}

$conn->close();