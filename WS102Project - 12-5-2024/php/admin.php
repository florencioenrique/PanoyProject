<?php require '../includes/config.php'?>

<?php
session_start();

if (!isset($_SESSION['admin_name'])) {
    echo "Admin ID: " . $_SESSION['admin_id'];
    header('Location: index.php');
    exit();
}
$admin_id = $_SESSION['admin_id'];
$admin_name = $_SESSION['admin_name'];

?>

<?php if (isset($_GET['status'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($_GET['status'] == 'success'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Faculty added successfully.',
                    confirmButtonText: 'OK'
                });
            <?php elseif ($_GET['status'] == 'error'): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong. Please try again.',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($_GET['status'] == 'post_success'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Your post has been uploaded',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($_GET['status'] == 'course'): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'New course has been added',
                    confirmButtonText: 'OK'
                });
            <?php endif; ?>
        });
    </script>

<?php endif; ?>

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


    .nav-link {
        color: #000; /* Black text color */
        background-color: transparent;
        transition: background-color 0.3s ease;
    }

    /* Hover state */
    .nav-link:hover {
        background-color: white;
        color: #000;
    }

    /* Active state (CSS for :active) */
    .nav-link:active {
        background-color: white;
        color: #000;
    }

    /* Active state dynamically (CSS class) */
    .nav-link.active {
        background-color: white;
        color: #000;
    }
    #logout-tab {
        width: 100%; /* Make the button full-width (optional) */
    }
    .nav-item.mt-auto {
    margin-top: auto; /* Automatically push this item to the bottom */
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
                <label><?php echo htmlspecialchars($admin_name); ?></label>
                <br>
                <small class="form-text">SAC Information Technology Admin</small>
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
                    <a href="#" class="nav-link" id="user-management-toggle" data-target="student-section">
                        User Management
                    </a>
                    <ul id="user-management-submenu" class="nav flex-column" style="display: none;">
                        <li>
                            <a href="#" class="nav-link" data-target="student-section">Students</a>
                        </li>
                        <li>
                            <a href="#" class="nav-link" data-target="staff-section">Staff</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" data-target="course">Manage Courses</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" data-target="account">Account</a>
                </li>
                <li class="nav-item" role="presentation" style="bottom: -100px;">
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
                    <div class="row justify-content-center ">
                        <div class="col-md-12 card p-3" data-bs-toggle="modal" data-bs-target="#announcementModal">
                            <!-- Input for Announcement -->
                            <input placeholder="Post announcement and updates" class="form-control mb-3" style="height: 70px;" aria-label="Post announcement">
                            <div class="text-center mt-2">
                                <div class="row g-2 align-items-center">
                                    <div class="col-4">
                                        <button class="btn btn-outline-primary w-100">
                                            <i class="fa-solid fa-pen-to-square"></i> Post
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-outline-secondary w-100">
                                            <i class="fa-solid fa-image"></i> Picture
                                        </button>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-outline-success w-100">
                                            <i class="fa-solid fa-file"></i> Files
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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
                                                <!-- Poster name and timestamp -->
                                                <div class="text-end">
                                                    <div class="btn-group" role="group" aria-label="Post Actions">
                                                        <!-- Edit Button -->
                                                        <button class="btn text-white" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">
                                                            <i class="fa-solid fa-pen"></i>
                                                        </button>
                                                        <!-- Delete Button -->
                                                        <form action="dbconnect.php" method="POST" style="display: inline;">
                                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                            <button type="submit" class="btn text-white" name="post_delete">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>

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

                <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h5 class="modal-title" id="announcementModalLabel">Create Post</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="dbconnect.php" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="announcementContent" class="form-label">Your Announcement</label>
                                        <input class="form-control" placeholder="Write your announcement here..." name="text_post">
                                        <div class="mb-4" id="imageUploadSection" style="display: none;">
                                            <label for="imageUpload" class="form-label">Upload Image</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                                                <input type="file" id="imageUpload" name="image" class="form-control" accept="image/*">
                                            </div>
                                            <small class="form-text text-muted">Select an image file to upload (JPEG, PNG, etc.).</small>
                                        </div>
                                        <div class="mb-4" id="fileUploadSection" style="display: none;">
                                            <label for="fileUpload" class="form-label">Upload File</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                                                <input type="file" id="fileUpload" name="file" class="form-control" accept=".pdf,.docx,.pptx,.txt">
                                            </div>
                                            <small class="form-text text-muted">Select a file to upload (PDF, DOCX, PPTX, TXT, etc.).</small>
                                        </div>
                                    </div>

                                    <div class="container text-center">
                                        <div class="row align-items-start">
                                            <div class="col">
                                                <button class="btn" id="toggleImageUpload">
                                                    <i class="fa-solid fa-image" id="toggleImageUpload"></i> Picture
                                                </button>
                                            </div>
                                            <div class="col">
                                                <button class="btn" id="togglefileUpload">
                                                    <i class="fa-solid fa-file"></i> File
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="date" id="date" name="date" hidden>
                                    <input type="time" id="time" name="time" hidden>
                                    <input type="id" id="admin_id" name="admin_id" value="<?php echo htmlspecialchars($admin_id); ?>">
                                    <input type="text" name="poster" value="<?php echo htmlspecialchars($admin_name); ?>" hidden>
                                    <button type="submit" class="btn btn-primary w-100" name="post">Post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <div id="student-section" class="content-section">

                <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addStudent">    <i class="fa-solid fa-user-plus"></i>Add New Student
                </button>

                <div class="modal fade" id="addStudent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="POST" action="dbconnect.php" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="studentNumber" class="form-label">Student Number</label>
                                        <input type="number" class="form-control" id="studentNumber" name="studentNumber">
                                    </div>
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="level" class="form-label">Year</label>
                                        <input type="number" class="form-control" id="level" name="level">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="newStudent">Create</button>
                                </form>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table table-striped table-bordered table-hover align-middle" id="studentTable">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col" >Student Number</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Year Level</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../includes/config.php';
                            $query = "SELECT * FROM student";
                            $query_run = mysqli_query($conn, $query);

                            if(!$query_run){
                                die("Error: " .mysqli_query($conn));
                            }
                            while ($row = mysqli_fetch_assoc($query_run)) {

                                $picture = !empty($row['picture']) ? htmlspecialchars($row['picture']) : 'uploads/user.png';
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['year']); ?></td>
                                    <td>
                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#enrollModal"
                                        data-student-id="<?php echo $row['student_id']; ?>"
                                        data-student-name="<?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname']); ?>">
                                        <i class="fa-solid fa-plus"></i> Enroll
                                        </button>
                                    </td>

                                    <!-- Enroll Modal -->
                                    <div class="modal fade" id="enrollModal" tabindex="-1" aria-labelledby="enrollModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <small class="modal-title" id="enrollModalLabel">Enroll Student</small>
                                                    
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form id="enrollForm" action="dbconnect.php" method="POST">
                                                    <div class="modal-body">
                                                        <!-- Hidden field for student_id -->
                                                        <input id="student_id" name="student_id" hidden>

                                                        <!-- Display Student Info -->
                                                        <!-- <div class="mb-3">
                                                            <label for="student_name" class="form-label">Student Name</label>
                                                            <input type="text" class="form-control" id="student_name" readonly>
                                                        </div> -->

                                                        <!-- Search Bar -->
                                                        <div class="mb-3">
                                                            <label for="course_search" class="form-label">Search Courses</label>
                                                            <input type="text" id="course_search" class="form-control" placeholder="Search for a course">
                                                        </div>

                                                        <!-- Select Course -->
                                                        <div class="mb-3">
                                                            <label for="course_id" class="form-label">Select Course</label>
                                                            <?php
                                                            // Fetch enrolled courses for the specific student
                                                            $student_id = $_GET['student_id'] ?? null; // Replace this with the method you're using to pass the student ID

                                                            $enrolled_courses = [];
                                                            if ($student_id) {
                                                                $enrollment_query = "SELECT course_id FROM enrollment WHERE student_id = '$student_id'";
                                                                $enrollment_result = $conn->query($enrollment_query);

                                                                if ($enrollment_result && $enrollment_result->num_rows > 0) {
                                                                    while ($enrollment_row = $enrollment_result->fetch_assoc()) {
                                                                        $enrolled_courses[] = $enrollment_row['course_id'];
                                                                    }
                                                                }
                                                            }

                                                            // Fetch all courses
                                                            $query = "SELECT * FROM course";
                                                            $result = $conn->query($query);

                                                            if ($result && $result->num_rows > 0) {
                                                                echo '<div id="course-checkboxes">';

                                                                while ($row = $result->fetch_assoc()) {
                                                                    $course_id = $row['course_id'];
                                                                    $course_name = $row['course_name'];

                                                                    // Check if this course is already enrolled
                                                                    $is_checked = in_array($course_id, $enrolled_courses) ? 'checked' : '';

                                                                    echo '<div class="form-check mb-3">';
                                                                    echo '<input type="checkbox" class="form-check-input course-checkbox" name="courses[]" value="' . $course_id . '" id="course_' . $course_id . '" ' . $is_checked . '>';
                                                                    echo '<label class="form-check-label" for="course_' . $course_id . '" style="font-size: 16px; font-weight: 500;">';
                                                                    echo $course_id . ' - ' . $course_name;
                                                                    echo '</label>';
                                                                    echo '</div>';
                                                                }

                                                                echo '</div>';
                                                            } else {
                                                                echo '<p>No courses found.</p>';
                                                            }
                                                            ?>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success" id="enrollSubmit" name="enroll">Enroll</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>             
            </div>

            <div id="staff-section" class="content-section">

                <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addFaculty"><i class="fa-solid fa-user-plus"></i> Add Faculty & Staff</button>

                <!-- Add Faculty Modal -->
                <div class="modal fade" id="addFaculty" tabindex="1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="POST" action="dbconnect.php" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname">
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="newFaculty">Create</button>
                                </form>

                            </div>
                            <div class="modal-footer">

                            </div>
                        </div>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table table-striped table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Faculty ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            include '../includes/config.php';
                            $query = "SELECT * FROM faculty";
                            $query_run = mysqli_query($conn, $query);

                            if(!$query_run){
                                die("Error: " .mysqli_query($conn));
                            }
                            while ($row = mysqli_fetch_assoc($query_run)) {

                                $picture = !empty($row['picture']) ? htmlspecialchars($row['picture']) : 'uploads/user.png';
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['faculty_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                                    <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                                    <td>
                                        <button class="btn" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['faculty_id']; ?>">View</button>

                                        <!-- Modal for Viewing Faculty Details -->
                                        <div class="modal fade" id="viewModal<?php echo $row['faculty_id']; ?>" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel">Faculty Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="dbconnect.php" method="POST" id="subjectForm">
                                                            <input type="text" name="faculty_id" value="<?php echo htmlspecialchars($row['faculty_id']); ?>" hidden>

                                                            <div id="inputFields">
                                                                <div class="mb-3 row">
                                                                    <div class="col-md">
                                                                        <label for="subject" class="form-label">Select Subject</label>
                                                                        <select name="subject_id[]" id="subject" class="form-select" required>
                                                                            <option value="">-- Select Subject --</option>
                                                                            <?php
                                                                                $query = "SELECT course_id, course_name FROM course";
                                                                                $result = $conn->query($query);

                                                                                if ($result && $result->num_rows > 0) {
                                                                                    while ($subject = $result->fetch_assoc()) {
                                                                                        echo '<option value="' . $subject['course_id'] . '">' . htmlspecialchars($subject['course_name']) . '</option>';
                                                                                    }
                                                                                } else {
                                                                                    echo '<option value="">No subjects available</option>';
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="start-time" class="form-label">Start Time</label>
                                                                        <input type="time" class="form-control" name="start-time[]" id="start-time" required>
                                                                    </div>

                                                                    <div class="col-md-3">
                                                                        <label for="end-time" class="form-label">End Time</label>
                                                                        <input type="time" class="form-control" name="end-time[]" id="end-time" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Add button -->
                                                            <button type="button" class="btn btn-primary" id="addButton">Add More</button>

                                                            <!-- Submit button -->
                                                            <button type="submit" class="btn btn-success" name="course_submit">Submit</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
                
            </div>

            <div id="course" class="content-section">

                <button class="btn btn-primary mb-2" data-bs-toggle="modal"  data-bs-target="#addCourses"><i class="fa-solid fa-plus"></i> Add Courses</button>
                <div class="modal fade" id="addCourses" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="dbconnect.php" method="POST">
                                    <div class="mb-3">
                                        <label for="courseId" class="form-label">Course ID</label>
                                        <input type="text" name="course_id" id="courseId" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="courseName" class="form-label">Course Name</label>
                                        <input type="text" name="course_name" id="courseName" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="addCourses">Save Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="table table-striped table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Course ID</th>
                                <th scope="col">Instructor</th>
                                <th scope="col">Enrollies</th>
                                <th scope="col">Time</th>
                                <th scope="col-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                include '../includes/config.php';
                                $query = "SELECT c.course_id, c.course_name, COUNT(DISTINCT e.student_id) AS num_students, 
                                                 f.firstname, f.lastname, ac.start_time, ac.end_time
                                          FROM course c
                                          LEFT JOIN enrollments e ON c.course_id = e.course_id
                                          LEFT JOIN assigned_course ac ON c.course_id = ac.course_id
                                          LEFT JOIN faculty f ON ac.faculty_id = f.faculty_id
                                          GROUP BY c.course_id, f.firstname, f.lastname, ac.start_time, ac.end_time";

                                $query_run = mysqli_query($conn, $query);

                                if (!$query_run) {
                                    die("Error: " . mysqli_error($conn));
                                }

                                while ($row = mysqli_fetch_assoc($query_run)) {

                                    $picture = !empty($row['picture']) ? htmlspecialchars($row['picture']) : 'uploads/user.png';
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['course_id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['firstname']) . " " . htmlspecialchars($row['lastname']); ?></td>
                                        <td><?php echo $row['num_students']; ?></td>
                                        <td><?php echo htmlspecialchars($row['start_time']); ?> - <?php echo htmlspecialchars($row['end_time']); ?></td>
                                        <td>
                                            <button class="btn">View</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div> 

            <div id="account" class="content-section">
                <div class="mb-3">
                    <div class="">
                        <div class="card w-100" data-bs-toggle="modal" data-bs-target="#Adminname">
                            <label for="name" class="form-label">Admin Name</label>
                            <input type="text" class="form-control" id="name" name="lastname" value="<?php echo htmlspecialchars($admin_name); ?>" disabled>
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
                                                <input type="text" class="form-control" id="name" name="admin_id" value="<?php echo htmlspecialchars($admin_id); ?>" hidden>
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" name="admin_name" id="name" class="form-control" value="<?php echo htmlspecialchars($admin_name); ?>">
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="admin_update_btn">Save Update</button>
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
