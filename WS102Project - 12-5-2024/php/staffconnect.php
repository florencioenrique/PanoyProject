<?php
    include "../includes/config.php"; 

    session_start(); 

    if (isset($_POST['login'])) {
        // Sanitize and validate the input data
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM faculty WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the username exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $db_password = $row['password'];

            if ($password == $db_password) {
                $_SESSION['staff_id'] = $row['faculty_id'];
                $_SESSION['staff_name'] = $row['firstname'] ." ". $row['lastname'];


                header('Location: staff.php');
                exit(); 
            } else {
                // If password is incorrect
                header('Location: index.php?status=error'); 
                exit();
            }
        } else {
            // If username does not exist
            header('Location: index.php?status=error');
            exit();
        }

        $stmt->close();
    }

    if (isset($_POST['accept_course'])) {
        $course_id = $_POST['course_id'];

        // Update the status in the assigned_course table
        $update_sql = "UPDATE assigned_course SET status = 'Accepted' WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param('i', $course_id);

        if ($stmt->execute()) {
            echo "<script>alert('Course status updated to Accepted.'); window.location.href = 'staff.php';</script>";
        } else {
            echo "<script>alert('Error updating course status.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Invalid course ID.');</script>";
    }

    if (isset($_POST['staff_update_btn'])) {
        $updated_admin_name = $_POST['staff_name'];
        $admin_id = $_POST['staff_id'];

        if (!empty($updated_admin_name)) {
            $stmt = $conn->prepare("UPDATE faculty SET firstname = ? WHERE id = ?");
            if (!$stmt) {
                die('Prepare failed: ' . $conn->error);
            }

            $stmt->bind_param('si', $updated_admin_name, $admin_id);
            
            if ($stmt->execute()) {
                $_SESSION['admin_name'] = $updated_admin_name;
                header('Location: staff.php?update=success');
                exit();
            }

            $stmt->close();
        }
    }



    $conn->close();
?>
