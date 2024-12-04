session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to submit feedback.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST['feedback'];
    $user_id = $_SESSION['user_id'];

    // Insert feedback into the database
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, feedback) VALUES (?, ?)");
    $stmt->execute([$user_id, $feedback]);

    echo "Feedback submitted successfully!";
}
