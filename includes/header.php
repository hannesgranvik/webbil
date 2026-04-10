<?php
session_start();
require_once "config.php";
require_once "functions.php";
?>

<!doctype html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Webbil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link href="styles/style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="script/script.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Webbil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    </div>
<?php
  $annonserlista = fetchannons($pdo);
  $bransletyp = $pdo->query('SELECT * FROM bransletyp');
  $karosstyp = $pdo->query('SELECT * FROM karosstyp');
  $drift = $pdo->query('SELECT * FROM drift');
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['annons-submit'])) {
    
    $target_dir = "uploads/";

    $fileName = basename($_FILES["bilder_url"]["name"]); 
    $target_file = $target_dir . $fileName;
    $uploadOk = 1;

    if (!empty($fileName)) {
        if (move_uploaded_file($_FILES["bilder_url"]["tmp_name"], $target_file)) {
            $image_to_save = $fileName;
        } else {
            echo "<div class='alert alert-danger'>Filen kunde inte sparas i mappen.</div>";
            $image_to_save = "default.jpg"; 
        }
    } else {
        $image_to_save = "default.jpg";
    }

$result = insertAd(
        $_POST['fornamn'], $_POST['efternamn'], $_POST['telefon'], 
        $_POST['email'], $_POST['ar_foretag'], $_POST['address'], 
        $_POST['ort'], $_POST['postnummer'], $_POST['marke'], 
        $_POST['modell'], $_POST['arsmodell'], $_POST['medkord'], 
        $_POST['farg'], $_POST['bransletyp'], $_POST['ar_automat'], 
        $_POST['karosstyp'], $_POST['vin'], $_POST['motortyp'], 
        $_POST['hp'], $_POST['antal_dorrar'], $_POST['register_nmr'], 
        $_POST['drift'], $image_to_save, $_POST['pris'], 
        $_POST['ar_aktiv'], $_POST['beskrivning'], $pdo
    );

    if ($result) {
        echo "<div class='alert alert-success'>Annons skapad!</div>";
    } else {
        echo "<div class='alert alert-danger'>Något gick fel.</div>";
    }
}
?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Sälj din bil
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

    <form action="" method="post" enctype="multipart/form-data">

      <div id="owner-form">
        <h5 class="card-title mb-3">Försäljare</h5>

                <div class="mb-3">
                    <label class="form-label">Förnamn</label>
                    <input type="text" class="form-control" name="fornamn" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Efternamn</label>
                    <input type="text" class="form-control" name="efternamn" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Telefon</label>
                    <input type="tel" class="form-control" name="telefon" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-post</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Företag</label>
                    <select class="form-select" name="ar_foretag" required>
                            <option value="0">Nej</option>
                            <option value="1">Jo</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ort</label>
                    <input type="text" class="form-control" name="ort" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Postnummer</label>
                    <input type="text" class="form-control" name="postnummer" required>
                </div>
                <button type="button" onclick="changeModalPage(1)">Nästa sida</button>
</div>

<div id="car-form">
<h5 class="card-title mb-3">Bil</h5>


                <div class="mb-3">
                    <label class="form-label">Märke</label>
                    <input type="text" class="form-control" name="marke" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Modell</label>
                    <input type="text" class="form-control" name="modell" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Årsmodell</label>
                    <input type="number" class="form-control" name="arsmodell" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Medkörd</label>
                    <input type="number" class="form-control" name="medkord" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Färg</label>
                    <input type="text" class="form-control" name="farg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bränsletyp</label>
                    <select class="form-select" name="bransletyp" required>
                        <?php foreach ($bransletyp as $a): ?>
                            <option value="<?php echo $a['bransletyp_id']; ?>"><?php echo $a['bransle_namn']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Växellåda</label>
                    <select class="form-select" name="ar_automat" required>
                            <option value="1">Automat</option>
                            <option value="0">Manual</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Karosstyp</label>
                    <select class="form-select" name="karosstyp" required>
                        <?php foreach ($karosstyp as $a): ?>
                            <option value="<?php echo $a['karosstyp_id']; ?>"><?php echo $a['kaross_namn']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Vin nummer</label>
                    <input type="text" class="form-control" name="vin">
                </div>
                <div class="mb-3">
                    <label class="form-label">Motor storlek</label>
                    <input type="text" class="form-control" name="motortyp">
                </div>
                <div class="mb-3">
                    <label class="form-label">Hästkrafter</label>
                    <input type="number" class="form-control" name="hp">
                </div>
                <div class="mb-3">
                    <label class="form-label">Antal dörrar</label>
                    <input type="number" class="form-control" name="antal_dorrar" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Register nummer</label>
                    <input type="text" class="form-control" name="register_nmr" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Drivkraft</label>
                    <select class="form-select" name="drift" required>
                        <?php foreach ($drift as $a): ?>
                            <option value="<?php echo $a['drift_id']; ?>"><?php echo $a['drift_namn']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="button" onclick="changeModalPage(-1)">Föregående sida</button>
                <button type="button" onclick="changeModalPage(1)">Nästa sida</button>

                        </div>

<div id="ad-form">
                <div class="mb-3">
                    <label class="form-label">Pris</label>
                    <input type="text" class="form-control" name="pris" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Beskrivning</label>
                    <textarea type="text" class="form-control" name="beskrivning"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Bild</label>
                    <input type="file" name="bilder_url" id="bild">
                </div>
                <div class="mb-3">
                    <label class="form-label">Lägg på marknaden direkt</label>
                    <select class="form-select" name="ar_aktiv" required>
                            <option value="1">Jo</option>
                            <option value="0">Nä</option>
                    </select>
                </div>

                <div class="d-grid mt-4">
                    <button type="button" onclick="changeModalPage(-1)">Föregående sida</button>
                    <button type="submit" name="annons-submit" class="btn btn-primary btn-lg">Skapa</button>
                </div>
                        </div>
            </form>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Stäng utan att spara</button>
      </div>
    </div>
  </div>
</div>
</nav>