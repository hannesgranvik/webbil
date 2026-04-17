<?php

function fetchAnnons($pdo){
$annonserlista = $pdo->query('
    SELECT * FROM annonser
    INNER JOIN bilar ON annonser.bil_id = bilar.bil_id
    INNER JOIN försäljare ON annonser.forsaljare_id = försäljare.forsaljar_id
    INNER JOIN bransletyp on bransletyp.bransletyp_id = bilar.bransletyp
    INNER JOIN karosstyp on karosstyp.karosstyp_id = bilar.karosstyp
    INNER JOIN drift on drift.drift_id = bilar.drift
')->fetchAll();
return $annonserlista;
}

function searchCars($pdo, $searchParam, $filters = []) {

    $query = "SELECT * FROM annonser
        INNER JOIN bilar ON annonser.bil_id = bilar.bil_id
        INNER JOIN försäljare ON annonser.forsaljare_id = försäljare.forsaljar_id
        INNER JOIN bransletyp ON bransletyp.bransletyp_id = bilar.bransletyp
        LEFT JOIN karosstyp ON karosstyp.karosstyp_id = bilar.karosstyp
        INNER JOIN drift ON drift.drift_id = bilar.drift
        WHERE 1=1";
    $params = [];

    // 🔍 Search input
   if (!empty($searchParam)) {
    $query .= " AND (bilar.marke LIKE :search1 OR bilar.modell LIKE :search2)";
    $params[':search1'] = "%" . $searchParam . "%";
    $params[':search2'] = "%" . $searchParam . "%";
}

    // 🚗 Filters

    // Max KM
    if (isset($filters['maxkm']) && $filters['maxkm'] !== '') {
        $query .= " AND bilar.medkord <= :maxkm";
        $params[':maxkm'] = (int)$filters['maxkm'];
    }

    // Max Price
    if (isset($filters['maxpris']) && $filters['maxpris'] !== '') {
        $query .= " AND annonser.pris <= :maxpris";
        $params[':maxpris'] = (int)$filters['maxpris'];
    }

     if (isset($filters['minpris']) && $filters['minpris'] !== '') {
        $query .= " AND annonser.pris >= :minpris";
        $params[':minpris'] = (int)$filters['minpris'];
    }

    // Min Year
    if (isset($filters['minar']) && $filters['minar'] !== '') {
        $query .= " AND bilar.arsmodell >= :minar";
        $params[':minar'] = (int)$filters['minar'];
    }

     if (isset($filters['maxar']) && $filters['maxar'] !== '') {
        $query .= " AND bilar.arsmodell <= :maxar";
        $params[':maxar'] = (int)$filters['maxar'];
    }

    // Fuel type
   if (!empty($filters['bransletyp']) && $filters['bransletyp'] != "0") {
    $query .= " AND bilar.bransletyp = :bransletyp";
    $params[':bransletyp'] = $filters['bransletyp'];
}

if (!empty($filters['karosstyp']) && $filters['karosstyp'] != "0") {
    $query .= " AND bilar.karosstyp = :karosstyp";
    $params[':karosstyp'] = $filters['karosstyp'];
}

if (!empty($filters['drift']) && $filters['drift'] != "0") {
    $query .= " AND bilar.drift = :drift";
    $params[':drift'] = $filters['drift'];
}

if (!empty($filters['antal_dorrar']) && $filters['antal_dorrar'] != "0") {
    $query .= " AND bilar.antal_dorrar = :antal_dorrar";
    $params[':antal_dorrar'] = $filters['antal_dorrar'];
}

if (!empty($filters['farg']) && $filters['farg'] != "0") {
    $query .= " AND bilar.farg = :farg";
    $params[':farg'] = $filters['farg'];
}

    if (!empty($filters['marke'])) {
        $query .= " AND bilar.marke LIKE :marke";
        $params[':marke'] = $filters['marke'] . "%";
    }

    // Model
    if (!empty($filters['modell'])) {
        $query .= " AND bilar.modell LIKE :modell";
        $params[':modell'] = $filters['modell'] . "%";
    }

     if (isset($filters['motortyp']) && $filters['motortyp'] !== '') {
    $query .= " AND bilar.motortyp >= :motortyp";
    $params[':motortyp'] = (float)$filters['motortyp'];
}

 if (isset($filters['hastkrafter']) && $filters['hastkrafter'] !== '') {
    $query .= " AND bilar.hastkrafter >= :hastkrafter";
    $params[':hastkrafter'] = (float)$filters['hastkrafter'];
}

     if (array_key_exists('ar_foretag', $filters)) {
        $query .= " AND försäljare.ar_foretag = :ar_foretag";
        $params[':ar_foretag'] = $filters['ar_foretag'];
    }

     // Use strict inequality '!==' to ensure '0' is treated as a valid value
if (isset($filters['ar_automat']) && $filters['ar_automat'] !== '') {
    $query .= " AND bilar.ar_automat = :ar_automat";
    $params[':ar_automat'] = (int)$filters['ar_automat']; // Cast to int for safety
}

$stmt = $pdo->prepare($query);

// bind filters
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}

$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

return $results;
// how many pages? (temporary hardcode)
$totalPages = 5; // we’ll fix this properly later


}





