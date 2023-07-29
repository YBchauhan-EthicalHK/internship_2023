<?php
// Include the dataconnection.php file to establish the database connection
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'birth_certificate';

// Create the database connection
$db = mysqli_connect($servername, $username, $password, $dbname) or die(mysqli_error($db));

// Function to get all birth certificate requests
function getBirthCertificateRequests()
{
    global $db;
    $sql = "SELECT * FROM birth_certificate_requests";

    $result = mysqli_query($db, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return [];

    // return 0;
}

// Function to get birth certificate requests sent by the municipality for verification
function getPendingRequests()
{
    global $db;
    $sql = "SELECT * FROM birth_certificate_requests WHERE status = 'Sent for Hospital Ve'";
    
    $result = mysqli_query($db, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return [];
    
}

// Function to update the request status
function updateRequestStatus($request_id, $status)
{
    global $db;
    $sql = "UPDATE birth_certificate_requests SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $request_id);
    if (mysqli_stmt_execute($stmt)) {
        return true;
    }
    return false;
}
?>
