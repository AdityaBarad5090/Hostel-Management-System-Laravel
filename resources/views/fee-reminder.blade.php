<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; padding: 20px;">

    <h2>Fee Payment Reminder</h2>

    <p>Dear <strong>{{ $fee->student->name }}</strong>,</p>

    <p>This is a reminder that your hostel fee is <strong>pending</strong>.</p>

    <table border="1" cellpadding="8" style="border-collapse:collapse;">
        <tr>
            <td>Room No</td>
            <td>{{ $fee->student->room->room_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Amount Due</td>
            <td>₹{{ $fee->amount }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>Pending</td>
        </tr>
    </table>
                            
    <p>Please pay your fee as soon as possible.</p>
    <p>Regards,<br>Hostel Management</p>

</body>
</html>