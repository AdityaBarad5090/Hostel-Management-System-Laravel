<!DOCTYPE html>
<html>

<head>
    <title>Hostel Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .box {
            width: 400px;
            margin: 120px auto;
            padding: 40px;
            background: white;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .btn-custom {
            width: 100%;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="box">
        <h3 class="mb-4">Hostel Management System</h3>

        <a href="/admin/login" class="btn btn-primary btn-custom">
            Admin Login
        </a>

        <a href="/student/login" class="btn btn-success btn-custom">
            Student Login
        </a>
    </div>

</body>

</html>
