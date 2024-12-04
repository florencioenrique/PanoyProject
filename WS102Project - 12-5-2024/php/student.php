<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: index.php'); // Redirect to the login page if not logged in
    exit();
}

// Retrieve student details from the session
$student_id = $_SESSION['student_id'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "../includes/head.php";
    ?>
</head>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<link rel="stylesheet" type="text/css" href="../static/css/design.css">

<style type="text/css">
    body {
        background: linear-gradient(to left, rgba(0, 0, 0, 0.9), rgba(0,0,0,0.9)), 
        url('../static/images/bg.jpg'); 
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        width: 100%;
        height: 100vh;
        margin: 0; /* Removes default margin for better layout */
    }

    .card{
        background: url('../static/images/card_bg.jpg');
        box-shadow: 8px 0 8px rgba(0, 0, 0, 0.5   );
        width: 100%;
        background-size: cover;
        color: #ffff;
    }

    .container{ 
        padding-top: 10px;
/*        background: linear-gradient(to left, rgba(255, 255, 255, 0.7), rgba(255,0,0,0.1));*/
    }

    @media (max-width: 908px){

        .container{
            margin: auto;
            width: 100%;
        }
        .card{
            width: 100%;
        }

        .content-section{
            margin-top: 50px;
        }
    }
</style>

<body>
    <!-- Sidebar Toggle Button -->
    <div class="row w-100">
        <div class="container">
            <button id="sidebar-toggle" class="btn" style="background: none;">
                <i class="bi bi-list" style="font-size: 30px; margin: -40px -20px; border: none"></i>
            </button>
        </div> 
    </div>

    <!-- Sidebar -->
    <div id="sidebar" class="container">
        <div id="sidebar-brand">
            <img src="../static/images/It_logo.png" alt="Profile Picture" class="img-fluid">
            <div class="text-container">
                <label><?php echo htmlspecialchars($firstname);?> <?php echo htmlspecialchars($lastname);?>
                <?php
                include "../includes/config.php";

                $student_id = $_SESSION['student_id']; 

                $sql = "SELECT year FROM student WHERE student_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('i', $student_id);
                $stmt->execute();
                $stmt->bind_result($year);
                $stmt->fetch();

                echo "| BSIT" . htmlspecialchars($year);

                $stmt->close();
                ?>

            </label>
                <br>
                <small class="form-text">
                    <?php echo htmlspecialchars($student_id);?>
                </small>
            </div>
        </div>

        <button id="sidebar-close" class="btn btn-danger" style="display: none;">
            <i class="bi bi-x"></i>
        </button>
        <nav class="nav flex-column">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="#" class="nav-link" data-target="home">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="user-management-toggle" data-target="couse_management">
                        Classroom
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-target="classroom">Grade</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-target="account">Account</a>
                </li>
                <li class="nav-item" role="presentation">
                    <form method="POST" action="dbconnect.php">
                        <button class="btn btn-primary" id="logout-tab" type="submit" name="logoutbtn" role="tab" aria-selected="false">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="">
            <div id="content" >
                <div id="home" class="content-section active">
                    <div class="container mt-2" style="border-radius: 10px;">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-12">
                                <?php
                                    $rows = $conn->query("SELECT * FROM post ORDER BY id DESC");
                                    if ($rows->num_rows > 0) {
                                        while ($row = $rows->fetch_assoc()) {
                                        ?>
                                        <div class="card mb-4">
                                            <div class="">
                                                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel">Edit Post</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="dbconnect.php" method="POST" enctype="multipart/form-data">
                                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                                                    <div class="mb-3">
                                                                        <label for="text_post" class="form-label">Post Text</label>
                                                                        <textarea id="text_post" name="text_post" class="form-control" rows="4"><?php echo htmlspecialchars($row['post']); ?></textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="image" class="form-label">Upload New Image (Optional)</label>
                                                                        <input type="file" name="image" class="form-control" accept="image/*">
                                                                        <?php if (!empty($row['image'])) : ?>
                                                                            <img src="img/<?php echo htmlspecialchars($row['image']); ?>" class="img-fluid mt-2" style="width: 100px;">
                                                                        <?php endif; ?>
                                                                    </div>

                                                                    <button type="submit" class="btn btn-primary" name="update_post">Update Post</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h5 class="mb-0"><?php echo htmlspecialchars($row["poster"]); ?></h5>
                                                    <small class="text-white">
                                                        <?php echo htmlspecialchars($row["post_date"]); ?> at <?php echo htmlspecialchars($row["post_time"]); ?>
                                                    </small>
                                                </div>
                                                <!-- Post content -->
                                                <p class="card-text"><?php echo nl2br(htmlspecialchars($row["post"])); ?></p>

                                                <?php if (!empty($row['image'])) : ?>
                                                    <img src="img/<?php echo htmlspecialchars($row['image']); ?>" 
                                                    class="img-fluid rounded" 
                                                    alt="Post Image">
                                                <?php endif; ?>

                                                <?php if (!empty($row['file'])) : ?>
                                                    <?php 
                                                        $fileExtension = strtolower(pathinfo($row['file'], PATHINFO_EXTENSION));

                                                            // Handle file types
                                                        if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                                            <!-- Display image file -->
                                                            <img src="files/<?php echo htmlspecialchars($row['file']); ?>" 
                                                            class="img-fluid rounded" 
                                                            alt="Uploaded File">
                                                        <?php elseif ($fileExtension === 'pdf'): ?>
                                                            <!-- Display PDF file -->
                                                            <embed src="files/<?php echo htmlspecialchars($row['file']); ?>" 
                                                             type="application/pdf" 
                                                             width="100%" 
                                                             height="500px">
                                                         <?php elseif (in_array($fileExtension, ['docx', 'pptx', 'txt'])): ?>
                                                            <!-- Provide download link for document files -->
                                                            <a href="files/<?php echo htmlspecialchars($row['file']); ?>" 
                                                             class="btn btn-primary" 
                                                             download>
                                                             Download File
                                                         </a>
                                                     <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                     <?php
                                    }
                                    } else {
                                        echo "<p class='text-center'>No posts found.</p>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="couse_management" class="content-section">
                    <?php
                    include "../includes/config.php";

                    // Check if student_id is in the session
                    if (isset($_SESSION['student_id'])) {
                        $student_id = $_SESSION['student_id'];

                        // Query to fetch course IDs, names, and statuses associated with the student
                        $sql = "SELECT e.course_id, c.course_name, e.status, e.id
                                FROM enrollments e
                                JOIN course c ON e.course_id = c.course_id
                                WHERE e.student_id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('i', $student_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $courses = [];
                        $seen_courses = []; // Array to track seen course IDs
                        while ($row = $result->fetch_assoc()) {
                            if (!in_array($row['course_id'], $seen_courses)) {
                                $courses[] = $row;
                                $seen_courses[] = $row['course_id'];
                            }
                        }

                        $stmt->close();
                    } else {
                        echo "No student is logged in.";
                        exit();
                    }
                    ?>

                    <div class="card-container">
                        <?php if (!empty($courses)) : ?>
                            <?php foreach ($courses as $course) : ?>
                                <div class="card mb-3">
                                    <h3><?php echo htmlspecialchars($course['course_name']); ?></h3>
                                    <p><strong>Course ID:</strong> <?php echo htmlspecialchars($course['course_id']); ?></p>

                                    <?php if ($course['status'] == 'Pending') : ?>
                                        <form action="studentconnect.php" method="post">
                                            <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                                            <button type="submit" class="btn btn-primary">Join</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No courses found for this student.</p>
                        <?php endif; ?>
                    </div>

                </div>


                <div id="classroom" class="content-section">
                    <h1>GRADES</h1>
                    <?php
                        if (isset($_SESSION['staff_id'])) {
                            $staff_id = $_SESSION['staff_id'];

                            // Query to fetch courses with "Accepted" status
                            $sql = "SELECT ac.course_id, c.course_name, ac.start_time, ac.end_time, 
                                           COUNT(DISTINCT e.student_id) AS num_students
                                    FROM assigned_course ac
                                    JOIN course c ON ac.course_id = c.course_id
                                    LEFT JOIN enrollments e ON e.course_id = ac.course_id
                                    WHERE ac.faculty_id = ? AND ac.status = 'Accepted'
                                    GROUP BY ac.course_id";

                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param('i', $staff_id);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                echo "<div class='row'>";  // Start the row to display courses

                                while ($row = $result->fetch_assoc()) {
                                    $course_details = "Start Time: " . $row['start_time'] . " | End Time: " . $row['end_time'];

                                    echo "
                                        <div class='col-12 mb-4'>
                                            <div class='card'>
                                                <div class='card-body d-flex justify-content-between align-items-center'>
                                                    <div>
                                                        <h5 class='card-title' data-target='view_classroom'>" . $row['course_id'] . "</h5>
                                                        <p class='card-text'>" . $row['course_name'] . "</p>
                                                        <p class='card-text'>$course_details</p>
                                                        <p class='card-text'><strong>Enrolled Students: " . $row['num_students'] . "</strong></p>
                                                    </div>
                                                    <a href='view_course.php?course_id=" . $row['course_id'] . "&faculty_id=" . $staff_id . "' class='btn btn-primary'>View</a>
                                                </div>
                                            </div>
                                        </div>";

                                }

                                echo "</div>";  // End the row
                            } else {
                                echo "<div class='alert alert-warning'>No accepted courses found for this faculty.</div>";
                            }

                            $stmt->close();
                        } else {
                            echo "<div class='alert alert-danger'>Please log in first.</div>";
                        }
                    ?>
                    
                </div>

                <div id="view_classroom" class="content-section" style="display:none;">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title" id="course_id"></h5>
                            <p class="card-text" id="course_name"></p>
                            <p class="card-text" id="course_details"></p>
                            <p class="card-text"><strong>Enrolled Students: <span id="num_students"></span></strong></p>
                        </div>
                    </div>
                </div>


                <div id="account" class="content-section">
                    <div class="mb-3">
                        <div class="">
                            <div class="card w-100" data-bs-toggle="modal" data-bs-target="#Adminname">
                                <label for="name" class="form-label">Student</label>
                                <input type="text" class="form-control" id="name" name="lastname" value="<?php echo htmlspecialchars($firstname); ?>" disabled>
                                <input type="text" class="form-control" id="name" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" disabled>
                            </div>
                            <div class="card mt-2" data-bs-toggle="modal" data-bs-target="#AdminAccount">
                                <h3>Manage Account</h3>
                                <small>Change your password</small>
                            </div>

                            <div class="modal fade" id="Adminname" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Student</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="studentconnect.php" method="POST">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo htmlspecialchars($student_id); ?>" hidden>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">First Name</label>
                                                        <input type="text" name="firstname" id="name" class="form-control" value="<?php echo htmlspecialchars($firstname); ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Last Name</label>
                                                    <input type="text" name="lastname" id="name" class="form-control" value="<?php echo htmlspecialchars($lastname); ?>">
                                                    </div>                                                    
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="student_update_btn">Save Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="AdminAccount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="dbconnect.php" method="POST">
                                                <div class="mb-3">
                                                    <label class="form-label" id="current_password">Current password</label>
                                                    <input type="password" name="current_password" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" id="current_password">New password</label>
                                                    <input type="password" name="new_password" class="form-control">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" id="current_password">Re-type new password</label>
                                                    <input type="password" name="re_new_password" class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="change_password">Change Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                                    <!--  <div id="help" class="content-section">
                                        <h1>Help Center</h1>
                                        <p>Find answers to your questions here.</p>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const navLinks = document.querySelectorAll('.nav-link, .dropdown-item');
            const contentSections = document.querySelectorAll('.content-section');
            const userManagementToggle = document.getElementById('user-management-toggle');
            const userManagementSubMenu = document.getElementById('user-management-submenu');


            userManagementToggle.addEventListener('click', function () {
                if (userManagementSubMenu.style.display === "flex") {
                    userManagementSubMenu.style.display = "none"; // Hide if already visible
                } else {
                    userManagementSubMenu.style.display = "flex"; // Show if hidden
                }
            });


            sidebarToggle.addEventListener('click', function () {
                sidebar.classList.toggle('active');
                content.classList.toggle('shifted');

                if (sidebar.classList.contains('active')) {
                    sidebarToggle.style.display = 'none';
                    sidebarClose.style.display = 'flex';
                }
            });

            sidebarClose.addEventListener('click', function () {
                sidebar.classList.remove('active');
                content.classList.remove('shifted');

                sidebarToggle.style.display = 'flex';
                sidebarClose.style.display = 'none';
            });

            navLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    contentSections.forEach(section => section.classList.remove('active'));

                    const target = this.getAttribute('data-target');
                    if (target) {
                        document.getElementById(target).classList.add('active');
                    }
                });
            });
        });

    </script>

    <script type="text/javascript">
        function formatDate(date) {
            let year = date.getFullYear();
            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are 0-based
            let day = date.getDate().toString().padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Function to format the time as HH:mm (required for the time input)
        function formatTime(date) {
            let hours = date.getHours().toString().padStart(2, '0');
            let minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        // Get the current date and time
        let currentDateTime = new Date();

        // Set the values of the inputs to the current date and time
        document.getElementById('date').value = formatDate(currentDateTime);
        document.getElementById('time').value = formatTime(currentDateTime);
    </script>

    <script>
        function confirmDelete(postId) {
            // SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "This post will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, proceed to delete the post
                    deletePost(postId);
                }
            });
        }

        function deletePost(postId) {
            // AJAX request to delete the post from the database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_post.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText.trim();
                    if (response == "success") {
                        Swal.fire(
                            'Deleted!',
                            'The post has been deleted.',
                            'success'
                            ).then(() => {
                            window.location.reload(); // Reload the page after deletion
                        });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Something went wrong. Please try again.',
                                'error'
                                );
                        }
                    }
                };
                xhr.send("post_id=" + postId);
            }
        </script>

        <script type="text/javascript">
            document.getElementById("togglefileUpload").addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior
            const imageUploadSection = document.getElementById("fileUploadSection");

            if (imageUploadSection.style.display === "none") {
                imageUploadSection.style.display = "block";
            } else {
                imageUploadSection.style.display = "none";
            }
        });

    </script>

    <script type="text/javascript">
        var enrollModal = document.getElementById('enrollModal');
        enrollModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal

            // Get student ID and name from data attributes
            var studentId = button.getAttribute('data-student-id');
            var studentName = button.getAttribute('data-student-name'); // Use getAttribute for consistency

            // Populate the modal's student ID and name fields
            var studentIdInput = enrollModal.querySelector('#student_id');
            var studentNameInput = enrollModal.querySelector('#student_name');
            studentIdInput.value = studentId;

            // If the name is already provided in the data attribute, use it
            if (studentName) {
                studentNameInput.value = studentName;
            } else {
                // If the name is not available, fetch it from the server
                fetchStudentName(studentId);
            }
        });

        function fetchStudentName(studentId) {
            fetch('get_student_name.php?student_id=' + encodeURIComponent(studentId))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
            // Update the student name input in the modal
                var studentNameInput = document.getElementById('student_name');
                if (data.student_name) {
                    studentNameInput.value = data.student_name;
                } else {
                studentNameInput.value = 'Name not found'; // Fallback message
            }
        })
            .catch(error => console.error('Error fetching student name:', error));
        }

    </script>

    <script type="text/javascript">
        // Event listener for search input
        document.getElementById('course_search').addEventListener('input', function() {
            let searchQuery = this.value.toLowerCase(); // Get the search query and convert to lowercase
            let courseCheckboxes = document.querySelectorAll('.form-check'); // Select all course checkboxes

            // Loop through all courses and hide or show based on the search query
            courseCheckboxes.forEach(function(course) {
                let courseLabel = course.querySelector('.form-check-label'); // Get the course label
                let courseName = courseLabel.textContent.toLowerCase(); // Get course name and convert to lowercase

                // Show or hide based on whether the course name matches the search query
                if (courseName.includes(searchQuery)) {
                    course.style.display = ''; // Show the course
                } else {
                    course.style.display = 'none'; // Hide the course
                }
            });
        });

    </script>

    <script>
        // Function to clone the input fields
        document.getElementById("addButton").addEventListener("click", function() {
            var container = document.getElementById("inputFields");
            
            // Clone the first row of input fields
            var newRow = container.querySelector(".row").cloneNode(true);
            
            // Reset the values in the cloned input fields
            var selects = newRow.querySelectorAll("select");
            var inputs = newRow.querySelectorAll("input");
            
            selects.forEach(function(select) {
                select.value = ''; // Reset the select value
            });
            inputs.forEach(function(input) {
                input.value = ''; // Reset the input value
            });

            // Append the cloned row to the container
            container.appendChild(newRow);
        });
    </script>

    <script type="text/javascript" src="../static/js/script.js"></script>
</body>
</html>
    