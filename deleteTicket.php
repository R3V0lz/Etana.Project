<?php
include "connect_db.php";

$IDDelete = $_GET["IDTicket"];

// Delete in folder
$file = "SELECT FileUploaded FROM tickettable WHERE TicketID='$IDDelete'";
$result = $conn->query($file);
$row = $result->fetch_assoc();
$path = './ticketImage/' . $row["FileUploaded"];
// echo $path;
unlink($path);


// Delete in data base
$sql = "DELETE FROM tickettable WHERE TicketID= '$IDDelete'";
$result = $conn->query($sql);

header("Location: ticketTable.php?ticketDeleted=1");