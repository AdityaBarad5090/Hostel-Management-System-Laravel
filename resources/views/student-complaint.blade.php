<!DOCTYPE html>
<html>

<head>
    <title>Complaint</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        .box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h4 class="text-center"> Student</h4>

        <a href="/student/dashboard" class="active"><i class="fa fa-home"></i> Dashboard</a>
        <a href="/student/room"><i class="fa fa-bed"></i> My Room</a>
        <a href="/student/fees"><i class="fa fa-money-bill"></i> Fees</a>
        <a href="#" class="bg-primary"><i class="fa fa-exclamation-circle"></i> Complaint</a>
        <hr>
        <a href="/student/logout" class="btn btn-danger w-100 mt-3">Logout</a>
    </div>

    <div class="main">

        <h3>Complaint</h3>

        <div class="box">
            <h5>Submit Complaint</h5>

            <form action="/student/complaint" method="POST">
                @csrf
                <textarea name="complaint" class="form-control mb-2" placeholder="Write your complaint" required></textarea>
                <button class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div class="box">
            <h5>My Complaints</h5>

            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Room No</th>
                        <th>Complaint</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($complaints as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->student->name }}</td>
                        <td>{{ $c->student->room ? $c->student->room->room_number : 'N/A' }}</td>
                        <td>{{ $c->complaint }}</td>
                        <td>
                            @if($c->status == 'Pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                            @else
                            <span class="badge bg-success">Resolved</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">No complaints found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </div>

</body>

</html>