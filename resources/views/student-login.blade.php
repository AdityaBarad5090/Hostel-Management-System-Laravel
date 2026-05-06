<!DOCTYPE html>
<html>

<head>
    <title>Student Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }               
        .login-box {
            width: 350px;
            margin: 120px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body>

    <div class="login-box">
        <h4 class="text-center mb-4">Student Login</h4>
           
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>         
        @endif
                                                                       
        <form method="POST" action="/student/login">
            @csrf

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Enter Email" required autofocus>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Login</button>
            <button type="button" class="btn btn-link w-100 mt-2" onclick="window.location='/'">
                Back To Home
            </button>
        </form>
    </div>
       
</body>                                                                                                                                  
</html>