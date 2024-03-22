<?php
// Include your database connection file
include "connection.php";

// Fetch content for the front page
$sql = "SELECT * FROM cms WHERE cms_status = 1"; // Assuming active CMS entries only
$result = $conn->query($sql);

// Check if there are any CMS entries available
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Assuming you have fields like cms_title, cms_url, and cms_content in your database
        $title = $row["cms_title"];
        $url = $row["cms_url"];
        $content = $row["cms_content"];

        // Display the content
        echo "<h2><a href='$url'>$title</a></h2>";
        echo "<p>$content</p>";
    }
} else {
    echo "No CMS content available.";
}

// Close the database connection
$conn->close();
