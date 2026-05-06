<!DOCTYPE html>
<html>

<head>
    <title>Complaints</title>

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

        <a href="/dashboard"><i class="fa fa-home"></i> Dashboard</a>
        <a href="/students"><i class="fas fa-users"></i> Students</a>
        <a href="/rooms"><i class="fas fa-bed"></i> Rooms</a>
        <a href="/fees"><i class="fas fa-money-bill"></i> Fees</a>
        <a href="#" class="bg-primary"><i class="fas fa-exclamation-circle"></i> Complaints</a>
        <hr>
        <a href="/logout" class="btn btn-danger w-100">Logout</a>
    </div>

    <div class="main">

        <div class="d-flex justify-content-between align-items-center mt-3">
            <h4>Complaints Management</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#complaintModal">
                Add Complaint
            </button>
        </div>

        <div class="modal fade" id="complaintModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('complaints.store') }}" method="POST">
                        @csrf

                        <div class="modal-header">
                            <h5>Add Complaint</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <select name="student_id" class="form-control mb-3" required>
                                <option value="">Select Student</option>
                                @foreach($students as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>

                            <textarea name="complaint" class="form-control mb-3" placeholder="Write complaint..." required></textarea>

                            <select name="status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="resolved">Resolved</option>
                            </select>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Save</button>
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="mt-3">
            <table class="table table-bordered text-center" id="complaintTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Student </th>
                        <th>Room No</th>
                        <th>Complaint</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($complaints as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td>{{ $c->student->name }}</td>
                        <td>{{ $c->student->room ? $c->student->room->room_number : 'N/A' }}</td>
                        <td>{{ $c->complaint }}</td>
                        <td>{{ $c->status }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick="openEditModal('{{ $c->id }}', '{{ $c->student_id }}', '{{ $c->complaint }}', '{{ $c->status }}')">
                                Edit
                            </button>

                            <form action="{{ route('complaints.destroy', $c->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
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
                            <h5>Edit Complaint</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <select name="student_id" id="edit_student_id" class="form-control mb-3">
                                @foreach($students as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>

                            <textarea name="complaint" id="edit_complaint" class="form-control mb-3"></textarea>

                            <select name="status" id="edit_status" class="form-control">
                                <option value="pending">Pending</option>
                                <option value="resolved">Resolved</option>
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
        function openEditModal(id, student_id, complaint, status) {

            document.getElementById('edit_student_id').value = student_id;
            document.getElementById('edit_complaint').value = complaint;
            document.getElementById('edit_status').value = status;
            document.getElementById('editForm').action = "/complaints/" + id;

            let modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }
        $(document).ready(function() {
            $('#complaintTable').DataTable();
        });
    </script>

</body>

</html>