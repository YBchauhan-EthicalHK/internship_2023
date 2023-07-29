<?php
// Include the dataconnection.php file to establish the database connection
require_once "dataconnection.php";
require_once "database.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user input from the form and sanitize it
    $full_name = sanitizeInput($_POST["full_name"]);
    $dob = sanitizeInput($_POST["dob"]);
    $address = sanitizeInput($_POST["address"]);

    
    $target_dir = "uploads/";

    //$targat_dir = "./upload";

    $file_name = basename($_FILES["document"]["name"]);

    $target_path = $target_dir . $file_name ;//."jpeg"

    $uploadOk = 1;

    //
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

    
    if ($_FILES["document"]["size"] > 5000000) {
        echo "Error: File is too large. Maximum size allowed is 5MB.";
        $uploadOk = 0;
    }

    // Allow only specific image file formats (you can customize this for other file types)
    if ($imageFileType !== "jpg" && $imageFileType !== "jpeg" && $imageFileType !== "png") 

    // if ($imageFileType == "jpg" && $imagesFileType == "jpeg" && $imageFileType == "png")
    // {
    //     echo "Error : jpeg , Jpg and png not allowed"
        //$uploadOk = 1;
    // }
    {
        echo "Error: Only JPG, JPEG, and PNG files are allowed.";
        $uploadOk = 0;
    }

    // If the file is valid, move it to the uploads directory and save the request details to the database
    if ($uploadOk === 1) {
        if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_path)) {
            // File upload successful, save the request details to the database
            $sql = "INSERT INTO birth_certificate_requests (full_name, dob, address, document_path, status) VALUES (?, ?, ?, ?, 'Pending')";
            $stmt = mysqli_prepare($db, $sql);
            mysqli_stmt_bind_param($stmt, "ssss", $full_name, $dob, $address, $target_path);
            if (mysqli_stmt_execute($stmt)) {
                echo "Birth certificate request submitted successfully.";
            } else {
                echo "Error: Unable to save request details to the database.";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: Unable to upload the file.";
        }
    }
}

// Close the database connection
// closeDatabaseConnection();
?>
