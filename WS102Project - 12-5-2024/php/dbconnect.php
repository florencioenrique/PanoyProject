<?php
    include "../includes/config.php";

    session_start();

    // Log in for admin
    if (isset($_POST['login'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // SQL query to fetch user details
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $db_password = $row['password']; // This should be the hashed password stored in the database

            // Verify the entered password with the hashed password
            if (password_verify($password, $db_password)) {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_id'] = $row['id'];

                header('Location: admin.php');
                exit();
            } else {
                header('Location: index.php');
                header('Location: index.php?status=error');
            }
        } else {
            header('Location: index.php');
            echo "<script>alert('WEW');</script>";
        }
        $stmt->close();
        $conn->close();
    }


    // Adding new faculty
    if (isset($_POST['newFaculty'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $faculty_id = rand();

        $stmt = $conn->prepare("INSERT INTO faculty (faculty_id, firstname, lastname, sex, username, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('ssssss', $faculty_id, $firstname, $lastname, $gender, $email, $password);
        $stmt->execute();

        if ($stmt->error) {
            header('Location: admin.php?status=error');
        } else {
            header('Location: admin.php?status=success');
        }
    }

    if (isset($_POST['newStudent'])) {
        $studentNumber = $_POST['studentNumber'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $gender = $_POST['gender'];
        $level = $_POST['level'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("INSERT INTO student (student_id, firstname, lastname, sex, year, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sssssss',$studentNumber, $firstname, $lastname, $gender, $level, $email, $password);
        $stmt->execute();

        if ($stmt->error) {
            header('Location: admin.php?status=error');
        } else {
            header('Location: admin.php?status=success');
        }
    }

    if (isset($_POST['addCourses'])) {
        $courseId = $_POST['course_id'];
        $courseName = $_POST['course_name'];

        $stmt = $conn->prepare("INSERT INTO course (course_id, course_name) VALUES (?, ?)");
        $stmt->bind_param('ss', $courseId, $courseName);
        $stmt->execute();

        if ($stmt->error) {
            echo "Something went wrong";
        } else {
            header('Location: admin.php?course=success');
            header("Location: admin.php");
        }
    }

    if (isset($_POST['admin_update_btn'])) {
        $updated_admin_name = $_POST['admin_name'];
        $admin_id = $_POST['admin_id'];

        if (!empty($updated_admin_name)) {
            $stmt = $conn->prepare("UPDATE admin SET name = ? WHERE id = ?");
            if (!$stmt) {
                die('Prepare failed: ' . $conn->error);
            }

            $stmt->bind_param('si', $updated_admin_name, $admin_id);
            
            if ($stmt->execute()) {
                $_SESSION['admin_name'] = $updated_admin_name;
                header('Location: admin.php?update=success');
                exit();
            } else {
                die('Execute failed: ' . $stmt->error);
            }

            $stmt->close();
        } else {
            header('Location: admin.php?status=empty');
            exit();
        }
    }

    if (isset($_POST['post'])) {
        // Retrieve form data
        $text_post = $_POST['text_post'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $poster = $_POST['poster'];

        $newImageName = null;
        $newFileName = null;

        // Handle image upload
        if ($_FILES['image']['error'] !== 4) {
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $tmpName = $_FILES['image']['tmp_name'];

            $validImageExtensions = ['jpg', 'jpeg', 'png'];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($imageExtension, $validImageExtensions)) {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Image Extension',
                        text: 'Only JPG, JPEG, or PNG allowed.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            } else if ($fileSize > 1000000) { // Check file size
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'File Size Exceeded',
                        text: 'Image size exceeds 1MB.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            } else {
                $newImageName = uniqid() . '.' . $imageExtension;

                if (!is_dir('img')) {
                    mkdir('img');
                }
                move_uploaded_file($tmpName, 'img/' . $newImageName);
            }
        }

        if ($_FILES['file']['error'] !== 4) { // If a file is uploaded
            $fileName = $_FILES['file']['name'];
            $fileSize = $_FILES['file']['size'];
            $tmpName = $_FILES['file']['tmp_name'];

            $validFileExtensions = ['pdf', 'docx', 'pptx'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $validFileExtensions)) {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid File Extension',
                        text: 'Only PDF, DOCX, or PPTX allowed.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            } else if ($fileSize > 5000000) {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'File Size Exceeded',
                        text: 'File size exceeds 5MB.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            } else {
                // Generate a unique name for the uploaded file
                $newFileName = uniqid() . '.' . $fileExtension;

                if (!is_dir('files')) {
                    mkdir('files');
                }
                move_uploaded_file($tmpName, 'files/' . $newFileName);
            }
        }

        $stmt = $conn->prepare("INSERT INTO post (post, post_date, post_time, poster, image, file) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($newFileName === null) {
            $newFileName = NULL;
        }

        $stmt->bind_param('ssssss', $text_post, $date, $time, $poster, $newImageName, $newFileName);
        $stmt->execute();

        if ($stmt->error) {
            header('Location: admin.php?status=error');
        } else {
            header('Location: admin.php?status=post_success');
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {
        $student_id = $_POST['student_id'];
        $courses = $_POST['courses'];
        $status = "Pending";

        // Validate input
        if (empty($student_id)) {
            echo "Error: Student ID is required.";
            exit;
        }
        if (empty($courses)) {
            echo "Error: At least one course must be selected.";
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO enrollments (student_id, course_id, status) VALUES ( ?, ?, ?)");
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }

        $enroll_date = date('Y-m-d');
        foreach ($courses as $course_id) {
            $stmt->bind_param("iss", $student_id, $course_id, $status);
            if (!$stmt->execute()) {
                echo "Error enrolling course ID $course_id: " . $stmt->error;
            }
        }

        $stmt->close();
        $conn->close();

        header("Location: admin.php");
        exit;
    }

    if (isset($_POST['course_submit'])) {
        // Get the faculty_id from the form
        $faculty_id = $_POST['faculty_id'];

        $subjects = $_POST['subject_id'];
        $status = "Pending";
        $start_times = $_POST['start-time'];
        $end_times = $_POST['end-time'];

        if (!empty($subjects) && !empty($start_times) && !empty($end_times) &&
            count($subjects) === count($start_times) && count($subjects) === count($end_times)) {
            
            foreach ($subjects as $index => $subject_id) {
                $subject_id = mysqli_real_escape_string($conn, $subject_id);
                $start_time = mysqli_real_escape_string($conn, $start_times[$index]);
                $end_time = mysqli_real_escape_string($conn, $end_times[$index]);

                // Prepare the query to insert data into the database
                $query = "INSERT INTO assigned_course (faculty_id, course_id, start_time, end_time, status) 
                          VALUES ('$faculty_id', '$subject_id', '$start_time', '$end_time', '$status')";

                if (mysqli_query($conn, $query)) {
                    header("Location: admin.php");
                } else {
                    echo "Error: " . mysqli_error($conn) . "<br>";
                }
            }
        } else {
            echo "Error: Subjects, start times, or end times do not match or are empty.";
        }
    }

    if (isset($_POST['change_password'])) {
        $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        $re_new_password = mysqli_real_escape_string($conn, $_POST['re_new_password']);

        if (empty($current_password) || empty($new_password) || empty($re_new_password)) {
            echo "Please fill all fields.";
            exit();
        }

        $query = "SELECT password FROM admin WHERE username = 'admin'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $db_password = $row['password'];

            if (!password_verify($current_password, $db_password)) {
                echo "Current password is incorrect.";
                exit();
            }

            if ($new_password !== $re_new_password) {
                echo "New passwords do not match.";
                exit();
            }

            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $update_query = "UPDATE admin SET password = '$hashed_password' WHERE username = 'admin'";

            if (mysqli_query($conn, $update_query)) {
                echo "Password changed successfully!";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "Error fetching admin password.";
        }
    }


    if (isset($_POST['update_post'])) {
        $postId = $_POST['id'];
        $textPost = $_POST['text_post'];

        if ($_FILES['image']['error'] !== 4) {
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $tmpName = $_FILES['image']['tmp_name'];

            $validImageExtensions = ['jpg', 'jpeg', 'png'];
            $imageExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($imageExtension, $validImageExtensions) && $fileSize <= 1000000) {
                $newImageName = uniqid() . '.' . $imageExtension;
                move_uploaded_file($tmpName, 'img/' . $newImageName);

                $stmt = $conn->prepare("UPDATE post SET post = ?, image = ? WHERE id = ?");
                $stmt->bind_param("ssi", $textPost, $newImageName, $postId);
            } else {
                echo "<script>alert('Invalid image or image size exceeds 1MB');</script>";
            }
        } else {
            $stmt = $conn->prepare("UPDATE post SET post = ? WHERE id = ?");
            $stmt->bind_param("si", $textPost, $postId);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Post updated successfully.'); window.location.href = 'admin.php';</script>";
        } else {
            echo "<script>alert('Error updating post.');</script>";
        }
    }    


    if (isset($_POST['post_delete'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM post WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Post deleted successfully.";
        } else {
            echo "Error deleting post: " . $conn->error;
        }
        $stmt->close();

        header("Location: admin.php");
        exit;
    }

    if (isset($_POST['logoutbtn'])) {
        session_unset();

        session_destroy();

        header('Location: index.php');
        exit();
    }
?>
