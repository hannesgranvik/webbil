<?php

function searchCars($pdo, $searchParam){
    $jokerSearch = $searchParam."%";
	$carSearch = $pdo->prepare("SELECT * FROM bilar WHERE marke LIKE :search1 OR modell LIKE :search2");
	$carSearch->bindValue(":search1", $jokerSearch, PDO::PARAM_STR);
	$carSearch->bindValue(":search2", $jokerSearch, PDO::PARAM_STR);
	$carSearch->execute();
	return $carSearch->fetchAll();
}

function fetchAnnons($pdo){
	$stmt = $pdo->prepare("
	SELECT *
	FROM annonser
	INNER JOIN bilar
	ON annonser.bil_id = bilar.bil_id");
	$stmt->execute();
	return $stmt->fetchAll();
}