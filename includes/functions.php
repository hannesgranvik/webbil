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

