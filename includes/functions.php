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

function searchCars($pdo, $searchParam){
    $carSearchParam = $searchParam."%";
	$carSearch = $pdo->prepare("SELECT * FROM bilar WHERE marke LIKE :search1 OR modell LIKE :search2");
	$carSearch->bindValue(":search1", $carSearchParam, PDO::PARAM_STR);
	$carSearch->bindValue(":search2", $carSearchParam, PDO::PARAM_STR);
	$carSearch->execute();
	return $carSearch->fetchAll();
}
