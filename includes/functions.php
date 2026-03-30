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
    print_r($filters);
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
        $query .= " AND (marke LIKE :search OR modell LIKE :search)";
        $params[':search'] = $searchParam . "%";
    }

    // 🚗 Filters
    if (!empty($filters['maxkm'])) {
        $query .= " AND bilar.medkord <= :maxkm";
        $params[':maxkm'] = $filters['maxkm'];
    }

    if (!empty($filters['maxpris'])) {
        $query .= " AND annonser.pris <= :maxpris";
        $params[':maxpris'] = $filters['maxpris'];
    }

    if (!empty($filters['minar'])) {
        $query .= " AND bilar.ar >= :minar";
        $params[':minar'] = $filters['minar'];
    }

    if (!empty($filters['bransletyp']) && $filters['bransletyp'] !== 'alla') {
        $query .= " AND bransletyp.bransletyp = :bransletyp";
        $params[':bransletyp'] = $filters['bransletyp'];
    }

    if (!empty($filters['marke'])) {
        $query .= " AND bilar.marke LIKE :marke";
        $params[':marke'] = $filters['marke'] . "%";
    }

    if (!empty($filters['modell'])) {
        $query .= " AND bilar.modell LIKE :modell";
        $params[':modell'] = $filters['modell'] . "%";
    }

    $stmt = $pdo->prepare($query);
    
    $stmt->execute($params);
print_r($stmt->fetchAll());
    return $stmt->fetchAll();
}
