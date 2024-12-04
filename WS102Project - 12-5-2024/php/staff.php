<?php require '../includes/config.php'?>

<?php
session_start();

if (!isset($_SESSION['staff_name'])) {
    echo "Admin ID: " . $_SESSION['staff_id'];
    header('Location: index.php');
    exit();
}
$staff_id = $_SESSION['staff_id'];
$staff_name = $_SESSION['staff_name'];

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
                <label><?php echo htmlspecialchars($staff_name);?></label>
                <br>
                <small class="form-text">SAC Information Technology Staff</small>
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
                        Course Management
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-target="classroom">Classroom</a>
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
                    <div class="container mt-5">
                        <?php
                            if (isset($_SESSION['staff_id'])) {
                                $staff_id = $_SESSION['staff_id'];

                                $sql = "SELECT ac.id, ac.course_id, c.course_name, ac.start_time, ac.end_time
                                        FROM assigned_course ac
                                        JOIN course c ON ac.course_id = c.course_id
                                        LEFT JOIN enrollments e ON e.course_id = ac.course_id  -- Assuming 'enrollments' stores student enrollments
                                        WHERE ac.faculty_id = ? AND ac.status = 'Pending'
                                        GROUP BY ac.course_id";  // Group by course_id to count the students per course

                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param('i', $staff_id);  // Bind the staff_id parameter
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    echo "<div class='row'>";  // Start a row to display cards

                                    // Fetch and display each course's details
                                    while ($row = $result->fetch_assoc()) {
                                        // Combine the course start and end times in a single variable
                                        $course_details = "Start Time: " . $row['start_time'] . " | End Time: " . $row['end_time'];

                                        // Display the course details in a card
                                        echo "
                                            <div class='col-md-4 mb-4'>
                                                <div class='card'>
                                                    <div class='card-body'>
                                                        <h5  href='' class='card-title'>" . $row['course_id'] . "</h5>
                                                        <p class='card-text'>" . $row['course_name'] . "</p>
                                                        <p class='card-text'>$course_details</p>
                                                        <form method='POST' action='staffconnect.php'>
                                                            <input type='hidden' name='course_id' value='" . $row['id'] . "'>
                                                            <button type='submit' name='accept_course' class='btn btn-primary'>Accept</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>";
                                    }

                                    echo "</div>";  // End the row
                                } else {
                                    echo "<div class='alert alert-warning'>No courses found for this faculty.</div>";
                                }

                                $stmt->close();
                            } else {
                                echo "<div class='alert alert-danger'>Please log in first.</div>";
                            }

                        ?>

                    </div>
                </div>

                <div id="classroom" class="content-section">
                    <table class="table table-striped table-bordered table-hover align-middle" id="studentTable">
    <thead class="table-dark">
        <tr>
            <th scope="col">Student ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Year Level</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include '../includes/config.php';

        // Assuming the faculty_id is stored in the session
        $faculty_id = $_SESSION['staff_id'] ?? null;

        // Check if the faculty_id exists in the session
        if (!$faculty_id) {
            die("Error: Faculty ID is not set in the session.");
        }

        // Query to get all students enrolled in courses assigned to the faculty
        // Use DISTINCT to ensure no duplicate student-course pairs
        $query = "SELECT DISTINCT s.student_id, s.firstname, s.lastname, s.year, c.course_name, c.course_id
                  FROM student s
                  JOIN enrollments e ON s.student_id = e.student_id
                  JOIN course c ON e.course_id = c.course_id
                  JOIN assigned_course ac ON c.course_id = ac.course_id
                  WHERE ac.faculty_id = ?";  // Filter by faculty_id in assigned_course

        // Prepare and execute the query
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $faculty_id);
        $stmt->execute();
        $query_run = $stmt->get_result();

        if (!$query_run) {
            die("Error: " . mysqli_error($conn));
        }

        // Initialize an empty array to hold students by course
        $courses = [];

        // Group students by course_id
        while ($row = mysqli_fetch_assoc($query_run)) {
            $courses[$row['course_id']]['course_name'] = $row['course_name'];
            $courses[$row['course_id']]['students'][] = $row;
        }

        // Loop through courses and display them with students
        foreach ($courses as $course_id => $course_data) {
            echo "<h3>" . htmlspecialchars($course_data['course_name']) . "</h3>";
            echo '<table class="table table-striped table-bordered table-hover align-middle">';
            echo '<thead class="table-dark">
                    <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Year Level</th>
                    </tr>
                  </thead>
                  <tbody>';

            // Loop through the students in the course and display them
            foreach ($course_data['students'] as $student) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($student['student_id']) . "</td>";
                echo "<td>" . htmlspecialchars($student['firstname']) . "</td>";
                echo "<td>" . htmlspecialchars($student['lastname']) . "</td>";
                echo "<td>" . htmlspecialchars($student['year']) . "</td>";
                echo "</tr>";
            }

            echo '</tbody></table>';
        }
        ?>
    </tbody>
</table>

                </div>

                <div id="view_classroom" class="content-section" style="display:none; font-size:;">
                   wew
                </div>


                <div id="account" class="content-section">
                    <div class="mb-3">
                        <div class="">
                            <div class="card w-100" data-bs-toggle="modal" data-bs-target="#Adminname">
                                <label for="name" class="form-label">Admin Name</label>
                                <input type="text" class="form-control" id="name" name="lastname" value="<?php echo htmlspecialchars($staff_name); ?>" disabled>
                            </div>
                            <div class="card mt-2" data-bs-toggle="modal" data-bs-target="#AdminAccount">
                                <h3>Manage Account</h3>
                                <small>Change your password</small>
                            </div>

                            <div class="modal fade" id="Adminname" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Admin Name</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="dbconnect.php" method="POST">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" id="name" name="admin_id" value="<?php echo htmlspecialchars($staff_id); ?>">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" name="admin_name" id="name" class="form-control" value="<?php echo htmlspecialchars($staff_name); ?>">
                                                </div>
                                                <button type="submit" class="btn btn-primary" name="staff_update_btn">Save Update</button>
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

    <!-- Modal Structure -->
<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="courseModalLabel">Course Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalCourseDetails">
        wew
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



    <!-- Bootstrap 5.3.3 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script type="text/javascript">
        function showCourseDetails(course) {
    // Prepare the HTML content to display inside the modal
    const courseDetails = `
        <div class="card">
            <h4>Course ID: ${course.course_id}</h4>
            <p><strong>Course Name:</strong> ${course.course_name}</p>
            <p><strong>Start Time:</strong> ${course.start_time}</p>
            <p><strong>End Time:</strong> ${course.end_time}</p>
            <p><strong>Number of Students:</strong> ${course.num_students}</p>
        </div>
    `;

    // Insert the course details into the modal's body
    const modalCourseDetails = document.getElementById('modalCourseDetails');
    modalCourseDetails.innerHTML = courseDetails;

    // The modal will automatically open due to the data-bs-toggle="modal" attribute in the anchor tag
}

    </script>
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
    