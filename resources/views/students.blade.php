<!DOCTYPE html>
<html>

<head>
    <title>Students</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    @if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
    @endif

    @extends('layouts.app')
    @section('content')


    <div class="sidebar">
        <h4 class="text-center mb-4">Hostel</h4>

        <a href="/dashboard"><i class="fas fa-home"></i> Dashboard</a>
        <a href="#" class="bg-primary"><i class="fas fa-users"></i> Students</a>
        <a href="/rooms"><i class="fas fa-bed"></i> Rooms</a>
        <a href="/fees"><i class="fas fa-money-bill"></i> Fees</a>
        <a href="/complaints"><i class="fas fa-exclamation-circle"></i> Complaints</a>
        <hr>
        <a href="/logout" class="btn btn-danger w-100">Logout</a>
    </div>

    <div class="main">

        <div class="d-flex justify-content-between align-items-center mt-3">
            <h4>Students Management</h4>
            <button id="theme-toggle" class="btn btn-dark" style="margin-left: 820px;">
                🌙
            </button>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#studentModal">
                Add Student
            </button>
        </div>

        <div class="modal fade" id="studentModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('students.store') }}" method="POST">
                        @csrf

                        <div class="modal-header">
                            <h5>Add Student</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="text" name="name" class="form-control mb-3" placeholder="Name" required>
                            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                            <input type="text" name="phone" class="form-control mb-3" placeholder="Phone" required>

                            <select name="room_id" class="form-control">
                                <option value="">Select Room</option>
                                @foreach($rooms as $r)
                                <option value="{{ $r->id }}">{{ $r->room_number }}</option>
                                @endforeach
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
            <table class="table table-striped table-bordered text-center" id="studentTable">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Room</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $s)
                    <tr>
                        <td>{{ $s->id }}</td>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->email }}</td>
                        <td>{{ $s->phone }}</td>
                        <td>{{ $s->room_id }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                onclick="openEditModal('{{ $s->id }}', '{{ $s->name }}', '{{ $s->email }}', '{{ $s->phone }}','{{ $s->room_id }}')">
                                Edit
                            </button>
                            <form action="{{ route('students.destroy', $s->id) }}" method="POST" style="display:inline;">
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
                            <h5>Edit Student</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <input type="text" name="name" id="edit_name" class="form-control mb-3">
                            <input type="email" name="email" id="edit_email" class="form-control mb-3">
                            <input type="text" name="phone" id="edit_phone" class="form-control mb-3">

                            <select name="room_id" id="edit_room_id" class="form-control">
                                @foreach($rooms as $r)
                                <option value="{{ $r->id }}">{{ $r->room_number }}</option>
                                @endforeach
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
        @endsection
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openEditModal(id, name, email, phone, room_id) {

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_phone').value = phone;
            document.getElementById('edit_room_id').value = room_id;

            document.getElementById('editForm').action = "/students/" + id;

            let modal = new bootstrap.Modal(document.getElementById('editModal'));
            modal.show();
        }

        $(document).ready(function() {
            $('#studentTable').DataTable();
        });
    </script>
</body>

</html>