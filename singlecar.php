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
        <div class="col-12 col-md-5">
            <img src="uploads/<?= ($car['bilder_url']) ?>" 
                 alt="Bilbild" class="img-fluid">
        </div>
</div>
<div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <h1 class="text-center"><?= ($car['marke']) . " " . ($car['modell']) ?><span style="margin-left: 6rem;"> <?= ($car['pris']) ?>€</span></h1>
            <p><strong>Årsmodell:</strong> <?= ($car['arsmodell']) ?> <span style="margin-left: 1rem;"> <strong>Körsträcka:</strong> <?= ($car['medkord']) ?> km </span> <span style="margin-left: 1rem;"> <strong>Bränsle:</strong> <?= ($car['bransle_namn']) ?> </span>  <span style="margin-left: 1rem;"> <strong>Växellåda:</strong> <?php if ($car['ar_automat'] === 0){echo "Manual";} else {echo "Automat";}?> </span> </p>
            <p><strong>Motortyp:</strong> <?= ($car['motortyp']) ?> <span style="margin-left: 1rem;"> <strong>Drift:</strong> <?= ($car['drift_namn']) ?> </span> <span style="margin-left: 1rem;"> <strong>Bränsle:</strong> <?= ($car['bransle_namn']) ?> </span>  <span style="margin-left: 1rem;"> <strong>Växellåda:</strong> <?php if ($car['ar_automat'] === 0){echo "Manual";} else {echo "Automat";}?> </span> </p>
            
            <p><strong>Beskrivning:</strong> <?= ($car['beskrivning']) ?></p>
        </div>
    </div>
</div>


<?php
require_once "includes/footer.php";
?>
