<?php
require_once "includes/config.php";
require_once "includes/header.php";
require_once "includes/functions.php";

$companyCars = searchCars($pdo, $_GET['car-search'] ?? '', ['ar_foretag' => 1]);
$privateCars = searchCars($pdo, $_GET['car-search'] ?? '', ['ar_foretag' => 0]);

?>

<p>Hejdå</p>

<div class="container" id="search-bar">
  <div class="row">
    <div class="col">
      <form method="GET" action="listings.php" class="d-flex">
        <input class="form-control me-2" name="car-search" type="search" placeholder="Sök bil" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="car-search-submit" id="search-submit">Sök</button>
    </div>
  </div>
</div>

<div class="container" id="filters">
  <div class="row">
    <div class="col-2">
        <input class="form-control me-2" name="filter-marke" id="marke" type="text" placeholder="Märke">
      </div>  
      <div class="col-2">
        <input class="form-control me-2" name="filter-modell" id="modell" type="text" placeholder="Modell">
      </div>
    <div class="col-2">
        <input class="form-control me-2" name="filter-maxkm" id="maxkm" type="number" placeholder="Max km">
      </div> 
      <div class="col-2">
        <input class="form-control me-2" name="filter-maxpris" id="maxpris" type="number" placeholder="Max Price">
      </div>  
      <div class="col-2">
        <input class="form-control me-2" name="filter-minar" id="minar" type="number" placeholder="Min år">
      </div>   
      <div class="col-2">
        <select name="bransletyp" id="bransletyp">
          <option value="0">Bränsletyp</option>
          <option value="1">Bensin</option>
          <option value="2">Diesel</option>
          <option value="3">El</option>
          <option value="4">Hybrid, bensin</option>
          <option value="5">Hybrid, diesel</option>
        </select>
      </div>  
      </form>
    </div>
  </div>
</div>


<div class="container">
  <div class="row">
   <h1 class="annons-header">Nya bilar, företag</h1>
<?php
foreach($companyCars as $annons) :
?>

 <div class="col-4">
<div class="card">
  <img class="card-img-top" src="assets/ford1901something.jpg" alt="">
  <div class="card-body">
    <h5 class="card-title"><?php echo ($annons['marke']) . " " . ($annons['modell'])?></h5>
    <p class="card-text"><?php echo $annons['pris']?>€</p>
    <p class="card-text"><?php echo $annons['medkord']?> km </p>
    <p class="card-text"><?php echo $annons['beskrivning'] ?></p>
    </div>
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

 <div class="col-4">
<div class="card">
  <img class="card-img-top" src="assets/ford1901something.jpg" alt="">
  <div class="card-body">
    <h5 class="card-title"><?php echo ($annons['marke']) . " " . ($annons['modell'])?></h5>
    <p class="card-text"><?php echo $annons['pris']?>€</p>
    <p class="card-text"><?php echo $annons['medkord']?> km </p>
    <p class="card-text"><?php echo substr($annons['beskrivning'], 0, 45) ?></p>
    </div>
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

