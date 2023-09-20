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
    <title>Ticket Table</title>
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

                if ($_SESSION["UserType"] == "Admin") {
                    $sql = "SELECT tickettable.*, statusticket.StatusName, users.Name AS Created, usertech.Name AS Assigned FROM tickettable
                    JOIN statusticket ON tickettable.IDStatus = statusticket.StatusID 
                    JOIN users ON tickettable.CreatedBy = users.NIP 
                    LEFT JOIN users AS usertech ON usertech.NIP = tickettable.AssignTo
                    ORDER BY IDStatus ASC, TicketID";
                    $result = $conn->query($sql);

                } elseif ($_SESSION["UserType"] == "Technician") {
                    $NIP = $_SESSION["NIP"];
                    $sql = "SELECT tickettable.*, statusticket.StatusName, users.Name AS Created, usertech.Name AS Assigned FROM tickettable
                    JOIN statusticket ON tickettable.IDStatus = statusticket.StatusID 
                    JOIN users ON tickettable.CreatedBy = users.NIP 
                    LEFT JOIN users AS usertech ON usertech.NIP = tickettable.AssignTo
                    WHERE tickettable.AssignTo='$NIP'
                    ORDER BY IDStatus ASC, TicketID";
                    $result = $conn->query($sql);

                } elseif ($_SESSION["UserType"] == "User") {
                    $NIP = $_SESSION["NIP"];
                    $sql = "SELECT tickettable.*, statusticket.StatusName, usertech.Name FROM tickettable
                    JOIN statusticket ON tickettable.IDStatus = statusticket.StatusID 
                    LEFT JOIN users AS usertech ON usertech.NIP = tickettable.AssignTo 
                    WHERE tickettable.CreatedBy='$NIP'
                    ORDER BY IDStatus ASC, TicketID";
                    $result = $conn->query($sql);
                }

                ?>

                <div class="row">
                    <h2 class="col fw-bold">Incident Request List</h2>
                    <button type="button" class="col-sm-3 btn btn-success p-2 me-4 mb-2"
                        style="width: fit-content; height: fit-content;"
                        onclick="document.location='./formTicket.php'">New
                        Ticket</button>
                </div>
                <div class="row">
                    <?php
                    if (isset($_GET["UpdateOK"])) {
                        echo "<div class='alert alert-success alert-dismissible ms-3 mt-1' style='padding: 2px; width: 96%'>
                        <button type='button' class='btn-close' style='padding: 5px 10px'
                            data-bs-dismiss='alert'></button>
                        <strong>Success!</strong> Update success.</div>";
                    } elseif (isset($_GET["UpdateFail"])) {
                        echo "<div class='alert alert-danger alert-dismissible ms-3 mt-1' style='padding: 2px; width: 96%'>
                        <button type='button' class='btn-close' style='padding: 5px 10px'
                            data-bs-dismiss='alert'></button>
                        <strong>Error!</strong> Update failed.</div>";
                    }
                    ?>
                </div>
                <?php

                if ($_SESSION["UserType"] == "Admin" || $_SESSION["UserType"] == "Technician") { ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Desc</th>
                                <th scope="col">Created</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Assigned</th>
                                <th scope="col">Resolution</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td>
                                        <?php echo $row["TicketTitle"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["TicketDesc"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["Created"]; ?>
                                    </td>
                                    <td><img src='./ticketImage/<?php echo $row["FileUploaded"]; ?>'
                                            class="rounded img-fluid mx-auto d-block" style="max-width: 200px">
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge rounded-pill 
                                            <?php
                                            if ($row["StatusName"] == 'Done') {
                                                echo 'bg-success';
                                            } elseif ($row["StatusName"] == 'Open Ticket') {
                                                echo 'bg-info';
                                            } elseif ($row["StatusName"] == 'On Process') {
                                                echo 'bg-warning';
                                            } else {
                                                echo 'bg-primary';
                                            }
                                            ?> fs-5">
                                            <?php echo $row["StatusName"]; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo $row["Assigned"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["Resolution"]; ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button
                                            onclick="document.location='./formTicket.php?updateID=<?php echo $row['TicketID']; ?>'"
                                            class="my-2 py-2 col-10 btn btn-success" style="<?php if ($row["StatusName"] == 'Done') {
                                                echo 'display: none';
                                            } ?>">Update</button>
                                        <button onclick="getID(<?php echo $row['TicketID']; ?>)"
                                            class="my-2 py-2 col-10 btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#delModal" style="<?php if ($row["StatusName"] == 'Done') {
                                                echo 'display: none';
                                            } ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Desc</th>
                                <th scope="col">Image</th>
                                <th scope="col">Status</th>
                                <th scope="col">Assigned</th>
                                <th scope="col">Resolution</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td>
                                        <?php echo $row["TicketTitle"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["TicketDesc"]; ?>
                                    </td>
                                    <td><img src='./ticketImage/<?php echo $row["FileUploaded"]; ?>'
                                            class="rounded img-fluid mx-auto d-block" style="max-width: 200px">
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge rounded-pill 
                                            <?php
                                            if ($row["StatusName"] == 'Done') {
                                                echo 'bg-success';
                                            } elseif ($row["StatusName"] == 'Open Ticket') {
                                                echo 'bg-info';
                                            } elseif ($row["StatusName"] == 'On Process') {
                                                echo 'bg-warning';
                                            } else {
                                                echo 'bg-primary';
                                            }
                                            ?> fs-5">
                                            <?php echo $row["StatusName"]; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo $row["Name"]; ?>
                                    </td>
                                    <td>
                                        <?php echo $row["Resolution"]; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="delModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="delModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="delModalLabel">ATTENTION!</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="IDTicket" name="IDTicket">
                    <h6>Are you sure to delete this ticket?</h6>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onclick="deleteID()">Yes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function getID(Id) {
        $("#IDTicket").val(Id)
    }

    function deleteID() {
        var IDTicket = $("#IDTicket").val()
        document.location = './deleteTicket.php?IDTicket=' + IDTicket
    }
</script>