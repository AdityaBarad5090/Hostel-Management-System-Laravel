<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        .card-box {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .profile-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .badge-paid {
            background: #22c55e;
        }

        .badge-pending {
            background: #ef4444;
        }

        .table thead {
            background: #1e293b;
            color: white;
        }

        .topbar {
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4 class="text-center"> Student</h4>

        <a href="#" class="bg-primary"><i class="fa fa-home"></i> Dashboard</a>
        <a href="/student/room"><i class="fa fa-bed"></i> My Room</a>
        <a href="/student/fees"><i class="fa fa-money-bill"></i> Fees</a>
        <a href="/student/complaint"><i class="fa fa-exclamation-circle"></i> Complaint</a>
        <a href="/student/profile"><i class="fa fa-user"></i> Profile</a>
        <hr>
        <a href="/student/logout" class="btn btn-danger w-100 mt-3">Logout</a>
    </div>

    <div class="main">

        <div class="topbar">
            <h5>Welcome, {{ $student->name }}</h5>
            <span class="text-muted">Student Dashboard</span>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="card-box">
                    <div class="card-title"> My Profile</div>

                    <div class="profile-item"><span>Name</span>{{ $student->name }}</div>
                    <div class="profile-item"><span>Email</span>{{ $student->email }}</div>
                    <div class="profile-item"><span>Phone</span>{{ $student->phone }}</div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-box">
                    <div class="card-title"> Room Details</div>

                    @if($room)
                    <div class="profile-item"><span>Room No</span>{{ $room->room_number }}</div>
                    <div class="profile-item"><span>Capacity</span>{{ $room->capacity }}</div>
                    @else
                    <p class="text-muted">No room assigned</p>
                    @endif
                </div>
            </div>

        </div>

        <div class="card-box">
            <div class="card-title"> My Fees</div>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if($fees)
                    <tr>
                        <td>₹ {{ $fees->amount }}</td>
                        <td>
                            @if(strtolower($fees->status) == 'paid')
                            <span class="badge badge-paid">Paid</span>
                            @else
                            <span class="badge badge-pending">Pending</span>
                            @endif
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="card-box">
            <div class="card-title"> My Complaints</div>

            @forelse($complaints as $c)
            <div class="profile-item">
                <span>{{ $c->complaint }}</span>
                <b class="text-primary">{{ $c->status }}</b>
            </div>
            @empty
            <p class="text-muted">No complaints submitted</p>
            @endforelse
        </div>

    </div>

</body>

</html>