<?php 
require_once "includes/config.php";
require_once "includes/functions.php";
require_once "includes/dashboardheader.php";

if(isset($_GET["seller-search-input"])){
$searchParam = $_GET["seller-search-input"];
$sellerSearch = searchSellers($pdo, $searchParam);
}

else {
  $sellerSearch = $pdo->query("SELECT * FROM försäljare")->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitSeller_delete'])) {
    if (deleteSeller($pdo, $_POST['delete_id'])) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=deleted"); 
        exit;
    }
}

if (isset($_POST['submitSeller_edit'])) {
    if (updateSeller($pdo, $_POST)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=updated");
        exit();
    }
}

?>

<div class="container pt-5" id="search-bar">
  <div class="row">
    <div class="col">
      <form method="GET" class="d-flex">
        <input class="form-control me-2" name="seller-search-input" type="search" placeholder="Sök efter försäljare" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="seller-search-submit" id="search-submit">Sök</button>
      </form>
    </div>
  </div>
</div>


<div class="container pt-5">
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Namn</th>
          <th>E-post</th>
          <th>Telefon</th>
          <th>Adress</th>
          <th>Ort</th>
          <th>Företag</th>
          <th>Åtgärder</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($sellerSearch as $seller): ?>
        <tr>
          <td><?php echo $seller['fornamn'] . ' ' . $seller['efternamn']; ?></td>
          <td><?php echo $seller['e-post']; ?></td>
          <td><?php echo $seller['telefon']; ?></td>
          <td><?php echo $seller['adress']; ?></td>
          <td><?php echo $seller['ort']; ?></td>
          <td><?php echo $seller['ar_foretag']; ?></td>
          <td class="d-flex gap-2">
            
            <!-- Edit button -->
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $seller['forsaljar_id']; ?>">
              Redigera
            </button>

            <!-- Delete -->
            <form method="POST" class="m-0" onsubmit="return confirm('Är du säker?');">
              <input type="hidden" name="delete_id" value="<?php echo $seller['forsaljar_id']; ?>">
              <button type="submit" name="submitSeller_delete" class="btn btn-outline-danger btn-sm">
                Radera
              </button>
            </form>

          </td>
        </tr>

        <div class="modal fade" id="editModal<?php echo $seller['forsaljar_id']; ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="">
                        <div class="modal-header">
                            <h5 class="modal-title">Redigera Säljare</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <input type="hidden" name="id" value="<?php echo $seller['forsaljar_id']; ?>">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Förnamn</label>
                                    <input type="text" name="fornamn" class="form-control" value="<?php echo htmlspecialchars($seller['fornamn'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Efternamn</label>
                                    <input type="text" name="efternamn" class="form-control" value="<?php echo htmlspecialchars($seller['efternamn'] ?? ''); ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">E-post</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($seller['e-post'] ?? ''); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Telefon</label>
                                <input type="text" name="telefon" class="form-control" value="<?php echo htmlspecialchars($seller['telefon'] ?? ''); ?>">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Adress</label>
                                <input type="text" name="adress" class="form-control" value="<?php echo htmlspecialchars($seller['adress'] ?? ''); ?>">
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Postnr</label>
                                    <input type="text" name="postnummer" class="form-control" value="<?php echo htmlspecialchars($seller['postnummer'] ?? ''); ?>">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Ort</label>
                                    <input type="text" name="ort" class="form-control" value="<?php echo htmlspecialchars($seller['ort'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Avbryt</button>
                            <button type="submit" name="submitSeller_edit" class="btn btn-primary">Spara ändringar</button>
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

    
    
