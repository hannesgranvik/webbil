<?php
require_once "includes/config.php";
require_once "includes/header.php";
require_once "includes/functions.php";

?>

 <div class="card shadow-sm">
        <div class="card-body p-4">

            <h5 class="card-title mb-3">Kunduppgifter</h5>

            <form action="index.php" method="post">

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

                <hr>
                <h5 class="mb-3">Massagetyp & tid</h5>

                <div class="mb-3">
                    <label class="form-label">Massagetyp</label>
                    <select class="form-select" name="massagetype" required>
                        <?php foreach ($massagetypes as $a): ?>
                            <option value="<?php echo $a['id']; ?>"><?php echo $a['massagetyp']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Datum</label>
                    <input type="date" class="form-control" name="date" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tid</label>
                    <input type="time" class="form-control" name="time" required>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" name="booking-submit" class="btn btn-primary btn-lg">Boka nu</button>
                </div>

            </form>
        </div>
    </div>

<?php
require_once "includes/footer.php";
?>