<!DOCTYPE html>
<html>

<head>
    <title>Hostel Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<body>

    <div class="sidebar">
        <h4 class="text-center mb-4">Hostel</h4>

        <a href="#" class="bg-primary"><i class="fas fa-home"></i> Dashboard</a>
        <a href="/students"><i class="fas fa-users"></i> Students</a>
        <a href="/rooms"><i class="fas fa-bed"></i> Rooms</a>
        <a href="/fees"><i class="fas fa-money-bill"></i> Fees</a>
        <a href="/complaints"><i class="fas fa-exclamation-circle"></i> Complaints</a>
        <hr>
        <a href="/logout" class="btn btn-danger w-100">Logout</a>
    </div>

    <div class="main">

        <h2 class="mb-4">Dashboard</h2>

        <div class="row g-4">

            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5>Total Students</h5>
                        <h2>{{ $students }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5>Total Rooms</h5>
                        <h2>{{ $rooms }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5>Complaints</h5>
                        <h2>{{ $complaints }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center shadow">
                    <div class="card-body">
                        <h5>Fees</h5>
                        <h2>{{ $fees }}</h2>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>