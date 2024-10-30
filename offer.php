<?php
// offer.php
require 'config/db.php';
require 'components/header.php'; // Include your header here

// Simulate user information (you should replace this with your actual logic)
$first_name = $_POST['first_name'] ?? 'N/A';

$last_name = $_POST['last_name'] ?? 'N/A';
$phone_number = $_POST['phone'] ?? 'N/A';
$mail = $_POST['email'] ?? 'N/A';
$notes = $_POST['note'] ?? 'N/A';
// Retrieve POST data
$category = $_POST['category'] ?? 'N/A';
$service = $_POST['service'] ?? 'N/A';
$category_id = $_POST['category_id'] ?? 'N/A';
$time_of_day = $_POST['time_of_day'] ?? 'N/A';
$duration = isset($_POST['duration']) ? $_POST['duration'] : null;
$date = $_POST['date'] ?? 'N/A';
$flexible_date = $_POST['flexible_date'] ?? 'N/A';
$date_of_submit = date('Y-m-d');

// Database connection
$pdo = Database::getInstance();
try {
    // 1. Get the base price from the 'categories' table
    $stmt = $pdo->prepare("SELECT base_price FROM categorie WHERE nome = :category");
    $stmt->execute(['category' => $category]);
    $base_price = $stmt->fetchColumn();

    if ($base_price === false) {
        throw new Exception("Category not found.");
    }

    // 2. Retrieve tariff values from the 'tariffario' table
    $stmt = $pdo->prepare("SELECT * FROM tariffario WHERE id = 1");
    $stmt->execute();
    $tariffario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tariffario) {
        throw new Exception("Tariffario not found.");
    }

    // 3. Determine the multiplier for the service
    $tariff_service = 1;
    if (isset($tariffario[$service])) {
        $tariff_service = $tariffario[$service];
    } else {
        throw new Exception("Invalid service.");
    }

    // 4. Determine the multiplier for the duration
    $tariff_duration = 1;
    $duration = (int) $duration;

    if (array_key_exists($duration, $tariffario)) {
        $tariff_duration = $tariffario[$duration];
    } elseif (isset($tariffario['Custom'])) {
        $tariff_duration = $duration * $tariffario['Custom'];
    } else {
        throw new Exception("Invalid duration or 'Custom' not found.");
    }

    // 5. Calculate final price
    $final_price = $base_price * $tariff_service * $tariff_duration;

    // 6. Insert data into 'prenotazioni' table
    $stmt = $pdo->prepare("
    INSERT INTO prenotazioni 
    (first_name, last_name, phone, mail, date_of_submit, category_id, service, time_of_day, duration, date, flexible_date, note, price, confirmed) 
    VALUES (:first_name, :last_name, :phone, :mail, :date_of_submit, :category_id, :service, :time_of_day, :duration, :date, :flexible_date, :note, :price, 0)
");
    $stmt->execute([
        ':first_name' => $first_name,
        ':last_name' => $last_name,
        ':phone' => $phone_number,
        ':mail' => $mail,
        ':date_of_submit' => $date_of_submit,
        ':category_id' => $category_id,
        ':service' => $service,
        ':time_of_day' => $time_of_day,
        ':duration' => $duration,
        ':date' => $date,
        ':flexible_date' => $flexible_date == 'on' ? 1 : 0,
        ':note' => $notes,
        ':price' => $final_price
    ]);

    // Get the last inserted ID
    $last_insert_id = $pdo->lastInsertId();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>
<div class="container mt-5">
    <h1 class="text-center text-gradient-custom">Get Your Personalized Offer</h1>

    <!-- Loading Spinner -->
    <div id="loading" class="text-center" style="display: none;">
        <div class="spinner-border text-custom" role="status" style="width: 3rem; height: 3rem;">
            <span class="sr-only">Processing...</span>
        </div>
        <p>Please wait while we calculate your offer...</p>
    </div>

    <!-- Offer Summary -->
    <div id="offer-summary" class="card mt-4" style="display: none;">
        <div class="card-body">
            <h5 class="card-title">Details</h5>
            <table class="table">
                <tbody>
                    <tr>
                        <td><strong>Category:</strong></td>
                        <td><?php echo htmlspecialchars($category); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Service:</strong></td>
                        <td><?php echo htmlspecialchars($service); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Time of Day:</strong></td>
                        <td><?php echo htmlspecialchars($time_of_day); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Duration:</strong></td>
                        <td><?php echo htmlspecialchars($duration); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td><?php echo htmlspecialchars($date); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Flexible Date:</strong></td>
                        <td><?php echo htmlspecialchars($flexible_date == 'on' ? 'Yes' : 'No'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Total Price:</strong></td>
                        <td class="h3 text-gradient-custom">
                            <?php echo htmlspecialchars(number_format($final_price, 2)); ?> AED
                        </td>
                    </tr>
                </tbody>
            </table>
            <a href="confirm.php?id=<?php echo $last_insert_id; ?>"
                class="btn btn-success btn-gradient-custom btn-lg btn-block">Confirm Offer</a>
            <span class="text-success font-weight-bold ml-2 mt-1">** Nothing to pay now</span>
        </div>

    </div>

    <a href="book.php" class="btn bg-transparent text-dark mt-5"><i class="fal fa-chevron-left"></i> Change
        something</a>
</div>

<script>
    // Show the loading spinner and offer summary directly
    document.getElementById('loading').style.display = 'block';

    // Simulate offer display
    setTimeout(function () {
        // Hide the loading spinner
        document.getElementById('loading').style.display = 'none';

        // Show the offer summary
        document.getElementById('offer-summary').style.display = 'block';
    }, 1000); // Simulate a 1-second delay for display
</script>

<?php require 'components/footer.php'; // Include your footer here ?>