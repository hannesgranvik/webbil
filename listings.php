<?php
require_once "includes/config.php";
$hideHamburger = true;
require_once "includes/header.php";
require_once "includes/functions.php";

$filters = [
    'maxkm' => $_GET['maxkm'] ?? null,
    'minpris' => $_GET['minpris'] ?? null,
    'maxpris' => $_GET['maxpris'] ?? null,
    'marke' => $_GET['marke'] ?? null,
    'modell' => $_GET['modell'] ?? null,
    'minar' => $_GET['minar'] ?? null,
    'maxar' => $_GET['maxar'] ?? null,
    'bransletyp' => $_GET['bransletyp'] ?? null,
    'ar_automat' => $_GET['ar_automat'] ?? null,
    'karosstyp' => $_GET['karosstyp'] ?? null,
    'motortyp' => $_GET['motortyp'] ?? null,
    'hastkrafter' => $_GET['hastkrafter'] ?? null,
    'drift' => $_GET['drift'] ?? null,
    'antal_dorrar' => $_GET['antal_dorrar'] ?? null,
    'farg' => $_GET['farg'] ?? null,
   
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
            <label class="form-label">Min Pris (€)</label>
            <input type="number" name="minpris" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 1000">
        </div>    

        <div class="mb-3">
            <label class="form-label">Max Pris (€)</label>
            <input type="number" name="maxpris" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 10000">
        </div>

        <div class="mb-3">
            <label class="form-label">Max Medkörd (km)</label>
            <input type="number" name="maxkm" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 150000">
        </div>

         <div class="mb-3">
            <label class="form-label">Märke</label>
            <select name="marke" form="search-filter-form" class="form-select bg-white text-dark border-secondary">
                <option value="">Alla märken</option>
                <option value="BMW">BMW</option>
                    <option value="Honda">Honda</option>
                <option value="Toyota">Toyota</option>
                <option value="Volkswagen">Volkswagen</option>
                </select>
        </div>

          <div class="mb-3">
            <label class="form-label">Modell</label>
            <input type="text" name="modell" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. Golf">
        </div>
        
         <div class="mb-3">
            <label class="form-label">Bränsletyp</label>
            <select name="bransletyp" form="search-filter-form" class="form-select bg-white text-dark border-secondary">
                <option value="0">Bränsletyp</option>
                <option value="1">Bensin</option>
                <option value="2">Diesel</option>
                <option value="3">El</option>
                <option value="4">Hybrid, bensin</option>
                <option value="5">Hybrid, diesel</option>
                </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Årsmodell (min)</label>
            <input type="number" name="minar" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 1930">
        </div>

         <div class="mb-3">
            <label class="form-label">Årsmodell (max)</label>
            <input type="number" name="maxar" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 2025">
        </div>

         <div class="mb-3">
            <label class="form-label">Växellåda</label>
            <select name="ar_automat" form="search-filter-form" class="form-select bg-white text-dark border-secondary">
                <option value="">Alla Växellådstyper</option>
                <option value="0">Manual</option>
                <option value="1">Automat</option>
                </select>
        </div>

                <div class="mb-3">
            <label class="form-label">Karosstyp</label>
            <select name="karosstyp" form="search-filter-form" class="form-select bg-white text-dark border-secondary">
                <option value="0">Alla Karosstyper</option>
                <option value="1">Sedan</option>
                <option value="2">Farmare</option>
                <option value="3">Hatchback</option>
                <option value="4">Coupe</option>
                <option value="5">Convertible</option>
                </select>
            </div>

                <div class="mb-3">
            <label class="form-label">Motorvolym</label>
            <input type="" name="motortyp" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 1.2l">
        </div>

          <div class="mb-3">
            <label class="form-label">Hästkrafter</label>
            <input type="number" name="hastkrafter" form="search-filter-form" class="form-control bg-white text-dark border-secondary" placeholder="T.ex. 200">
        </div>

         <div class="mb-3">
            <label class="form-label">Drift</label>
            <select name="drift" form="search-filter-form" class="form-select bg-white text-dark border-secondary">
                <option value="0">Alla drifttyper</option>
                <option value="1">FWD</option>
                <option value="2">RWD</option>
                <option value="3">AWD</option>
                <option value="4">4WD</option>
                </select>
            </div>

         <div class="mb-3">
            <label class="form-label">Antal dörrar</label>
            <select name="antal_dorrar" form="search-filter-form" class="form-select bg-white text-dark border-secondary">
                <option value="0">Alla mängder dörrar</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                </select>
            </div>

            <div class="mb-3">
            <label class="form-label">Färg</label>
            <select name="farg" form="search-filter-form" class="form-select bg-white text-dark border-secondary">
                <option value="0">Alla färger</option>
                <option value="Svart">Svart</option>
                <option value="Vit">Vit</option>
                <option value="Grå">Grå</option>
                <option value="Röd">Röd</option>
                <option value="Blå">Blå</option>
                <option value="Grön">Grön</option>
                <option value="Gul">Gul</option>
                <option value="Orange">Orange</option>
                <option value="Lila">Lila</option>
                <option value="Rosa">Rosa</option>
                </select>
            </div>

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
        
       <label for="filter-toggle" class="btn btn-outline-secondary d-inline-flex align-items-center" id="filter-btn">
    <span>Filter</span>
    <img id="filter-icon" src="img/filter-icon.png" style="width: 18px; margin-left: 10px;">
</label>
    </div>
    <?php if (!empty($annonserlista)): ?>
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