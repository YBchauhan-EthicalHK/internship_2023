<?php
// Include the database file to access the functions
require_once "database.php";
require_once "dataconnection.php";

// Check if a request is approved or rejected

// if (isset($_POST["request"]))

if (isset($_POST["process_request"])) {

    $request_id = $_POST["request_id"];
    $status = $_POST["status"];
    if (updateRequestStatus($request_id, $status)) 

    // if (RequestStatus($request, $status)) 

    {
        echo "Request processed successfully.";
    } else {
        echo "Error: Unable to update the request status.";
    }
}

// Get all pending birth certificate requests using the function from database.php
$requests = getPendingRequests();

// Close the database connection (no need to call a function, as we are using mysqli directly)
mysqli_close($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hospital Dashboard</title>
</head>
<body>
    <h1>Hospital Dashboard</h1>
    <h2>Pending Birth Certificate Requests</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Date of Birth</th>
            <th>Address</th>
            <th>Document Path</th>
            <th>Action</th>
        </tr>
        <?php foreach ($requests as $request) : ?>
            <tr>
                <td><?php echo $request['id']; ?></td>
                <td><?php echo $request['full_name']; ?></td>
                <td><?php echo $request['dob']; ?></td>
                <td><?php echo $request['address']; ?></td>
                <td>
                  <img src="<?php echo $request['document_path'];?>" width="100px">
                </td>
                <td>
                    <form action="hospital_dashboard.php" method="post">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <select name="status">
                            <option value="Approved">Approve</option>
                            <option value="Rejected">Reject</option>
                        </select>
                        <input type="submit" name="process_request" value="Process Request">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
