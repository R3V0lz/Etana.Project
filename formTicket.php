<?php
session_start();

if (!isset($_SESSION["NIP"])) {
    header("Location: loginPage.php");
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>Ticket Form</title>
</head>

<body>
    <nav class="navbar navbar-expand bg-dark navbar-dark" style="height:8vh; padding: 0 10px">
        <div class="container-fluid">
            <a class="navbar-brand" onclick="document.location='./loginPage.php'" href="#">Service Desk</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTicketingWeb"
                aria-controls="navbarTicketingWeb" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarTicketingWeb">
                <ul class="navbar-nav">
                    <li class="navbar-brand dropdown">
                        <a class="nav-link dropdown-toggle-split" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?php echo $_SESSION["Username"]; ?>
                            <img src="./image_pg/userAvatar.jpg" alt="Logo" style="margin-left: 10px; width:30px;"
                                class="rounded-pill">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><button onclick="document.location='./logout.php'"
                                    class="dropdown-item btn">Logout</button></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Side bar -->
            <div class="col-sm-12 col-lg-2 sidebar d-flex flex-column">
                <button onclick="document.location='./dashboardPage.php'" type="button"
                    class="border rounded-4 border-0 btn btn-dark sidebar-button">Dashboard</button>
                <button onclick="document.location='./reqPage.php'" type="button"
                    class="border rounded-4 border-0 shadow btn btn-dark sidebar-button"
                    style="background-color: #495057;">Request</button>
            </div>
            <div class="col-lg-10 main-content pt-5" style="overflow-y: auto;">
                <!-- Connect Data Base -->
                <?php
                include "connect_db.php";

                $update = isset($_GET["updateID"]);

                if ($update) {
                    $IDUpdate = $_GET["updateID"];
                    $update = "SELECT * FROM tickettable WHERE TicketID = '$IDUpdate'";
                    $result = $conn->query($update);
                    $row = $result->fetch_assoc();

                    $assigned = "SELECT NIP, Name FROM users WHERE Type = 'Technician'";
                    $techResult = $conn->query($assigned);
                }

                if ($update) { ?>
                    <!-- Update Ticket -->
                    <h2 class="fw-bold">Incident Request Update</h2>
                    <form action='updateTicket.php?ticketID= <?php echo $_GET["updateID"]; ?>' method=post
                        enctype="multipart/form-data" class="was-validated">
                        <div class="row fs-4" id="Form1">
                            <div class="col-sm-12 col-lg-6 me-5">
                                <div class="mt-1">
                                    <label for="titleUpdate" class="form-label">Ticket Title</label>
                                    <input type="text" class="form-control" id="titleUpdate" placeholder="Enter title"
                                        name="titleUpdate" value="<?php echo $row["TicketTitle"]; ?>" required>
                                </div>
                                <div class="mt-1">
                                    <label for="ticketStatus" class="form-label mt-2">Ticket Status</label>
                                    <select class="form-select" id=ticketStatus name="ticketStatus">
                                        <option value="" disabled>Choose</option>
                                        <option value=1 <?php
                                        if ($row["IDStatus"] == "1") {
                                            echo "selected";
                                        }
                                        ?>>Pending</option>
                                        <option value=2 <?php
                                        if ($row["IDStatus"] == "2") {
                                            echo "selected";
                                        }
                                        ?>>Open Ticket</option>
                                        <option value=3 <?php
                                        if ($row["IDStatus"] == "3") {
                                            echo "selected";
                                        }
                                        ?>>On Process</option>
                                        <option value=4 <?php
                                        if ($row["IDStatus"] == "4") {
                                            echo "selected";
                                        }
                                        ?>>Done</option>
                                    </select>
                                </div>
                                <div class="mt-1">
                                <label for="ticketAssigned" class="form-label mt-2">Assigned To</label>
                                    <select class="form-select" id=ticketAssigned name="ticketAssigned">
                                        <option value="">Choose</option>

                                        <?php while ($assignTo = $techResult->fetch_assoc()) { ?>
                                            <option value="<?php echo $assignTo["NIP"]; ?>" <?php if ($row["AssignTo"] == $assignTo["NIP"]) {
                                            echo "selected";
                                        } ?>><?php echo $assignTo["Name"]; ?></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="my-3">
                                    <p class="form-label">Image Description</p>
                                    <img src='./ticketImage/<?php echo $row["FileUploaded"]; ?>'
                                        class="rounded img-fluid ms-3" style="max-width: 220px">
                                </div>
                            </div>
                        </div>
                        <div class="row fs-4" id="Form2" style="width: 95%;">
                            <label class="mt-2 mb-1" for="descUpdate">Description</label>
                            <textarea class="form-control mb-3" rows="5" id="descUpdate" name="descUpdate"
                                style="resize: none; margin-left: 13px"
                                required><?php echo $row["TicketDesc"]; ?></textarea>
                        </div>
                        <div class="row fs-4" id="Form3" style="width: 95%;">
                            <label class="mb-1" for="resolution">Resolution</label>
                            <textarea class="form-control mb-3" rows="5" id="resolution" name="resolution"
                                style="resize: none; margin-left: 13px"></textarea>
                        </div>
                        <div class="row d-flex justify-content-between align-items-end"
                            style="height: 8vh; background-color: white">
                            <button type="button" class="col-1 btn btn-danger form-btn"
                                onclick="document.location='./ticketTable.php'">Back</button>
                            <button type="submit" class="col-3 btn btn-success form-btn">Update</button>
                        </div>
                    </form>

                <?php } else { ?>
                    <!-- New Ticket -->
                    <h2 class="fw-bold">Incident Request Form</h2>
                    <form action='NewTicket.php' method=post enctype="multipart/form-data" class="was-validated">
                        <div class="row fs-4" id="Form1">
                            <div class="col-sm-12 col-lg-6 me-5">
                                <div class="my-3">
                                    <label for="ticketTitle" class="form-label">What's wrong?</label>
                                    <input type="text" class="form-control" id="ticketTitle" placeholder="Enter title"
                                        name="ticketTitle" required>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="my-3">
                                    <label for="formFile" class="form-label">Can you send an Image?</label>
                                    <input class="form-control" type="file" id="formFile" name="fileUpl" required>
                                </div>
                            </div>
                        </div>
                        <div class="row fs-4" id="Form2" style="width: 95%;">
                            <label class="mb-1" for="descTicket">Description</label>
                            <textarea class="form-control mb-3" rows="6" id="descTicket" name="descTicket"
                                style="resize: none; margin-left: 13px" required></textarea>
                        </div>

                        <?php
                        if (isset($_GET["fakeImage"])) {
                            // Msg Fake Image
                            echo "<div class='alert alert-danger text-center text-center' style='margin: 0px; padding: 2px; width: 95%;'>
                                          <strong>Error!</strong> Sorry, choose an actual image.</div>";
                        } elseif (isset($_GET["alrExist"])) {
                            // Msg Alr Exist 
                            echo "<div class='alert alert-danger text-center text-center' style='margin: 0px; padding: 2px; width: 95%;'>
                                          <strong>Error!</strong> Sorry, your file already exists.</div>";
                        } elseif (isset($_GET["tooLarge"])) {
                            // Msg Too Large
                            echo "<div class='alert alert-danger text-center text-center' style='margin: 0px; padding: 2px; width: 95%;'>
                                          <strong>Error!</strong> Sorry, your file is too large.</div>";
                        } elseif (isset($_GET["wrongFormat"])) {
                            // Msg Wrong Format
                            echo "<div class='alert alert-danger text-center text-center' style='margin: 0px; padding: 2px; width:95%;'>
                                          <strong>Error!</strong> Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
                        } elseif (isset($_GET["UploadOK"])) {
                            // Msg Upload Success
                            echo "<div class='alert alert-success text-center text-center' style='margin: 0px; padding: 2px; width:95%;'>
                                          <strong>Success!</strong> Your ticket request has been sent.</div>";
                        } else {
                            echo "<div style='height:29.6px;'></div>";
                        }
                        ?>

                        <div class="row d-flex justify-content-between align-items-end"
                            style="height: 25vh; background-color: white">
                            <button type="button" class="col-1 btn btn-danger form-btn"
                                onclick="document.location='./ticketTable.php'">Back</button>
                            <button type="submit" class="col-3 btn btn-success form-btn">Submit</button>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</body>


</html>
<script>
$(document).ready(function(){
    $("#Form3").hide()

    $("#ticketStatus").change(function(){
        if($("#ticketStatus").val() == 4){
        $("#Form3").show()
        }else{
             $("#Form3").hide()
        }
    })
})
</script>