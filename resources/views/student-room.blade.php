<!DOCTYPE html>
<html>

<head>
    <title>My Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        .main {
            background: #f0f2f7;
            min-height: 100vh;
            padding: 32px;
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 24px;
        }

        /* Room card */
        .room-card {
            background: #3b5fe2;
            border-radius: 16px;
            padding: 28px 32px;
            color: #fff;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .room-card h2 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .room-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px 80px;
        }

        .field-label {
            font-size: 12px;
            opacity: 0.75;
            margin-bottom: 3px;
        }

        .field-value {
            font-size: 20px;
            font-weight: 600;
        }

        .fee-row {
            grid-column: 1 / -1;
            margin-top: 4px;
        }

        .fee-value {
            font-size: 26px;
            font-weight: 700;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 16px;
        }

        .roommates-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }

        .roommate-card {
            background: #fff;
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 0.5px solid rgba(0,0,0,0.08);
        }

        .roommate-name {
            font-size: 16px;
            font-weight: 600;
            color: #1a202c;
        }

        .roommate-phone {
            font-size: 14px;
            color: #718096;
            margin-top: 2px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4 class="text-center"> Student</h4>

        <a href="/student/dashboard" class="active"><i class="fa fa-home"></i> Dashboard</a>
        <a href="#" class="bg-primary"><i class="fa fa-bed"></i> My Room</a>
        <a href="/student/fees"><i class="fa fa-money-bill"></i> Fees</a>
        <a href="/student/complaint"><i class="fa fa-exclamation-circle"></i> Complaint</a>
        <hr>
        <a href="/student/logout" class="btn btn-danger w-100 mt-3">Logout</a>
    </div>

    <div class="main">

        <div class="page-title">
            My Room
        </div>

        @if($room)

        <div class="room-card">
            <div>
                <h2>Room Details</h2>
                <div class="room-fields">
                    <div>
                        <div class="field-label">Room Number</div>
                        <div class="field-value">{{ $room->room_number }}</div>
                    </div>
                    <div>
                        <div class="field-label">Capacity</div>
                        <div class="field-value">{{ $room->capacity }}</div>
                    </div>
                    <div class="fee-row">
                        <div class="field-label">Monthly Fee</div>
                        <div class="fee-value">₹{{ $room->fee }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($room->students && $room->students->count() > 0)
        <div class="section-title">
            <i class="fa fa-users" style="color:#4a5568;"></i>
            Roommates
        </div>
        <div class="roommates-grid">
            @foreach($room->students as $student)
            <div class="roommate-card">
                
                <div>
                    <div class="roommate-name">{{ $student->name }}</div>
                    <div class="roommate-phone">{{ $student->phone }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @else
        <div class="alert alert-warning">
            No room assigned yet.
        </div>
        @endif

    </div>

</body>

</html>