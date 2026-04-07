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
        INNER JOIN karosstyp ON karosstyp.karosstyp_id = bilar.karosstyp
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

    // Min Year
    if (isset($filters['minar']) && $filters['minar'] !== '') {
        $query .= " AND bilar.arsmodell >= :minar";
        $params[':minar'] = (int)$filters['minar'];
    }

    // Fuel type
    if (!empty($filters['bransletyp']) && $filters['bransletyp'] !== 'alla') {
        $query .= " AND bransletyp.bransletyp_id = :bransletyp";
        $params[':bransletyp'] = $filters['bransletyp'];
    }

    // Brand
    if (!empty($filters['marke'])) {
        $query .= " AND bilar.marke LIKE :marke";
        $params[':marke'] = $filters['marke'] . "%";
    }

    // Model
    if (!empty($filters['modell'])) {
        $query .= " AND bilar.modell LIKE :modell";
        $params[':modell'] = $filters['modell'] . "%";
    }

     if (array_key_exists('ar_foretag', $filters)) {
        $query .= " AND försäljare.ar_foretag = :ar_foretag";
        $params[':ar_foretag'] = $filters['ar_foretag'];
    }

    $stmt = $pdo->prepare($query);

    $stmt->execute($params);

    // ✅ Fetch ONCE
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}


function insertAd($forNamn, $efterNamn, $tel, $email, $foretag, $address, $ort, $postnummer, $marke, $modell, $arsmodell, $medkord, $farg, $bransletyp, $ar_utomat, $karosstyp, $vin_nummer, $motortyp, $hastkrafter, $antal_dorrar, $register_nmr, $drift, $bilder_url, $pris, $ar_aktiv, $beskrivning, $pdo) {
    try {
        $pdo->beginTransaction();

        $q = $pdo->prepare("INSERT INTO försäljare (fornamn, efternamn, telefon, 'e-post', ar_foretag, 'address', postnummer, ort ) VALUES (:fornamn, :efternamn, :tel, :epost, :ar_foretag, :address, :postnummer, :ort)");
        $q->bindParam(':fornamn', $forNamn, PDO::PARAM_STR);
        $q->bindParam(':efternamn', $efterNamn, PDO::PARAM_STR);
        $q->bindParam(':tel', $tel, PDO::PARAM_STR);
        $q->bindParam(':epost', $email, PDO::PARAM_STR);
        $q->bindParam(':ar_foretag', $foretag, PDO::PARAM_STR);
        $q->bindParam(':address', $address, PDO::PARAM_STR);
        $q->bindParam(':postnummer', $postnummer, PDO::PARAM_STR);
        $q->bindParam(':ort', $ort, PDO::PARAM_STR);
        $q->execute();

        $annons_Id = $pdo->lastInsertId();

        $q = $pdo->prepare("INSERT INTO bilar (marke, modell, arsmodell, medkord, farg, bransletyp, ar_utomat, karosstyp, vin_nummer, motortyp, hastkrafter, antal_dorrar, register_nmr, drift, bilder_url) VALUES (:marke, :modell, :arsmodell, :medkord, :farg, :bransletyp, :ar_utomat, :karosstyp, :vin_nummer, :motortyp, :hastkrafter, :antal_dorrar, :register_nmr, :drift, :bilder_url)");
        $q->bindParam(':marke', $marke, PDO::PARAM_STR);
        $q->bindParam(':modell', $modell, PDO::PARAM_STR);
        $q->bindParam(':arsmodell', $arsmodell, PDO::PARAM_STR);
        $q->bindParam(':medkord', $medkord, PDO::PARAM_INT);
        $q->bindParam(':farg', $farg, PDO::PARAM_INT);
        $q->bindParam(':bransletyp', $bransletyp, PDO::PARAM_INT);
        $q->bindParam(':ar_utomat', $ar_utomat, PDO::PARAM_INT);
        $q->bindParam(':karosstyp', $karosstyp, PDO::PARAM_INT);
        $q->bindParam(':vin_nummer', $vin_nummer, PDO::PARAM_INT);
        $q->bindParam(':motortyp', $motortyp, PDO::PARAM_INT);
        $q->bindParam(':hastkrafter', $hastkrafter, PDO::PARAM_INT);
        $q->bindParam(':antal_dorrar', $antal_dorrar, PDO::PARAM_INT);
        $q->bindParam(':register_nmr', $register_nmr, PDO::PARAM_INT);
        $q->bindParam(':drift', $drift, PDO::PARAM_INT);
        $q->bindParam(':bilder_url', $bilder_url, PDO::PARAM_INT);
        $q->execute();

        $annons_id = $pdo->lastInsertId();

        $q = $pdo->prepare("INSERT INTO annonser (pris, ar_aktiv, beskrivning) VALUES (:pris, :ar_aktiv, :beskrivning)");
        $q->bindParam(':pris', $pris, PDO::PARAM_STR);
        $q->bindParam(':ar_aktiv', $ar_aktiv, PDO::PARAM_STR);
        $q->bindParam(':beskrivning', $beskrivning, PDO::PARAM_STR);
        $q->execute();

        $pdo->commit();
        return true;

    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }
}

