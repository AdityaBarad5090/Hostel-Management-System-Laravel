<!DOCTYPE html>
<html>

<head>
    <title>My Fees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        .fee-card {
            background: #fff;
            border-radius: 14px;
            padding: 30px 32px 28px;
            max-width: 520px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
        }

        .fee-card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .fee-field {
            margin-bottom: 20px;
        }

        .fee-field label {
            display: block;
            font-size: 0.82rem;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .fee-field .value {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .fee-field .amount {
            font-size: 30px;
            color: #2563eb;
        }

        .badge-unpaid {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fbbf24;
            color: #78350f;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 6px 16px;
            border-radius: 999px;
        }

        .badge-paid {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #22c55e;
            color: #fff;
            font-weight: 700;
            font-size: 0.88rem;
            padding: 6px 16px;
            border-radius: 999px;
        }

        .btn-pay {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 13px;
            font-size: 0.97rem;
            font-weight: 700;
            width: 100%;
            margin-top: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.18s;
        }

        .btn-pay:hover {
            background: #1d4ed8;
            color: #fff;
        }

        .btn-download {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            background: #16a34a;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 13px;
            font-size: 0.97rem;
            font-weight: 700;
            width: 100%;
            margin-top: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.18s;
        }

        .btn-download:hover {
            background: #15803d;
            color: #fff;
        }

        .btn-download.disabled {
            background: #cbd5e1;
            color: #94a3b8;
            cursor: not-allowed;
            pointer-events: none;
        }

        .alert-success-custom {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #15803d;
            border-radius: 10px;
            padding: 14px 18px;
            font-weight: 600;
            font-size: 0.95rem;
            max-width: 520px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<div>hello</div>
<body>
<div></div>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center"> Student</h4>

        <a href="/student/dashboard" class="active"><i class="fa fa-home"></i> Dashboard</a>
        <a href="/student/room"><i class="fa fa-bed"></i> My Room</a>
        <a href="#" class="bg-primary"><i class="fa fa-money-bill"></i> Fees</a>
        <a href="/student/complaint"><i class="fa fa-exclamation-circle"></i> Complaint</a>
        <hr>
        <a href="/student/logout" class="btn btn-danger w-100 mt-3">Logout</a>
    </div>

    <div class="main">

        <h3>💰 My Fees</h3>
        @if(session('success'))
            <div class="alert-success-custom mt-3">
                <i class="fa fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @forelse($fees as $f)
        <div class="fee-card mt-3">

            <div class="fee-card-title">
                📋 Fee Details
            </div>

            <div class="fee-field">
                <label>Student Name</label>
                <div class="value">{{ $student?->name ?? 'N/A' }}</div>
            </div>

            <div class="fee-field">
                <label>Room Number</label>
                <div class="value">{{ $student->room?->room_number ?? 'N/A' }}</div>
            </div>

            <div class="fee-field">
                <label>Fee Amount</label>
                <div class="amount">₹ {{ number_format($f->amount) }}</div>
            </div>

            <div class="fee-field">
                <label>Payment Status</label>
                <div>
                    @if(strtolower($f->status) == 'paid')
                        <span class="badge-paid"><i class="fa fa-check-circle"></i> Paid</span>
                    @else
                        <span class="badge-unpaid">⏳ Unpaid</span>
                    @endif
                </div>   
            </div>                                                                                                                                                                                                                                  
                                                                                                                                
            @if(strtolower($f->status) != 'paid')
                <a href="/student/fees/pay/{{ $f->id }}" class="btn-pay">
                    <i class="fa fa-credit-card"></i> Pay Fees
                </a>
            @endif                                                                                                 

            @if(strtolower($f->status) == 'paid')
                <a href="/student/fees/receipt/{{ $f->id }}" class="btn-download">
                    <i class="fa fa-download"></i> Download Receipt
                </a>
            @else
                <a class="btn-download disabled">
                    <i class="fa fa-lock"></i> Receipt Unavailable (Unpaid)
                </a>
            @endif

        </div>
        @empty
        <div class="fee-card mt-3">
            <div class="fee-card-title">📋 Fee Details</div>
            <p class="text-muted text-center py-3">No fees record found.</p>
        </div>
        @endforelse

    </div>

</body>
</html>