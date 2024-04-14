<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/icon.png" type="image/png">
    <link rel="stylesheet" href="css/adminDashboard.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <!-- Navigation bar -->
    <nav id="navbar">
        <div id="logo"><a href="index.html">Study Spot Finder</a></div>
    </nav>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <section id="pendingApprovals">
        <h2>Pending Spot Approvals</h2>
        <ul id="pendingList">
            <?php
            include 'db_connection.php'; // Ensure db_connection.php is set up for database access

            $query = "SELECT * FROM Locations WHERE review_status = 'Pending Approval'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "<p>Spot Name: {$row['location_name']}</p>";
                    echo "<p>Location: {$row['city']}</p>";
                    echo "<button class='editBtn' onclick='editSpot({$row['location_id']})'>Edit</button>";
                    echo "<button class='approveBtn' data-spot-id='{$row['location_id']}'>Approve</button>";
                    echo "<button class='deleteBtn' data-spot-id='{$row['location_id']}'>Delete</button>";
                    echo "</li>";
                }
            } else {
                echo "<li>No pending approvals.</li>";
            }
            ?>
        </ul>
    </section>

    <!-- Edit Spot Modal -->
    <div id="editModal" style="display:none; position:fixed; z-index:1; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.4); padding-top:60px;">
        <div style="background-color:#fefefe; margin:auto; padding:20px; border:1px solid #888; width:80%; max-width:600px;">
            <h2>Edit Study Spot</h2>
            <form id="editForm">
                <!-- Form fields will be filled by JavaScript as shown below -->
                <label for="editName">Study Spot Name:</label>
                <input type="text" id="editName" name="name" required>
                <br>
                <label for="editLocation">Location:</label>
                <br>
                <input type="text" id="editLocation" name="location" required>
                <br>
                <label for="editWifi">Wi-Fi Available:</label>
                <br>
                <select id="editWifi" name="wifi">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <br>
                <label for="editOutlets">Power Outlets Available:</label>
                <br>
                <select id="editOutlets" name="outlets">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
                <br>
                <label for="editHours">Opening Hours:</label>
                <br>
                <input type="text" id="editHours" name="hours">
                <br>
                <label for="editAdditionalInfo">Additional Information:</label>
                <br>
                <textarea id="editAdditionalInfo" name="additionalInfo"></textarea>
                <button type="submit">Save Changes</button>
                <button id="closeButton" onclick="closeEditModal()" style="cursor:pointer;">Close/Cancel</button>
            </form>
        </div>
    </div>

    <footer>
        <p>
            <a href="contact.html">Contact Us</a> |
            <a href="sitemap.html">Site Map</a> |
            <a href="about.html">About Us</a>
        </p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const pendingList = document.getElementById('pendingList');
            pendingList.addEventListener('click', function (event) {
                const spotId = event.target.getAttribute('data-spot-id');
                if (event.target.classList.contains('approveBtn')) {
                    approveSpot(spotId);
                } else if (event.target.classList.contains('editBtn')) {
                    fetchSpotDetails(spotId);
                } else if (event.target.classList.contains('deleteBtn')) {
                    deleteSpot(spotId);
                }
            });
        });

        function fetchSpotDetails(spotId) {
            // Fetch spot details via AJAX and populate the edit form
            console.log('Fetching details for spot ID:', spotId);
            // This would typically involve an AJAX request to get the details and then populating the form
        }

        function approveSpot(spotId) {
            console.log('Approving spot:', spotId);
            // Send AJAX request to server to approve the spot
        }

        function deleteSpot(spotId) {
            console.log('Deleting spot:', spotId);
            // Send AJAX request to server to delete the spot
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('editModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        document.getElementById('editForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the default form submission
            // Collect and send form data to update the database
            const formData = new FormData(document.getElementById('editForm'));
            console.log(Array.from(formData.entries())); // For testing purposes
            // Typically, send an AJAX request here
        });
    </script>
</body>

</html>
