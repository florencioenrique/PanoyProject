<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cyberian</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Custom Styling */
        body {
            background: linear-gradient( to right, rgba(255, 0, 0, 0.1), rgba(0, 0, 0, 1)), url('../static/images/card_bg.jpg');
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Roboto', sans-serif;
        }
        .login-card {
            max-width: 500px;
            margin: auto;
        }
        input{
            height: 60px;
        }

        .mb-3 {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .btn.active {
            background-color: #f90b31 !important;
            color: white !important;
            border-color: #fff !important;
            box-shadow: 0 0 10px rgb(0, 86, 179), 0 0 20px rgb(0, 86, 179), 0 0 30px rgb(0, 86, 179);
            animation: glow 1.5s ease-in-out infinite;
        }

        @keyframes glow {
            0% {
                box-shadow: 0 0 10px #dd0525, 0 0 20px #dd0525, 0 0 30px #dd0525;
            }
            50% {
                box-shadow: 0 0 20px #f90b31, 0 0 40px #f90b31, 0 0 60px #f90b31;
            }
            100% {
                box-shadow: 0 0 10px #191919, 0 0 20px #191919, 0 0 30px #191919;
            }
        }

        .custom-input {
            background-color: grey;
            border:2px solid #ccc;
            border-radius: 8px;
            padding: 1rem 0.75rem 0.5rem;
            font-size: 1rem;
            outline: none;
            position: relative;

        }

        .custom-input:focus {
            border-color: grey;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .custom-label {
            position: absolute;
            top: -0.01rem;
            left: 1rem;
            background-color: #f9f9f9;
            padding: 1 0.5rem;
            padding-top: 3px;
            color: #666; 
            font-size: 0.9rem;
            font-weight: bold;
            transition: all 0.3s ease;
            z-index: 1;
            background: none;
        }



        .custom-input:focus + .custom-label,
        .custom-input:not(:placeholder-shown) + .custom-label {
            color: #ffff; /* Highlight label color */
        }

        .login-card, h1 {
            font-size: 2.5rem;
            color: #ffff;
        }

        .form-label {
            font-size: 1rem;
            font-weight: bold;
        }

        .form-control {
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 12px;
        }

        .btn-primary {
            background-color: #191919;
            border: none;
        }
        .btn-primary:hover {
            background-color: #191919;
        }

        h3 {
            font-family: 'Roboto', sans-serif;
        }

        .img-fluid {
            max-width: 200px;
            display: block;
            margin: 0 auto 20px;
        }

        .d-flex {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            position: relative;
            overflow: hidden;
            font-size: 16px;
            text-transform: uppercase;
            border: none;
            padding: 12px 0;
            transition: all 0.3s ease;
        }

        .btn::before {
            content: "";
            position: absolute;
            top: 50%;
            left: -100%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, #dd0525, #f90b31);
            transform: rotate(-45deg);
            z-index: -1;
            transition: all 0.3s ease;
        }

        .btn:hover::before {
            left: 0;
            top: 0;
        }

        .btn-primary {
            color: white;
            background-color: transparent;
            border: 2px solid transparent;
            z-index: 1;
        }

        .btn-primary:hover {
            color: #fff;
            border-color: transparent;
        }


        @media (max-width: 768px) {
            .login-card {
                padding: 20px;
            }
            .login-card h1 {
                font-size: 2rem;
            }
        }
        
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row justify-content-center align-items-center vh-100">
            <!-- Login Form Section -->

            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="text-center">
                    <img src="../static/images/It_logo.png" class="img-fluid mb-3" alt="Logo" style="max-width: 200px;">
                    <h2 class="text-white">INFORMATION TECHNOLOGY</h2>
                    <small class="text-white">St. Anthony's College, San Jose Antique</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="login-card p-5 rounded">
                    <h3 class="mb-2 fw-bold text-danger">Login as <span id="role">Student</span></h3>
                    <div class="d-flex gap-2 mb-4">
                        <button class="btn btn-primary w-100" id="studentBtn" data-role="Student">Student</button>
                        <button class="btn btn-primary w-100" id="staffBtn" data-role="Staff">Staff</button>
                        <button class="btn btn-primary w-100" id="adminBtn" data-role="Admin">Admin</button>
                    </div>
                    <!-- Student form -->
                    <form method="POST" action="studentconnect.php" id="studentForm">
                        <div class="mb-3 position-relative">
                            <label for="student_username" class="custom-label">Username</label>
                            <input type="text" name="username" id="student_username" class="form-control custom-input p-3" autocomplete="off" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="student_password" class="custom-label">Password</label>
                            <input type="password" name="password" id="student_password" class="form-control custom-input p-3" autocomplete="off" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" name="login" style="border: 1px solid #fff; background: #191919">Login</button>
                        </div>
                    </form>

                    <!-- Admin form -->
                    <form method="POST" action="dbconnect.php" id="adminForm" style="display: none;">
                        <div class="mb-3 position-relative">
                            <label for="admin_username" class="custom-label">Username</label>
                            <input type="text" name="username" id="admin_username" class="form-control custom-input p-3" autocomplete="off" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="admin_password" class="custom-label">Password</label>
                            <input type="password" name="password" id="admin_password" class="form-control custom-input p-3" autocomplete="off" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" name="login" style="border: 1px solid #fff; background: #191919">Login</button>
                        </div>
                    </form>

                    <!-- Staff form -->
                    <form method="POST" action="staffconnect.php" id="staffForm" style="display: none;">
                        <div class="mb-3 position-relative">
                            <label for="staff_username" class="custom-label">Username</label>
                            <input type="text" name="username" id="staff_username" class="form-control custom-input p-3" autocomplete="off" required>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="staff_password" class="custom-label">Password</label>
                            <input type="password" name="password" id="staff_password" class="form-control custom-input p-3" autocomplete="off" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg login" name="login" style="border: 1px solid #fff; background: #191919">Login</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Select all role buttons
        const buttons = document.querySelectorAll('button[data-role]');
        const roleSpan = document.getElementById('role');
        const studentForm = document.getElementById('studentForm');
        const staffForm = document.getElementById('staffForm');
        const adminForm = document.getElementById('adminForm');

        // Function to show the selected form, update the role, and handle active state
        function updateRoleAndForm(role, formToShow, activeButton) {
            // Update the displayed role
            roleSpan.textContent = role;

            // Hide all forms
            studentForm.style.display = 'none';
            staffForm.style.display = 'none';
            adminForm.style.display = 'none';

            // Show the selected form
            formToShow.style.display = 'block';

            // Remove 'active' class from all buttons and add to the selected one
            buttons.forEach(button => button.classList.remove('active'));
            activeButton.classList.add('active');
        }

        // Add click event listeners to each button
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const role = button.getAttribute('data-role');
                if (role === 'Student') updateRoleAndForm('Student', studentForm, button);
                if (role === 'Staff') updateRoleAndForm('Staff', staffForm, button);
                if (role === 'Admin') updateRoleAndForm('Admin', adminForm, button);
            });
        });
    </script>
</body>
</html>
