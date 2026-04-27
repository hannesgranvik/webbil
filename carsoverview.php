<?php 
require_once "includes/config.php";
require_once "includes/functions.php";
require_once "includes/dashboardheader.php";

if(isset($_GET["car-search-input"])){
$searchParam = $_GET["car-search-input"];
$carSearchDB = searchCarsDB($pdo, $searchParam);
}

else {
 $carSearchDB = $pdo->query("SELECT * FROM bilar
JOIN bransletyp ON bilar.bransletyp = bransletyp.bransletyp_id;")->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitCar_delete'])) {
    if (deleteCar($pdo, $_POST['delete_id'])) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=deleted"); 
        exit;
    }
}

if (isset($_POST['submitCar_edit'])) {
    if (updateCar($pdo, $_POST)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=updated");
        exit();
    }
}

?>

<div class="container pt-5" id="search-bar">
  <div class="row">
    <div class="col">
      <form method="GET" class="d-flex">
        <input class="form-control me-2" name="car-search-input" type="search" placeholder="Sök efter bilar" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="car-search-submit" id="search-submit">Sök</button>
      </form>
    </div>
  </div>
</div>


<div class="container pt-5">
    <div class="row pb-2 border-bottom border-secondary mb-3 fw-bold">
        <div class="col">Märke</div>
        <div class="col">Modell</div>
        <div class="col">Årsmodell</div>
        <div class="col">Färg</div>
        <div class="col">Bränsletyp</div>
        <div class="col">Är automat?</div>
        <div class="col">Redigera, radera</div>
    </div>


    <?php foreach ($carSearchDB as $car): ?>
        <div class="row py-2 align-items-center">
            <div class="col text-truncate">
                <?php echo $car['marke']; ?>
            </div>
            <div class="col text-truncate">
                <?php echo $car['modell']; ?>
            </div>
            <div class="col text-truncate">
                <?php echo $car['arsmodell']; ?>
            </div>
            <div class="col text-truncate">
                <?php echo $car['farg']; ?>
            </div>
            <div class="col text-truncate">
                <?php echo $car['bransle_namn']; ?>
            </div>
            <div class="col text-truncate">
                <?php echo $car['ar_automat'] ? "Ja" : "Nej"; ?>
            </div>
           <div class="col-auto d-flex gap-2">
    <button type="button" 
            class="btn btn-outline-primary btn-sm" 
            data-bs-toggle="modal" 
            data-bs-target="#editModal<?php echo $car['bil_id']; ?>">
        Redigera
    </button>

    <div class="modal fade" id="editModal<?php echo $car['bil_id']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title">Redigera Bil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <input type="hidden" name="id" value="<?php echo $car['bil_id']; ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Märke</label>
                            <input type="text" name="marke" class="form-control" value="<?php echo htmlspecialchars($car['marke'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Modell</label>
                            <input type="text" name="modell" class="form-control" value="<?php echo htmlspecialchars($car['modell'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Årsmodell</label>
                        <input type="number" name="arsmodell" class="form-control" value="<?php echo htmlspecialchars($car['arsmodell'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Färg</label>
                        <input type="text" name="farg" class="form-control" value="<?php echo htmlspecialchars($car['farg'] ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bränsletyp</label>
                        <input type="text" name="bransletyp" class="form-control" value="<?php echo htmlspecialchars($car['bransletyp'] ?? ''); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Är automat</label>
                            <input type="text" name="ar_automat" class="form-control" value="<?php echo htmlspecialchars($car['ar_automat'] ?? ''); ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Avbryt</button>
                    <button type="submit" name="submitCar_edit" class="btn btn-primary">Spara ändringar</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <form method="POST" class="m-0" onsubmit="return confirm('Är du säker på att du vill radera denna bil?');">
        <input type="hidden" name="delete_id" value="<?php echo $car['bil_id']; ?>">
        <button type="submit" name="submitCar_delete" class="btn btn-outline-danger btn-sm">
            Radera
        </button>
    </form>
  </div>
        </div>
    <?php endforeach; ?>
</div>

