<?php
require_once "includes/config.php";
require_once "includes/header.php";
require_once "includes/functions.php";

$annonserlista = renderads($pdo);
?>

<div class="container py-5">
    <h1 class="mb-4">annonser</h1>
    <div class="row g-3">
        <?php foreach ($annonserlista as $row): ?>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                    <h5 class="card-title"><?php echo $row['marke'] . " " . $row['modell'] . " " . $row['motortyp']; ?></h5>
                        <img src="img/<?php echo $row['bilder_url']; ?>">
                        <p class="card-text mb-1"><strong>Årsmodell:</strong> <?php echo $row['arsmodell']; ?> <strong>Medkörd:</strong> <?php echo $row['medkord']; ?> <strong>Drivkraft:</strong> <?php echo $row['drift_namn']; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once "includes/footer.php";
?>