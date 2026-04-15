<?php 
require_once "includes/config.php";
require_once "includes/dashboardheader.php";

?>

<div class="container pt-5" id="dahsboard-cont">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="card-title">Sellers</h1>
                    <a href="sellersoverview.php" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="card-title">Cars</h1>
                    <a href="carsoverview.php" class="stretched-link"></a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <h1 class="card-title">Listings</h1>
                    <a href="listingsoverview.php" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once "includes/footer.php";
?>

