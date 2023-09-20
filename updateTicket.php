<?php
include "connect_db.php";

$title = $_POST["titleUpdate"];
$desc = $_POST["descUpdate"];
$type = $_POST["ticketStatus"];
$resolution = $_POST["resolution"];
$assigned = $_POST["ticketAssigned"];
$ID = $_GET["ticketID"];

$sql = "UPDATE tickettable SET TicketTitle='$title', TicketDesc='$desc', IDStatus='$type', Resolution='$resolution', AssignTo='$assigned' WHERE TicketID='$ID'";
if ($conn->query($sql) === TRUE) {
    // header("Location: formTicket.php?UpdateOK=1");
    header("Location: ticketTable.php?UpdateOK=1");
} else {
    // header("Location:formTicket.php?UpdateFail=1");
    header("Location:ticketTable.php?UpdateFail=1");
}

?>