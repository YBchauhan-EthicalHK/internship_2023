
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index.php</title>
</head>
<body>
    <h1>Birth Certificate Request</h1>
    <form action="request_functions.php" method="post" enctype="multipart/form-data">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" required><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br>

        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea><br>

        <label for="document">Upload Birth Proof:</label>
        <input type="file" id="document" name="document" required><br>

        <input type="submit" name="submit" value="Submit Request">
    </form>
</body>
</html>
