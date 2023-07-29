<?php
// Include the database connection file
require_once "database.php";

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user input from the form and sanitize it
    $full_name = sanitizeInput($_POST["full_name"]);
    $dob = sanitizeInput($_POST["dob"]);
    $address = sanitizeInput($_POST["address"]);

    // Handle file upload
    $target_dir = "uploads/";
    $file_name = basename($_FILES["document"]["name"]);
    $target_path = $target_dir . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_path, PATHINFO_EXTENSION));

    // Check if the file is a valid image file (you can customize this for other file types)
    $check = getimagesize($_FILES["document"]["tmp_name"]);
    if ($check === false) {
        echo "Error: File is not an image.";
        $uploadOk = 0;
    }

    // Check if the file already exists
    if (file_exists($target_path)) {
        echo "Error: File already exists.";
        $uploadOk = 0;
    }

    // Check file size (you can customize the file size limit)
    if ($_FILES["document"]["size"] > 5000000) {
        echo "Error: File is too large. Maximum size allowed is 5MB.";
        $uploadOk = 0;
    }

    // Allow only specific image file formats (you can customize this for other file types)
    if ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png") {
        echo "Error: Only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    // If the file is valid, move it to the uploads directory and save the request details to the database
    if ($uploadOk === 1) {
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_path)) {
            // File upload successful, save the request details to the database
            $sql = "INSERT INTO birth_certificate_requests (full_name, dob, address, document_path, status) VALUES (?, ?, ?, ?, 'Pending')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $full_name, $dob, $address, $target_path);
            if ($stmt->execute()) {
                echo "Birth certificate request submitted successfully.";
            } else {
                echo "Error: Unable to save request details to the database.";
            }
            $stmt->close();
        } else {
            echo "Error: Unable to upload the file.";
        }
    }
}

// Close the database connection
// closeDatabaseConnection();
?>
