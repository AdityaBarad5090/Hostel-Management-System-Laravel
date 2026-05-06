<!DOCTYPE html>
<html>

<head>
    <title>Fees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>

    <div class="sidebar">
        <h4 class="text-center mb-4">Hostel</h4>
        <a href="/dashboard"><i class="fas fa-home"></i> Dashboard</a>
        <a href="/students"><i class="fas fa-users"></i> Students</a>
        <a href="/rooms"><i class="fas fa-bed"></i> Rooms</a>
        <a href="#" class="bg-primary"><i class="fas fa-money-bill"></i> Fees</a>
        <a href="/complaints"><i class="fas fa-exclamation-circle"></i> Complaints</a>
        <hr>
        <a href="/logout" class="btn btn-danger w-100">Logout</a>
    </div>

    <div class="main">

        <div class="d-flex justify-content-between align-items-center mt-3">
            <h4>Fees Management</h4>
        </div>
        @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        <div class="mt-3">
            <table class="table table-bordered table-striped text-center" id="feeTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Room No</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fees as $f)
                    <tr>
                        <td>{{ $f->id }}</td>
                        <td>{{ $f->student->name ?? 'N/A' }}</td>
                        <td>{{ $f->student->email ?? 'N/A' }}</td>
                        <td>{{ $f->student->room->room_number ?? 'N/A' }}</td>
                        <td>{{ $f->amount }}</td>
                        <td>
                            @if(strtolower($f->status) == 'paid')
                            <span class="badge bg-success">Paid</span>
                            @else
                            <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick="openEditModal('{{ $f->id }}', '{{ strtolower($f->status) }}')">
                                Edit
                            </button>

                            <form action="{{ route('fees.destroy', $f->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>

                            @if(strtolower($f->status) == 'pending')
                            <form action="{{ route('fees.remind', $f->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-envelope"></i> Remind
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="editModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5>Edit Fee Status</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <label class="form-label">Status</label>
                            <select name="status" id="edit_status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Update</button>
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openEditModal(id, status) {
            document.getElementById('edit_status').value = status;
            document.getElementById('editForm').action = "/fees/" + id;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }

        $(document).ready(function() {
            $('#feeTable').DataTable();
        });
    </script>
</body>

</html>