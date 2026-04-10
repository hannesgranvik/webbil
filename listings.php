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

<input type="checkbox" id="filter-toggle" class="oc-filter-checkbox">

<label for="filter-toggle" class="oc-menu-overlay"></label>

<aside class="oc-off-canvas-menu bg-light text-dark">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-2">
        <h3 class="h5 mb-0">Filter (off-canvas)</h3>
        <label for="filter-toggle" class="oc-close-btn text-white fs-3" style="cursor: pointer;">&times;</label>
    </div>
    
    <div class="oc-filter-content">
        <div class="mb-3">
            <label class="form-label">Max Pris (€)</label>
            <input type="number" name="filter-maxpris" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 10000">
        </div>

        <div class="mb-3">
            <label class="form-label">Max Medkörd (km)</label>
            <input type="number" name="filter-maxkm" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 150000">
        </div>
        
        <div class="mb-3">
            <label class="form-label">Årsmodell (min)</label>
            <input type="number" name="filter-minar" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 2010">
        </div>

        <div class="mb-3">
            <label class="form-label">Märke</label>
            <select name="filter-marke" form="search-filter-form" class="form-select bg-white text-dark border-secondary">
                <option value="">Alla märken</option>
                <option value="Honda">Honda</option>
                <option value="Toyota">Toyota</option>
                </select>
        </div>

        <button type="submit" name="car-search-submit" form="search-filter-form" class="btn w-100 mt-3" id="oc-filter-btn">Tillämpa filter</button>
    </div>
</aside>

<div class="container" id="search-bar">
  <div class="row">
    <div class="col">
      <form id="search-filter-form" method="GET" action="listings.php" class="d-flex">
        <input class="form-control me-2" name="car-search" type="search" placeholder="Sök bil" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="car-search-submit" id="search-submit">Sök</button>
      </form>
    </div>
  </div>
</div>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Sök resultat</h1>
        
        <label for="filter-toggle" class="btn btn-outline-success mb-0" id="filter-btn" style="cursor: pointer;">
            <span class="">Filter</span><img id="filter-icon" src="img/filter-icon.png">
        </label>
    </div>
    
    <div class="row g-3">
        <?php foreach ($annonserlista as $row): ?>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                    <h5 class="card-title"><?php echo $row['marke'] . " " . $row['modell'] . " " . $row['motortyp']; ?></h5>
                        <img class="card-img-top" src="uploads/<?php echo $row['bilder_url']; ?>" alt="Bilbild">
                        <p class="card-text mb-1"><strong>Årsmodell:</strong> <?php echo $row['arsmodell']; ?> <strong>Medkörd:</strong> <?php echo $row['medkord']; ?> <strong>Drivkraft:</strong> <?php echo $row['drift_namn']; ?></p>
                        <p class="card-text mb-1"><strong>Pris:</strong> <?php echo $row['pris'] . "€"; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Inga bilar hittades.</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once "includes/footer.php";
?>