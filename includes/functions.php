<?php

function fetchannons($pdo){
$annonserlista = $pdo->query('
    SELECT * FROM annonser
    INNER JOIN bilar ON annonser.annons_id = bilar.bil_id
    INNER JOIN försäljare ON annonser.annons_id = försäljare.forsaljar_id
    INNER JOIN bransletyp on bransletyp.bransletyp_id = bilar.bransletyp
    INNER JOIN karosstyp on karosstyp.karosstyp_id = bilar.karosstyp
    INNER JOIN drift on drift.drift_id = bilar.drift
')->fetchAll();
return $annonserlista;
}

function searchCars($pdo, $searchParam){
    $jokerSearch = $searchParam."%";
	$carSearch = $pdo->prepare("SELECT * FROM bilar WHERE marke LIKE :search1 OR modell LIKE :search2");
	$carSearch->bindValue(":search1", $jokerSearch, PDO::PARAM_STR);
	$carSearch->bindValue(":search2", $jokerSearch, PDO::PARAM_STR);
	$carSearch->execute();
	return $carSearch->fetchAll();
}
