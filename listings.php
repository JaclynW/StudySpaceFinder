<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Spot Finder - Listings</title>
    <link rel="icon" href="assets/icon.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav id="navbar">
        <div id="logo"><a href="index.html">Study Spot Finder</a> > Listings</div>
    </nav>

    <div class="content-container">
        <section id="filter-section">
            <h2>Filter</h2>
            <form id="combined-filters-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div>
                    <h3>Services:</h3>
                    <input type="checkbox" id="wifi" name="wifi" <?php echo isset($_POST['wifi']) ? 'checked' : ''; ?>>
                    <label for="wifi">Wi-Fi</label><br>
                    <input type="checkbox" id="outlets" name="outlets" <?php echo isset($_POST['outlets']) ? 'checked' : ''; ?>>
                    <label for="outlets">Power Outlets</label><br>
                </div>
                <div style="text-align: right;">
                    <button type="submit" style="margin-top: 20px;">Apply Filters</button>
                </div>
            </form>
        </section>

        <section id="results-section">
            <h2>Search Results</h2>
            <?php
            session_start();
            $results = $_SESSION['results'] ?? [];
            $filteredResults = [];

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                foreach ($results as $row) {
                    if (isset($_POST['wifi']) && !$row['wifi']) continue;
                    if (isset($_POST['outlets']) && !$row['outlets']) continue;
                    $filteredResults[] = $row;
                }
            } else {
                $filteredResults = $results;
            }

            foreach ($filteredResults as $row) {
                echo "<div class='listing' onclick='showDetails(\"details{$row['location_id']}\")'>";
                echo "<h3>{$row['location_name']}</h3>";
                echo "<p>Location: {$row['address_1']} {$row['city']}</p>";
                echo "</div>";
                echo "<div id='details{$row['location_id']}' class='details' style='display: none;'>";
                echo "<p>Wi-Fi: " . ($row['wifi'] ? 'Yes' : 'No') . "</p>";
                echo "<p>Power Outlets: " . ($row['outlets'] ? 'Yes' : 'No') . "</p>";
                echo "<p>Opening Hours: {$row['hours']}</p>";
                echo "<a href='{$row['google_maps_link']}' target='_blank'>Get Directions</a> | <a href='#'>Website</a>";
                echo "</div>";
            }
            ?>
        </section>
    </div>

    <footer>
        <p>
            <a href="contact.html">Contact Us</a> | 
            <a href="sitemap.html">Site Map</a> |
            <a href="about.html">About Us</a>
        </p>
    </footer>

    <script>
        function showDetails(id) {
            var details = document.getElementById(id);
            var isVisible = details.style.display === "block";
            details.style.display = isVisible ? "none" : "block";
        }
    </script>

</body>
</html>
