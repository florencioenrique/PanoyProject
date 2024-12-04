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
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include "../includes/head.php";
    ?>
</head>

<body>
    <div class="">
        <div class="header" >
            <div class="cover_photo">
                <img src="../static/images/It_pbg.jpg" alt="Cover Photo">
            </div>
            <div class="profile_info d-flex">
                <img src="../static/images/It_logo.jpg" alt="Profile Picture">
                <div class="text-container">
                    <h1><?php echo htmlspecialchars($admin_name); ?></h1>
                    <small>SAC Information Technology Admin</small>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Information Technology</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="nav nav-tabs" id="adminTabs" role="tablist">
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#dashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">
                                Home
                            </button>
                        </li>
                        <li class="nav-item dropdown" role="presentation">
                            <a class="nav-link dropdown-toggle" id="users-tab" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                User Management
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="users-tab">
                                <button class="nav-link" id="faculty-tab" data-bs-toggle="tab" data-bs-target="#faculty" type="button" role="tab" aria-controls="faculty" aria-selected="false">
                                    Faculty & Staffs
                                </button>
                                <button class="nav-link" id="students-tab" data-bs-toggle="tab" data-bs-target="#students" type="button" role="tab" aria-controls="students" aria-selected="false">
                                    Students
                                </button>
                            </ul>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button" role="tab" aria-controls="reports" aria-selected="false">
                                Courses
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <form method="POST" action="dbconnect.php">
                                <button class="btn btn-primary" id="logout-tab" type="submit" name="logoutbtn" role="tab" aria-selected="false">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="tab-content main_content" id="adminTabsContent">
            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <h3>Dashboard</h3>
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <div class="card p-2">
                            <strong>Intro</strong>
                            <small class="intro">The Project Website of SAC- Bachelor of Science in Information Technology Program</small>

                            <p class="mt-2"><i class="fa-solid fa-circle-info"></i> College & University</p>

                            <p class="mt-2"><i class="fa-solid fa-location-crosshairs"></i> St. Anthony's College, San Jose de Buenavista, Philippines</p>

                            <p class="mt-2"><i class="fa-solid fa-phone"> 0912-3456-789</i></p>

                        </div>
                    </div>
                    <div class="col-md-9">
                        <textarea 
                        placeholder="Post announcement and updates" 
                        class="w-100"
                        data-bs-toggle="modal" 
                        data-bs-target="#announcementModal">
                    </textarea>

                    <!-- Modal for announcement -->
                    <div class="modal fade" id="announcementModal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-center">
                                    <h5 class="modal-title" id="announcementModalLabel">Create Post</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="mb-3">
                                            <label for="announcementContent" class="form-label">Your Announcement</label>
                                            <textarea 
                                            id="announcementContent" 
                                            class="form-control" 
                                            placeholder="Write your announcement here...">
                                        </textarea>
                                        <div class="mb-4" id="imageUploadSection" style="display: none;">
                                            <label for="imageUpload" class="form-label">Upload Image</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-image"></i></span>
                                                <input type="file" id="imageUpload" name="images" class="form-control" accept="image/*">
                                            </div>
                                            <small class="form-text text-muted">Select an image file to upload (JPEG, PNG, etc.).</small>
                                        </div>
                                        <div class="mb-4" id="videoUploadSection" style="display: none;">
                                            <label for="videoUpload" class="form-label">Upload Video</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-solid fa-video"></i></span>
                                                <input type="file" id="videoUpload" name="videos" class="form-control" accept="video/*">
                                            </div>
                                            <small class="form-text text-muted">Select a video file to upload (MP4, AVI, etc.).</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button class="btn" id="toggleImageUpload">
                                            <i class="fa-solid fa-image" id="toggleImageUpload"></i> Picture
                                        </button>
                                        <button class="btn" id="toggleVideoUpload">
                                            <i class="fa-solid fa-video"></i> Videos
                                        </button>
                                    </div>
                                    <button type="button" class="btn btn-primary w-100">Post</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="recent_post">

                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="faculty" role="tabpanel" aria-labelledby="faculty-tab">

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFaculty"><i class="fa-solid fa-user-plus"></i> Add Faculty & Staff</button>

        <!-- Add Faculty Modal -->
        <div class="modal fade" id="addFaculty" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        <h3>Faculty & Staffs</h3>

        <table class="table overflow-auto">
            <thead>
                <tr>
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
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td>
                            <button class="btn">View</button>
                            <button class="btn">Disable</button>
                            <button class="btn" >Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="students" role="tabpanel" aria-labelledby="students-tab">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudent"><i class="fa-solid fa-user-plus"></i>Add New Student</button>
        <!-- Add New Student Modal -->
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

        <table class="table overflow-auto">
            <thead>
                <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Year Level</th>
                    <th scope="col-3">Action</th>
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
                        <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                        <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                        <td><?php echo htmlspecialchars($row['year']); ?></td>
                        <td>
                            <button class="btn">View</button>
                            <button class="btn">Disable</button>
                            <button class="btn" >Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
        <h3>Courses</h3>
        <button class="btn btn-primary" data-bs-toggle="modal"  data-bs-target="#addCourses"><i class="fa-solid fa-plus"></i> Add Courses</button>
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

        <table class="table overflow-auto">
            <thead>
                <tr>
                    <th scope="col">Course ID</th>
                    <th scope="col">Course Name</th>
                    <th scope="col">No. of Students Enrolled</th>
                    <th scope="col-3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include '../includes/config.php';
                $query = "SELECT * FROM course";
                $query_run = mysqli_query($conn, $query);

                if(!$query_run){
                    die("Error: " .mysqli_query($conn));
                }
                while ($row = mysqli_fetch_assoc($query_run)) {

                    $picture = !empty($row['picture']) ? htmlspecialchars($row['picture']) : 'uploads/user.png';
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['course_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                        <td>No data</td>
                        <td>
                            <button class="btn">View</button>
                            <button class="btn">Disable</button>
                            <button class="btn" >Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>  
    </div>

    <!-- Profile Tab -->
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <h3>Profile</h3>
        <div class="mb-3">
            <label for="name" class="form-label">Admin Name</label>
            <div class="d-flex">
                <input type="text" class="form-control" id="name" name="lastname" value="<?php echo htmlspecialchars($admin_name); ?>" disabled>
                <button class="btn" data-bs-toggle="modal"  data-bs-target="#Adminname"><i class="fa-regular fa-pen-to-square"></i></button></div>

                <div class="modal fade" id="Adminname" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="dbconnect.php" method="POST">
                                    <div class="mb-3">
                                        <input type="text" class="form-control" id="name" name="admin_id" value="<?php echo htmlspecialchars($admin_id); ?>" hidden>
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="admin_name" id="name" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="admin_update_btn">Save Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </div>

        <script type="text/javascript" src="../static/js/script.js"></script>
    </body>
    </html>