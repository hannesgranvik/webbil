<?php
require_once "includes/config.php";
require_once "includes/header.php";
require_once "includes/functions.php";


?>

 <form method="GET" action="listings.php" class="d-flex">
        <input class="form-control me-2" name="car-search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="car-search-submit">Search</button>
        <label for="maxkm">Max km</label>
        <input class="form-control me-2" name="filter-maxkm" id="maxkm" type="number">
          <label for="maxpris">Max pris</label>
        <input class="form-control me-2" name="filter-maxpris" id="maxpris" type="number">
          <label for="minar">Min år</label>
        <input class="form-control me-2" name="filter-minar" id="minar" type="number">
          <label for="bransletyp">Välj bränsletyp</label>
       <select name="bransletyp" id="bransletyp">
        <option value="0">Alla</option>
        <option value="1">Bensin</option>
        <option value="2">Diesel</option>
        <option value="3">El</option>
        <option value="4">Hybrid, bensin</option>
        <option value="5">Hybrid, diesel</option>
      </select>
          <label for="marke">Märke</label>
        <input class="form-control me-2" name="filter-marke" id="marke" type="text">
          <label for="modell">Modell</label>
        <input class="form-control me-2" name="filter-modell" id="modell" type="text">
      </form>


<?php
$fetchannonser = fetchAnnons($pdo);
foreach($fetchannonser as $annons) :
?>


<div class="card" style="width: 18rem;">
  <img class="card-img-top" src="assets/ford1901something.jpg" alt="">
  <div class="card-body">
    <h5 class="card-title"><?php echo ($annons['marke']) . " " . ($annons['modell'])?></h5>
    <p class="card-text"><?php echo $annons['pris']?>€</p>
    <p class="card-text"><?php echo $annons['medkord']?> km </p>
    <p class="card-text"><?php echo $annons['beskrivning'] ?></p>
  </div>
</div>

<?php
	endforeach;

require_once "includes/footer.php";
?>
