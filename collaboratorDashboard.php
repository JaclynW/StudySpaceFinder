<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/icon.png" type="image/png">
    <link rel="stylesheet" href="css/collaboratorDashboard.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Collaborator Dashboard</title>
</head>
<body>

    <nav id="navbar">
        <div id="logo"><a href="index.html">Study Spot Finder</a></div>
    </nav>

    <header>
        <h1>Collaborator Dashboard</h1>
    </header>

    <div id="collab-container">
        <section id="submitListing">
            <h2 class="collab-h2">Submit a Study Spot</h2>
            <form id="studySpotForm" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="name">Study Spot Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>

                <label for="wifi">Wi-Fi Available:</label>
                <select id="wifi" name="wifi">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>

                <label for="outlets">Power Outlets Available:</label>
                <select id="outlets" name="outlets">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>

                <label for="hours">Opening Hours:</label>
                <input type="text" id="hours" name="hours">

                <label for="additionalInfo">Additional Information:</label>
                <textarea id="additionalInfo" name="additionalInfo"></textarea>

                <button type="submit">Submit</button>
            </form>
        </section>

        <section id="submittedListings">
            <h2 class="collab-h2">Submitted Spots</h2>
            <div id="submissions-list">
                <ul>
                    <?php
                    // Placeholder for server-side code to fetch and display submissions
                    include 'db_connection.php'; // Assume db_connection.php contains the connection setup

                    $query = "SELECT * FROM Locations WHERE review_status = 'Pending Approval'";
                    $result = $conn->query($query);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<li>{$row['location_name']} - <strong>Status: {$row['review_status']}</strong></li>";
                        }
                    } else {
                        echo "<li>No submissions pending.</li>";
                    }
                    ?>
                </ul>
            </div>
        </section>
    </div>

    <footer>
        <p>
            <a href="contact.html">Contact Us</a> | 
            <a href="sitemap.html">Site Map</a> |
            <a href="about.html">About Us</a>
        </p>
    </footer>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connection.php'; // Connection setup

        $name = $_POST['name'];
        $location = $_POST['location'];
        $wifi = $_POST['wifi'];
        $outlets = $_POST['outlets'];
        $hours = $_POST['hours'];
        $additionalInfo = $_POST['additionalInfo'];

        $sql = "INSERT INTO Locations (location_name, address_1, wifi, outlets, hours, description) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiis", $name, $location, $wifi, $outlets, $hours, $additionalInfo);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('Study spot submitted successfully!');</script>";
        } else {
            echo "<script>alert('Error submitting study spot.');</script>";
        }
        $stmt->close();
        $conn->close();
    }
    ?>

</body>
</html>
