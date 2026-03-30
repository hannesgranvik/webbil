<?php
require_once "includes/config.php";
require_once "includes/header.php";
require_once "includes/functions.php";


$annonserlista = fetchannons($pdo);
$bransletyp = $pdo->query('SELECT * FROM bransletyp');
$karosstyp = $pdo->query('SELECT * FROM karosstyp');
$drift = $pdo->query('SELECT * FROM drift');
?>

 <div class="card shadow-sm">
        <div class="card-body p-4">

            <h5 class="card-title mb-3">Försäljare</h5>

            <form action="#" method="post">

                <div class="mb-3">
                    <label class="form-label">Förnamn</label>
                    <input type="text" class="form-control" name="firstname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Efternamn</label>
                    <input type="text" class="form-control" name="lastname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Telefon</label>
                    <input type="tel" class="form-control" name="phone" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-post</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Företag</label>
                    <select class="form-select" name="ar_automat" required>
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
           


<h5 class="card-title mb-3">Bil</h5>

            <form action="#" method="post">

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
                    <input type="int" class="form-control" name="arsmodell" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Medkörd</label>
                    <input type="text" class="form-control" name="medkord" required>
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
                    <label class="form-label">Pris</label>
                    <input type="text" class="form-control" name="pris" required>
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
                    <label class="form-label">Pris</label>
                    <input type="text" class="form-control" name="pris" required>
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
                    <input type="text" class="form-control" name="hp">
                </div>
                <div class="mb-3">
                    <label class="form-label">Antal dörrar</label>
                    <input type="text" class="form-control" name="antal_dorrar" required>
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


                <div class="d-grid mt-4">
                    <button type="submit" name="annons-submit" class="btn btn-primary btn-lg">Skapa</button>
                </div>

            </form>
        </div>
    </div>

<?php
require_once "includes/footer.php";
?>