<?php
require_once "includes/config.php";
require_once "includes/header.php";
require_once "includes/functions.php";

$companyCars = searchCars($pdo, $_GET['car-search'] ?? '', ['ar_foretag' => 1]);
$privateCars = searchCars($pdo, $_GET['car-search'] ?? '', ['ar_foretag' => 0]);

?>



<?php
require_once "includes/footer.php";
?>
