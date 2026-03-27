<?php

function fetchAnnons($pdo){
$annonserlista = $pdo->query('
    SELECT * FROM annonser
    INNER JOIN bilar ON annonser.annons_id = bilar.bil_id
    INNER JOIN försäljare ON annonser.forsaljare_id = försäljare.forsaljar_id
    INNER JOIN bransletyp ON bransletyp.bransletyp_id = bilar.bransletyp
    INNER JOIN karosstyp ON karosstyp.karosstyp_id = bilar.karosstyp
    INNER JOIN drift ON drift.drift_id = bilar.drift
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
