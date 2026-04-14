<?php
require_once "includes/config.php";
require_once "includes/header.php";
require_once "includes/functions.php";



?>
<?php

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$car = getCarById($pdo, $id);
if ($id === 0) {

    header("Location: index.php");
    exit;
}

if (!$car) {
    echo "Annons hittades inte.";
    exit;
}
?>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-6">
            <img src="uploads/<?= ($car['bilder_url']) ?>" 
                 alt="Bilbild" class="img-fluid">
        </div>
        <div class="col-12 col-md-6">
            <h1><?= ($car['marke']) . " " . ($car['modell']) ?></h1>
            <p><strong>Pris:</strong> <?= ($car['pris']) ?>€</p>
            <p><strong>Körsträcka:</strong> <?= ($car['medkord']) ?> km</p>
            <p><strong>Beskrivning:</strong> <?= ($car['beskrivning']) ?></p>
        </div>
    </div>
</div>


<?php
require_once "includes/footer.php";
?>
