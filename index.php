<?php
require_once "includes/config.php";
require_once "includes/header.php";
require_once "includes/functions.php";


?>

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
