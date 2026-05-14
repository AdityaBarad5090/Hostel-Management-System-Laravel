<!DOCTYPE html>
<html>

<head>

    <title>Hostel Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/style.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>

        body.dark-mode {
            background: #121212;
            color: white;
        }

        body.dark-mode .card {
            background: #1e1e1e;
            color: white;
        }

        body.dark-mode .table {
            color: white;
        }

        body.dark-mode input,
        body.dark-mode select,
        body.dark-mode textarea {
            background: #2c2c2c;
            color: white;
            border: 1px solid #555;
        }

        body.dark-mode .navbar {
            background: #1a1a1a !important;
        }

        body.dark-mode .sidebar {
            background: #1a1a1a;
        }

    </style>

</head>

<body>

    @yield('content')

    <script>

        const toggleBtn = document.getElementById('theme-toggle');

        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {

            document.body.classList.add('dark-mode');

            if(toggleBtn){
                toggleBtn.innerHTML = '☀️';
            }
        }

        // Toggle
        if(toggleBtn){

            toggleBtn.addEventListener('click', () => {

                document.body.classList.toggle('dark-mode');

                if (document.body.classList.contains('dark-mode')) {

                    localStorage.setItem('theme', 'dark');

                    toggleBtn.innerHTML = '☀️';

                } else {

                    localStorage.setItem('theme', 'light');

                    toggleBtn.innerHTML = '🌙';
                }

            });

        }

    </script>

</body>

</html>