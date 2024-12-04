<?php
    include "../includes/config.php"; 

    session_start(); 

    if (isset($_POST['login'])) {
        // Sanitize and validate the input data
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $sql = "SELECT * FROM student WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the username exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $db_password = $row['password'];

            if ($password == $db_password) {
                $_SESSION['student_id'] = $row['student_id'];
                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['lastname'] = $row['lastname'];


                header('Location: student.php');
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

        // Close the prepared statement
        $stmt->close();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
        $course_id = $_POST['course_id'];
        $student_id = $_SESSION['student_id']; // Retrieve the logged-in student's ID

        // Update query to set the status to 'Accepted'
        $sql = "UPDATE enrollments SET status = 'Accepted' WHERE id = ? AND student_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $course_id, $student_id);

        if ($stmt->execute()) {
            // If the query is successful, redirect back to the page displaying the courses
            header("Location: student.php?status=success");
            exit();
        } else {
            // If the query fails, show an error message
            echo "Error: Could not update status.";
        }

        $stmt->close(); // Close the prepared statement
    } else {
        echo "Invalid request.";
    }

if (isset($_POST['student_update_btn'])) {
    $updated_student_firstname = trim($_POST['firstname']); // Corrected variable name
    $updated_student_lastname = trim($_POST['lastname']);   // Trim spaces for clean data
    $student_id = $_POST['student_id'];

    if (!empty($updated_student_firstname) && !empty($updated_student_lastname)) {
        $stmt = $conn->prepare("UPDATE student SET firstname = ?, lastname = ? WHERE id = ?");
        if (!$stmt) {
            die('Prepare failed: ' . $conn->error); // Graceful error message
        }

        $stmt->bind_param('ssi', $updated_student_firstname, $updated_student_lastname, $student_id);

        if ($stmt->execute()) {
            // Update session data with the new names
            $_SESSION['firstname'] = $updated_student_firstname;
            $_SESSION['lastname'] = $updated_student_lastname;

            header('Location: student.php?update=success'); // Redirect on success
            exit();
        } else {
            // Handle execution error
            die('Execute failed: ' . $stmt->error);
        }

        $stmt->close();
    } else {
        // Redirect or display an error message for empty fields
        header('Location: student.php?update=error&message=Empty fields not allowed');
        exit();
    }
}


?>