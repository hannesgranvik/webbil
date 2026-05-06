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
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Märke</th>
          <th>Modell</th>
          <th>Årsmodell</th>
          <th>Bränsletyp</th>
          <th>Är automat?</th>
          <th>Åtgärder</th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($carSearchDB as $car): ?>
        <tr>
          <td><?php echo $car['marke']; ?></td>
          <td><?php echo $car['modell']; ?></td>
          <td><?php echo $car['arsmodell']; ?></td>
          <td><?php echo $car['bransle_namn']; ?></td>
          <td><?php echo $car['ar_automat'] ? "Ja" : "Nej"; ?></td>

          <td class="d-flex gap-2">

            <!-- Edit button -->
            <button type="button" 
                    class="btn btn-outline-primary btn-sm" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal<?php echo $car['bil_id']; ?>">
              Redigera
            </button>

            <!-- Delete -->
            <form method="POST" class="m-0" onsubmit="return confirm('Är du säker på att du vill radera denna bil?');">
              <input type="hidden" name="delete_id" value="<?php echo $car['bil_id']; ?>">
              <button type="submit" name="submitCar_delete" class="btn btn-outline-danger btn-sm">
                Radera
              </button>
            </form>

          </td>
        </tr>

        <!-- Modal (unchanged, just kept as-is) -->
        <div class="modal fade" id="editModal<?php echo $car['bil_id']; ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="">
                <div class="modal-header">
                  <h5 class="modal-title">Redigera Bil</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-start">
                  <input type="hidden" name="id" value="<?php echo $car['bil_id']; ?>">

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Märke</label>
                      <input type="text" name="marke" class="form-control"
                        value="<?php echo htmlspecialchars($car['marke'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">Modell</label>
                      <input type="text" name="modell" class="form-control"
                        value="<?php echo htmlspecialchars($car['modell'] ?? ''); ?>" required>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Årsmodell</label>
                    <input type="number" name="arsmodell" class="form-control"
                      value="<?php echo htmlspecialchars($car['arsmodell'] ?? ''); ?>" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Bränsletyp</label>
                    <input type="text" name="bransletyp" class="form-control"
                      value="<?php echo htmlspecialchars($car['bransletyp'] ?? ''); ?>">
                  </div>

                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <label class="form-label">Är automat</label>
                      <input type="text" name="ar_automat" class="form-control"
                        value="<?php echo htmlspecialchars($car['ar_automat'] ?? ''); ?>">
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

        <?php endforeach; ?>

      </tbody>
    </table>
  </div>
</div>