function insertAd($forNamn, $efterNamn, $tel, $email, $foretag, $address, $ort, $postnummer, $marke, $modell, $arsmodell, $medkord, $farg, $bransletyp, $ar_automat, $karosstyp, $vin_nummer, $motortyp, $hastkrafter, $antal_dorrar, $register_nmr, $drift, $bilder_url, $pris, $ar_aktiv, $beskrivning, $pdo) {

    try {
        $pdo->beginTransaction();

        $q = $pdo->prepare("INSERT INTO försäljare (fornamn, efternamn, telefon, `e-post`, ar_foretag, `address`, postnummer, ort) 
                            VALUES (:fornamn, :efternamn, :tel, :epost, :ar_foretag, :address, :postnummer, :ort)");
        $q->execute([
            ':fornamn' => $forNamn,
            ':efternamn' => $efterNamn,
            ':tel' => $tel,
            ':epost' => $email,
            ':ar_foretag' => $foretag,
            ':address' => $address,
            ':postnummer' => $postnummer,
            ':ort' => $ort
        ]);

        $forsaljare_id = $pdo->lastInsertId();

        $q = $pdo->prepare("INSERT INTO bilar (marke, modell, arsmodell, medkord, farg, bransletyp, ar_automat, karosstyp, vin_nummer, motortyp, hastkrafter, antal_dorrar, register_nmr, drift, bilder_url) 
                            VALUES (:marke, :modell, :arsmodell, :medkord, :farg, :bransletyp, :ar_automat, :karosstyp, :vin_nummer, :motortyp, :hastkrafter, :antal_dorrar, :register_nmr, :drift, :bilder_url)");
        
        $q->bindParam(':marke', $marke, PDO::PARAM_STR);
        $q->bindParam(':modell', $modell, PDO::PARAM_STR);
        $q->bindParam(':arsmodell', $arsmodell, PDO::PARAM_INT);
        $q->bindParam(':medkord', $medkord, PDO::PARAM_INT);
        $q->bindParam(':farg', $farg, PDO::PARAM_STR); // Changed to STR
        $q->bindParam(':bransletyp', $bransletyp, PDO::PARAM_INT);
        $q->bindParam(':ar_automat', $ar_automat, PDO::PARAM_INT);
        $q->bindParam(':karosstyp', $karosstyp, PDO::PARAM_INT);
        $q->bindParam(':vin_nummer', $vin_nummer, PDO::PARAM_STR); // Changed to STR
        $q->bindParam(':motortyp', $motortyp, PDO::PARAM_STR); // Changed to STR
        $q->bindParam(':hastkrafter', $hastkrafter, PDO::PARAM_INT);
        $q->bindParam(':antal_dorrar', $antal_dorrar, PDO::PARAM_INT);
        $q->bindParam(':register_nmr', $register_nmr, PDO::PARAM_STR); // Changed to STR
        $q->bindParam(':drift', $drift, PDO::PARAM_INT);
        $q->bindParam(':bilder_url', $bilder_url, PDO::PARAM_STR); // Changed to STR
        $q->execute();

        $bil_id = $pdo->lastInsertId();

        $q = $pdo->prepare("INSERT INTO annonser (pris, ar_aktiv, beskrivning, bil_id, forsaljare_id) 
                            VALUES (:pris, :ar_aktiv, :beskrivning, :bil_id, :forsaljare_id)");
        $q->execute([
            ':pris' => $pris,
            ':ar_aktiv' => $ar_aktiv,
            ':beskrivning' => $beskrivning,
            ':bil_id' => $bil_id,
            ':forsaljare_id' => $forsaljare_id
        ]);

        $pdo->commit();
        return true;

    } catch (Exception $e) {
        $pdo->rollBack();
echo $e->getMessage();
        error_log($e->getMessage()); 
        return false;
    }
}
/*
function searchSellers($pdo, $searchParam){
    $sql = "SELECT * FROM försäljare WHERE namn LIKE :search1 OR efternamn LIKE :search2 OR adress LIKE :search3"
	$sellerSearch = $pdo->prepare($sql);
	$sellerSearch->bindValue(":search1", $searchParam, PDO::PARAM_STR);
	$sellerSearch->bindValue(":search2", $searchParam, PDO::PARAM_STR);
	$sellerSearch->bindValue(":search2", $searchParam, PDO::PARAM_STR);
	$sellerSearch->execute();

	return $sellerSearch->fetchAll();
     */
function getCarById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM annonser
        INNER JOIN bilar ON annonser.bil_id = bilar.bil_id
        INNER JOIN försäljare ON annonser.forsaljare_id = försäljare.forsaljar_id
        INNER JOIN bransletyp ON bransletyp.bransletyp_id = bilar.bransletyp
        INNER JOIN karosstyp ON karosstyp.karosstyp_id = bilar.karosstyp
        INNER JOIN drift ON drift.drift_id = bilar.drift
        WHERE annonser.annons_id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
