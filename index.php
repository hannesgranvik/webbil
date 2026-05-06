<?php
require_once "includes/config.php";
$hideHamburger = true;
require_once "includes/header.php";
require_once "includes/functions.php";

$filters = [
    'marke'      => $_GET['filter-marke'] ?? '',
    'modell'     => $_GET['filter-modell'] ?? '',
    'maxkm'      => $_GET['filter-maxkm'] ?? '',
    'maxpris'    => $_GET['filter-maxpris'] ?? '',
    'minar'      => $_GET['filter-minar'] ?? '',
    'bransletyp' => $_GET['bransletyp'] ?? ''
];

// Merge the user's filters with the business/private requirement
$companyFilters = array_merge($filters, ['ar_foretag' => 1]);
$privateFilters = array_merge($filters, ['ar_foretag' => 0]);

$companyCars = searchCars($pdo, $_GET['car-search'] ?? '', $companyFilters);
$privateCars = searchCars($pdo, $_GET['car-search'] ?? '', $privateFilters);

?>

<div class="container" id="search-bar">
  <div class="row">
    <div class="col">
      <form method="GET" action="listings.php"> <div class="container mt-4" id="search-bar">
        <div class="row">
            <div class="col d-flex">
                <input class="form-control me-2" name="car-search" type="search" placeholder="Sök bil">
                <button class="btn btn-primary" type="submit">Sök</button>
            </div>
        </div>
    </div>

    <div class="container mt-3" id="filters">
        <div class="row">
            <div class="col-12 col-md-2 mb-2">
                <input class="form-control" name="filter-marke" type="text" placeholder="Märke">
            </div>
            <div class="col-12 col-md-2 mb-2">
                <input class="form-control" name="filter-modell" type="text" placeholder="Modell">
            </div>
            <div class="col-12 col-md-2 mb-2">
                <input class="form-control" name="filter-maxkm" type="number" placeholder="Max km">
            </div>
            <div class="col-12 col-md-2 mb-2">
                <input class="form-control" name="filter-maxpris" type="number" placeholder="Max pris">
            </div>
            <div class="col-12 col-md-2 mb-2">
                <input class="form-control" name="filter-minar" type="number" placeholder="Min år">
            </div>
            <div class="col-12 col-md-2 mb-2">
                <select name="bransletyp" class="form-select">
                    <option value="0" selected>Bränsletyp</option>
                    <option value="1">Bensin</option>
                    <option value="2">Diesel</option>
                    <option value="3">El</option>
                    <option value="4">Bensin Hybrid</option>
                    <option value="5">Diesel Hybrid</option>
                </select>
            </div>
        </div>
    </div>
</form>

 
<div class="container">
  <div class="row">
   <h1 class="annons-header">Nya bilar, företag</h1>
<?php
foreach($companyCars as $annons) :
?>

<div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4 d-flex align-items-stretch">
    <div class="card h-100 w-100">
        <a href="singlecar.php?id=<?= $annons['annons_id']?>" class="text-decoration-none text-dark h-100">
            <div class="card-body d-flex flex-column h-100">
                <h5 class="card-title fw-bold"><?php echo $annons['marke'] . " " . $annons['modell']; ?></h5>
                <img class="card-img-top mb-3" src="uploads/<?php echo $annons['bilder_url']; ?>" alt="Bilbild">
                <div class="row g-0 mb-auto">
                    <div class="col-4">
                        <small class="fw-bold d-block">Årsmodell</small>
                        <span><?php echo $annons['arsmodell']; ?></span>
                    </div>
                    <div class="col-4 text-center">
                        <small class="fw-bold d-block">Medkörd</small>
                        <span><?php echo $annons['medkord']; ?> km</span>
                    </div>
                    <div class="col-4 text-end">
                        <small class="fw-bold d-block">Drivkraft</small>
                        <span><?php echo $annons['bransle_namn']; ?></span>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <h4 class="fw-bold mb-0"><?php echo $annons['pris']; ?> €</h4>
                </div>
            </div>
        </a>
    </div>
</div>

<?php
	endforeach;
  ?>
  
  </div>
</div>

<div class="container">
  <div class="row">
   <h1 class="annons-header" >Nya bilar, privatpersoner</h1>
<?php

foreach($privateCars as $annons) :
?>

<div class="col-12 col-sm-6 col-md-6 col-lg-4 mb-4 d-flex align-items-stretch">
    <div class="card h-100 w-100">
        <a href="singlecar.php?id=<?= $annons['annons_id']?>" class="text-decoration-none text-dark h-100">
            <div class="card-body d-flex flex-column h-100">
                <h5 class="card-title fw-bold"><?php echo $annons['marke'] . " " . $annons['modell']; ?></h5>
                <img class="card-img-top mb-3" src="uploads/<?php echo $annons['bilder_url']; ?>" alt="Bilbild">
                <div class="row g-0 mb-auto">
                    <div class="col-4">
                        <small class="fw-bold d-block">Årsmodell</small>
                        <span><?php echo $annons['arsmodell']; ?></span>
                    </div>
                    <div class="col-4 text-center">
                        <small class="fw-bold d-block">Medkörd</small>
                        <span><?php echo $annons['medkord']; ?> km</span>
                    </div>
                    <div class="col-4 text-end">
                        <small class="fw-bold d-block">Drivkraft</small>
                        <span><?php echo $annons['bransle_namn']; ?></span>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <h4 class="fw-bold mb-0"><?php echo $annons['pris']; ?> €</h4>
                </div>
            </div>
        </a>
    </div>
</div>

<?php
	endforeach;
  ?>
  
  </div>
</div>

<?php
require_once "includes/footer.php";
?>

