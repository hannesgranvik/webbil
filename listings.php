<?php
require_once "includes/config.php";
require_once "includes/header.php";
require_once "includes/functions.php";

$filters = [
    'maxkm' => $_GET['filter-maxkm'] ?? null,
    'maxpris' => $_GET['filter-maxpris'] ?? null,
    'minar' => $_GET['filter-minar'] ?? null,
    'bransletyp' => $_GET['bransletyp'] ?? null,
    'marke' => $_GET['filter-marke'] ?? null,
    'modell' => $_GET['filter-modell'] ?? null
];

if(isset($_GET['car-search-submit'])){
  $annonserlista = searchCars($pdo, $_GET['car-search'] ?? '', $filters);
}
?>


<div class="container py-5">
    <h1 class="mb-4">Search results</h1>
    <div class="row g-3">
        <?php foreach ($annonserlista as $row): ?>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                    <h5 class="card-title"><?php echo $row['marke'] . " " . $row['modell'] . " " . $row['motortyp']; ?></h5>
                        <img class="card-img-top" src="img/<?php echo $row['bilder_url']; ?>">
                        <p class="card-text mb-1"><strong>Årsmodell:</strong> <?php echo $row['arsmodell']; ?> <strong>Medkörd:</strong> <?php echo $row['medkord']; ?> <strong>Drivkraft:</strong> <?php echo $row['drift_namn']; ?></p>
                        <p class="card-text mb-1"><strong>Pris:</strong> <?php echo $row['pris'] . "€"; ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
require_once "includes/footer.php";
?>