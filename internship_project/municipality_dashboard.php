<?php
// Include the database file to access the functions
require_once "database.php";

// Check if a request is sent for verification
if (isset($_POST["verify_request"])) {
    $request_id = $_POST["request_id"];
    $status = "Sent for Hospital Verification";
    if (updateRequestStatus($request_id, $status)) {
        echo "Request sent for hospital verification.";
    } else {
        echo "Error: Unable to update the request status.";
    }
}

// Get all birth certificate requests
$requests = getBirthCertificateRequests();
// closeDatabaseConnection();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Municipality Dashboard</title>
</head>

<body>
    <h1>Municipality Dashboard</h1>
    <h2>Birth Certificate Requests</h2>
    <table border="1" width="100%">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Date of Birth</th>
            <th>Address</th>
            <th>Document Path</th>
            <!-- <th>IMAges</th> -->
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($requests as $request) : ?>
            <tr>
                <td><?php echo $request['id']; ?></td>
                <td><?php echo $request['full_name']; ?></td>
                <td><?php echo $request['dob']; ?></td>
                <td><?php echo $request['address']; ?></td>
                <td> 
                    <img src="<?php echo $request['document_path']; ?>" width="200px">
                </td>
                <td><?php echo $request['status']; ?></td>
                <td>
                    <?php if ($request['status'] === "Pending") : ?>
                        <form action="municipality_dashboard.php" method="post">
                            <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                            <input type="submit" name="verify_request" value="Send for Verification">
                        </form>
                    <?php else : ?>
                        <?php echo "No Action Neede"; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>