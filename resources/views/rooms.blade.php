<!DOCTYPE html>
<html>

<head>
    <title>Rooms</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>

<body>

    @extends('layouts.app')
    @section('content')

    <div class="sidebar">
        <h4 class="text-center mb-4">Hostel</h4>

        <a href="/dashboard"><i class="fas fa-home"></i> Dashboard</a>
        <a href="/students"><i class="fas fa-users"></i> Students</a>
        <a href="#" class="bg-primary"><i class="fas fa-bed"></i> Rooms</a>
        <a href="/fees"><i class="fas fa-money-bill"></i> Fees</a>
        <a href="/complaints"><i class="fas fa-exclamation-circle"></i> Complaints</a>

        <hr>

        <a href="/logout" class="btn btn-danger w-100">Logout</a>
    </div>

    <div class="main">

        <div class="d-flex justify-content-between mb-3">
            <h4>Rooms Management</h4>
            <button id="theme-toggle" class="btn btn-dark" style="margin-left: 830px;">
                🌙
            </button>
            <button class="btn btn-success"
                onclick="openAddModal()">
                Add Room
            </button>
        </div>

        <table class="table table-bordered text-center" id="roomsTable">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Room No</th>
                    <th>Capacity</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @foreach($rooms as $r)

                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->room_number }}</td>
                    <td>{{ $r->capacity }}</td>
                    <td>{{ $r->fee }}</td>

                    <td>
                        @if($r->status == 'full')
                        <span class="badge bg-danger">Full</span>
                        @else
                        <span class="badge bg-success">Available</span>
                        @endif
                    </td>

                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editRoom('{{ $r->id }}','{{ $r->room_number }}','{{ $r->capacity }}','{{ $r->fee }}')">
                            Edit
                        </button>

                        <form action="/rooms/{{ $r->id }}" method="POST" style="display:inline;">
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

    <div class="modal fade" id="roomModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/rooms" method="POST" id="roomForm">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="POST">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Room</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="number" name="room_number" id="room_number" class="form-control mb-2" placeholder="Room No" required>
                        <input type="number" name="capacity" id="capacity" class="form-control mb-2" placeholder="Capacity" required>
                        <input type="number" name="fee" id="fee" class="form-control mb-2" placeholder="Fee" required>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </form>
            </div>
        </div>
        @endsection
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openAddModal() {
            document.getElementById("modalTitle").innerText = "Add Room";
            document.getElementById("roomForm").action = "/rooms";
            document.getElementById("methodField").value = "POST";
            document.getElementById("room_number").value = "";
            document.getElementById("capacity").value = "";
            document.getElementById("fee").value = "";

            var myModal = new bootstrap.Modal(
                document.getElementById('roomModal')
            );
            myModal.show();
        }

        function editRoom(id, room_number, capacity, fee) {
            document.getElementById("modalTitle").innerText = "Edit Room";
            document.getElementById("room_number").value = room_number;
            document.getElementById("capacity").value = capacity;
            document.getElementById("fee").value = fee;
            document.getElementById("roomForm").action = "/rooms/" + id;
            document.getElementById("methodField").value = "PUT";

            var myModal = new bootstrap.Modal(
                document.getElementById('roomModal')
            );
            myModal.show();
        }

        $(document).ready(function() {
            $('#roomsTable').DataTable();
        });
    </script>
</body>

</html>