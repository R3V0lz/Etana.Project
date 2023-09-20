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
    <link rel="stylesheet" href="style.css">
    <title>Request Page</title>
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
            <div class="col-lg-10 main-content">
                <div class="row">
                    <button onclick="document.location='./ticketTable.php'" class="col sub-request btn btn-light"
                        type="button">
                        <h3>Incident Request</h3>
                    </button>
                    <button onclick="document.location='./serviceTable.php'" class="col sub-request btn btn-light"
                        type="button">
                        <h3>Service Request</h3>
                    </button>
                </div>
                <div class="row">
                    <button onclick="document.location='./...'" class="col sub-request btn btn-light" type="button">
                        <h3>Change Request</h3>
                    </button>
                    <button onclick="document.location='./newEmploy.html'" class="col sub-request btn btn-light"
                        type="button">
                        <h3>New Employee</h3>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>