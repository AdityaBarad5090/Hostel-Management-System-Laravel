<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">

    <style>
        .box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0d6efd;
        }

        .avatar-initials {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #0d6efd;
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            border: 3px solid #0d6efd;
        }

        .photo-label {
            cursor: pointer;
            color: #0d6efd;
            font-size: 13px;
            margin-top: 6px;
            display: inline-block;
        }

        .photo-label:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4 class="text-center"> Student</h4>

        <a href="/student/dashboard"><i class="fa fa-home"></i> Dashboard</a>
        <a href="/student/room"><i class="fa fa-bed"></i> My Room</a>
        <a href="/student/fees"><i class="fa fa-money-bill"></i> Fees</a>
        <a href="/student/complaint"><i class="fa fa-exclamation-circle"></i> Complaint</a>
        <a href="/student/profile" class="bg-primary"><i class="fa fa-user"></i> Profile</a>
        <hr>
        <a href="/student/logout" class="btn btn-danger w-100 mt-3">Logout</a>
    </div>

    <div class="main">

        <h3>👤 My Profile</h3>

        @if(session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-2">{{ session('error') }}</div>
        @endif

        @if(session('password_error'))
            <div class="alert alert-danger mt-2">{{ session('password_error') }}</div>
        @endif

        <form action="/student/profile/update" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="box mt-3">

                {{-- Profile Photo --}}
                <div class="text-center mb-4">
                    @if($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}"
                            id="preview" class="profile-avatar">
                    @else
                        <div class="avatar-initials" id="initialsBox">
                            {{ strtoupper(substr($student->name, 0, 1)) }}
                        </div>
                        <img id="preview" class="profile-avatar" style="display:none;">
                    @endif
                    <label for="photo" class="photo-label">
                        <i class="fa fa-camera"></i> Change Photo
                    </label>
                    <input type="file" id="photo" name="photo" accept="image/*" hidden
                        onchange="previewPhoto(this)">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $student->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $student->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" class="form-control"
                        value="{{ old('phone', $student->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Room Number</label>
                    <input type="text" class="form-control"
                        value="{{ $student->room?->room_number ?? 'Not Assigned' }}" disabled>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa fa-floppy-disk"></i> Save Changes
                    </button>
                    <button type="button" class="btn btn-outline-secondary w-100"
                        data-bs-toggle="modal" data-bs-target="#passwordModal">
                        <i class="fa fa-lock"></i> Change Password
                    </button>
                </div>

            </div>

        </form>

    </div>

    <div class="modal fade" id="passwordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-lock"></i> Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="/student/profile/password" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" name="current_password" class="form-control"
                                placeholder="Enter current password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Enter new password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm new password" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-floppy-disk"></i> Update Password
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Hide initials box if visible
                    var initials = document.getElementById('initialsBox');
                    if (initials) initials.style.display = 'none';

                    // Show preview image
                    var preview = document.getElementById('preview');
                    preview.src = e.target.result;
                    preview.style.display = 'inline-block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>
</html>