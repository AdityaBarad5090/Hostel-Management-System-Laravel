<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fee Receipt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            background: #fff;
            color: #1e293b;
            padding: 40px;
        }

        /* Header */
        .header {
            text-align: center;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 18px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 26px;
            color: #2563eb;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Receipt No & Date */
        .meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 28px;
            font-size: 13px;
            color: #64748b;
        }

        .meta span strong {
            color: #1e293b;
        }

        /* Receipt Title */
        .receipt-title {
            background: #2563eb;
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 15px;
            font-weight: bold;
            letter-spacing: 1px;
            border-radius: 6px;
            margin-bottom: 28px;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .info-table tr td {
            padding: 12px 16px;
            font-size: 13.5px;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-table tr td:first-child {
            color: #64748b;
            font-weight: 600;
            width: 40%;
        }

        .info-table tr td:last-child {
            color: #1e293b;
            font-weight: 700;
        }

        .info-table tr:last-child td {
            border-bottom: none;
        }

        /* Amount Row */
        .amount-row td {
            background: #eff6ff;
        }

        .amount-row td:last-child {
            color: #2563eb !important;
            font-size: 20px !important;
        }

        /* Status Badge */
        .badge-paid {
            background: #22c55e;
            color: #fff;
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-unpaid {
            background: #fbbf24;
            color: #78350f;
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .footer .note {
            font-size: 11px;
            color: #94a3b8;
            max-width: 260px;
            line-height: 1.6;
        }

        .footer .signature {
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }

        .footer .signature .line {
            border-top: 1px solid #1e293b;
            width: 160px;
            margin-bottom: 6px;
        }

        .watermark {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            color: #cbd5e1;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>🏠 Hostel Management System</h1>
        <p>Official Fee Payment Receipt</p>
    </div>

    <div class="meta">
        <span>Date: <strong>{{ now()->format('d M Y') }}</strong></span>
    </div>

    <!-- Title -->
    <div class="receipt-title">FEE RECEIPT</div>

    <!-- Info Table -->
    <table class="info-table">
        <tr>
            <td>Student Name</td>
            <td>{{ $student->name }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $student->email }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $student->phone }}</td>
        </tr>
        <tr>
            <td>Room Number</td>
            <td>{{ $student->room?->room_number ?? 'N/A' }}</td>
        </tr>
        <tr class="amount-row">
            <td>Fee Amount</td>
            <td>₹ {{ number_format($fee->amount) }}</td>
        </tr>
        <tr>
            <td>Payment Status</td>
            <td>
                @if($fee->status == 'paid')
                    <span class="badge-paid">✓ Paid</span>
                @else
                    <span class="badge-unpaid">⏳ Unpaid</span>
                @endif
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        <div class="note">
            * This is a computer generated receipt and does not require a physical signature.<br>
            * Keep this receipt for future reference.
        </div>
        <div class="signature">
            <div class="line"></div>
            Authorized Signature
        </div>
    </div>

    <div class="watermark">Hostel Management System &mdash; {{ now()->year }}</div>

</body>
</html>