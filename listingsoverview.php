<?php 
require_once "includes/config.php";
require_once "includes/functions.php";
require_once "includes/dashboardheader.php";

if(isset($_GET["listing-search-input"])){
$searchParam = $_GET["listing-search-input"];
$listingSearch = searchListing($pdo, $searchParam);
}

else {
 $listingSearch = $pdo->query("SELECT * FROM annonser ;")->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitListing_delete'])) {
    if (deleteListing($pdo, $_POST['delete_id'])) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=deleted"); 
        exit;
    }
}

if (isset($_POST['submitListing_edit'])) {
    if (updateListing($pdo, $_POST)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=updated");
        exit();
    }
}

?>

<div class="container pt-5" id="search-bar">
  <div class="row">
    <div class="col">
      <form method="GET" class="d-flex">
        <input class="form-control me-2" name="listing-search-input" type="search" placeholder="Sök efter annonser" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="listing-search-submit" id="search-submit">Sök</button>
      </form>
    </div>
  </div>
</div>

<div class="container pt-5">
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Annons id</th>
          <th>Publiceringsdatum</th>
          <th>Pris</th>
          <th>Är aktiv?</th>
          <th>Åtgärder</th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($listingSearch as $listing): ?>
        <tr>
          <td><?php echo $listing['annons_id']; ?></td>
          <td><?php echo $listing['publiceringsdatum']; ?></td>
          <td><?php echo $listing['pris']; ?></td>
          <td><?php echo $listing['ar_aktiv'] ? "Ja" : "Nej"; ?></td>

          <td class="d-flex gap-2">

            <!-- Edit -->
            <button type="button" 
                    class="btn btn-outline-primary btn-sm" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal<?php echo $listing['annons_id']; ?>">
              Redigera
            </button>

            <!-- Delete -->
            <form method="POST" class="m-0" onsubmit="return confirm('Är du säker på att du vill radera denna annons?');">
              <input type="hidden" name="delete_id" value="<?php echo $listing['annons_id']; ?>">
              <button type="submit" name="submitListing_delete" class="btn btn-outline-danger btn-sm">
                Radera
              </button>
            </form>

          </td>
        </tr>

        <!-- Modal (unchanged) -->
        <div class="modal fade" id="editModal<?php echo $listing['annons_id']; ?>" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form method="POST" action="">
                <div class="modal-header">
                  <h5 class="modal-title">Redigera annons</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-start">
                  <input type="hidden" name="id" value="<?php echo $listing['annons_id']; ?>">

                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Pris</label>
                      <input type="text" name="pris" class="form-control"
                        value="<?php echo htmlspecialchars($listing['pris'] ?? ''); ?>" required>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">beskrivning</label>
                      <input type="text" name="beskrivning" class="form-control"
                        value="<?php echo htmlspecialchars($listing['beskrivning'] ?? ''); ?>" required>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4 mb-3">
                      <label class="form-label">Är aktiv</label>
                      <input type="text" name="ar_aktiv" class="form-control"
                        value="<?php echo htmlspecialchars($listing['ar_aktiv'] ?? ''); ?>">
                    </div>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Avbryt</button>
                  <button type="submit" name="submitListing_edit" class="btn btn-primary">Spara ändringar</button>
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