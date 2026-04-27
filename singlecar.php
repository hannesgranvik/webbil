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
    <div class="row justify-content-center py-3">
        <div class="col-12 col-lg-8"> <img src="uploads/<?= ($car['bilder_url']) ?>" 
                 alt="Bilbild" class="img-fluid rounded shadow-sm">
        </div>
    </div>

    <div class="row justify-content-center px-2">
        <div class="col-12 col-md-10 col-lg-8">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <h1 class="display-5 fw-bold mb-2 mb-md-0"><?= ($car['marke'] . " " . $car['modell']) ?></h1>
                <h1><?= ($car['pris']) ?>€</h1>
            </div>

            <div class="row border-bottom pb-2 mb-4 g-3">
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Årsmodell</small>
                    <strong><?= $car['arsmodell'] ?></strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Körsträcka</small>
                    <strong><?= $car['medkord'] ?> km</strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Bränsle</small>
                    <strong><?= $car['bransle_namn'] ?></strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Växellåda</small>
                    <strong><?= $car['ar_automat'] === 0 ? "Manuell" : "Automat" ?></strong>
                </div>
            </div>

            <div class="row border-bottom pb-2 mb-4 g-3">
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Motortyp</small>
                    <strong><?= $car['motortyp'] ?></strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Drift</small>
                    <strong><?= $car['drift_namn'] ?></strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Kaross</small>
                    <strong><?= $car['kaross_namn'] ?></strong>
                </div>
                <div class="col-6 col-md-3">
                    <small class="text-muted d-block">Reg nr</small>
                    <strong><?= $car['register_nmr'] ?></strong>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="fw-bold">Beskrivning</h5>
                <div class="p-3 bg-light rounded border">
                    <?= nl2br(($car['beskrivning'])) ?>
                </div>
            </div>

        <div class="pt-3 border-top d-flex align-items-center">
            <div>
            <p class="text-muted mb-0">Säljare:</p>
            <span class="fs-4 fw-bold"><?= ($car['fornamn'] . " " . $car['efternamn']) ?></span>
            </div>
    
                <button class="btn btn-primary ms-auto">Ta kontakt</button>
        </div>
        </div>
    </div>
</div>


<?php
require_once "includes/footer.php";
?>
