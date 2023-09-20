<?php
session_start();

include "connect_db.php";

$target_dir = "ticketImage/";
$target_file = $target_dir . basename($_FILES["fileUpl"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


// Check image is actual or fake
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileUpl"]["tmp_name"]);
    if ($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        header("Location: formTicket.php?fakeImage=1");
        $uploadOk = 0;
    }
}

// Check already exists
if (file_exists($target_file)) {
    // echo "Sorry, file already exists.";
    header("Location: formTicket.php?alrExist=1");
    $uploadOk = 0;
}

// Check size
if ($_FILES["fileUpl"]["size"] > 5000000) {
    // echo "Sorry, your file is too large.";
    header("Location: formTicket.php?tooLarge=1");
    $uploadOk = 0;
}

// Allow file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    // echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    header("Location: formTicket.php?wrongFormat=1");
    $uploadOk = 0;
}

// Check $uploadOk is set to 0 by an error
if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileUpl"]["tmp_name"], $target_file)) {

        // Upload Success
        $title = $_POST["ticketTitle"];
        $desc = $_POST["descTicket"];
        $file = $_FILES["fileUpl"]["name"];
        $created = $_SESSION["NIP"];

        $sql = "INSERT INTO tickettable (TicketTitle, TicketDesc, FileUploaded, IDStatus, CreatedBy) VALUES ('$title','$desc','$file', 1, '$created')";
        $result = $conn->query($sql);
        // echo "Upload Success";
        header("Location: formTicket.php?UploadOK=1");
    }
}