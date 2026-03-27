<?php

$annonserlista = $pdo->query('
    SELECT * FROM annonser
    INNER JOIN bilar ON annonser.annons_id = bilar.bil_id
    INNER JOIN försäljare ON annonser.annons_id = försäljare.forsaljar_id
    INNER JOIN bransletyp on bransletyp.bransletyp_id = bilar.bransletyp
    INNER JOIN karosstyp on karosstyp.karosstyp_id = bilar.karosstyp
    INNER JOIN drift on drift.drift_id = bilar.drift
')->fetchAll();

function fetchProjects($pdo, $status){
	$stmt = $pdo->prepare("
	SELECT projekt.fel, projekt.bil_register_nmr, bilar.bil_marke, bilar.bil_modell 
	FROM projekt
	INNER JOIN bilar
	ON projekt.bil_register_nmr = bilar.bil_register_nmr
	WHERE p_status_fk = :status");
	$stmt->bindParam(":status", $status, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchAll();
}

function renderProjects($projectsArray){
	$html = "";	
	foreach( $projectsArray as $row){			
			$html .= <<<HTML
            <div class="card my-3">
                <h5 class="card-header">{$row['bil_marke']} {$row["bil_modell"]}</h5>
                <div class="card-body">
                    <h5 class="card-title">{$row['bil_register_nmr']}</h5>
                    <p class="card-text">{$row['fel']}</p>
                    <a href="#" class="btn btn-primary">Muokkaa</a>
                </div>
            </div>
HTML;
	}
	
	return $html;
	
}

function searchCustomers($pdo, $searchParam){
    $jokerSearch = $searchParam."%";
	//search customers that match input, from database
	$customerSearch = $pdo->prepare("SELECT * FROM kunder WHERE namn LIKE :search1 OR tel LIKE :search2");
	$customerSearch->bindValue(":search1", $jokerSearch, PDO::PARAM_STR);
	$customerSearch->bindValue(":search2", $jokerSearch, PDO::PARAM_STR);
	$customerSearch->execute();
	//return an array of customers
	return $customerSearch->fetchAll();
}

function createCustomer($pdo, $data) {
    try {
        $sql = "INSERT INTO kunder (
            namn,
            efternamn,
            tel,
            epost,
            address,
            postnummer,
            ort
        ) VALUES (
            :namn,
            :efternamn,
            :tel,
            :epost,
            :address,
            :postnummer,
            :ort
        )";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':namn'       => $data['namn'],
            ':efternamn'  => $data['efternamn'],
            ':tel'        => $data['tel'],
            ':epost'      => $data['epost'],
            ':address'    => $data['street'],
            ':postnummer' => $data['postal'],
            ':ort'        => $data['city']
        ]);

        // Returnera succé
        return [
            'success' => true,
            'message' => 'Kunden skapades utan problem.',
            'id' => $pdo->lastInsertId()
        ];

    } catch (PDOException $e) {
        // Returnera felmeddelande
        return [
            'success' => false,
            'message' => 'Fel vid skapande av kund: ' . $e->getMessage()
        ];
    }
}

function updateCustomer($pdo, $data) {
    try {
        $sql = "UPDATE kunder SET
            namn        = :namn,
            efternamn   = :efternamn,
            tel         = :tel,
            epost       = :epost,
            address     = :address,
            postnummer  = :postnummer,
            ort         = :ort
        WHERE kund_id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':namn'       => $data['namn'],
            ':efternamn'  => $data['efternamn'],
            ':tel'        => $data['tel'],
            ':epost'      => $data['epost'],
            ':address'    => $data['street'],
            ':postnummer' => $data['postal'],
            ':ort'        => $data['city'],
            ':id'         => $data['customer_id']  // primary key
        ]);

        return [
            'success' => true,
            'message' => 'Kunduppgifterna uppdaterades utan problem.',
            'id' => $data['customer_id']
        ];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Fel vid uppdatering av kund: ' . $e->getMessage()
        ];
    }
}

function searchCars($pdo, $searchParam){
    $jokerSearch = $searchParam."%";
	//search customers that match input, from database
	$carSearch = $pdo->prepare("SELECT * FROM bilar WHERE bil_register_nmr LIKE :search");
	$carSearch->bindValue(":search", $jokerSearch, PDO::PARAM_STR);
	$carSearch->execute();
	//return an array of customers
	return $carSearch->fetchAll();
}

function updateCar($pdo, $data) {
    try {
        $sql = "UPDATE bilar SET
            bil_marke       = :bil_marke,
            bil_modell       = :bil_modell,
            bil_ar           = :bil_ar
        WHERE bil_register_nmr = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':bil_marke'   => $data['bil_marke'],
            ':bil_modell'   => $data['bil_modell'],
            ':bil_ar'       => $data['bil_ar'],
            ':id'           => $data['car_id']    // primary key
        ]);

        return [
            'success' => true,
            'message' => 'Auton tiedot päivitettiin onnistuneesti.',
            'id' => $data['car_id']
        ];

    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Virhe auton päivityksessä: ' . $e->getMessage()
        ];
    }
}

function createCar($pdo, $data){
    try{
        $stmt = $pdo->prepare("
        INSERT INTO bilar (bil_register_nmr, bil_marke, bil_modell, bil_ar)
        VALUES (:reg, :marke, :modell, :ar)
        ");
        $stmt->execute([
            ':marke'   => $data['bil_marke'],
            ':modell'   => $data['bil_modell'],
            ':ar'       => $data['bil_ar'],
            ':reg'           => $data['bil_register_nmr']    // primary key
        ]);

        return [
            'success' => true,
            'message' => 'Auto luotu onnistuneesti',
            'id' => $pdo->lastInsertId()
        ];
    }

    catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Virhe auton luomisessa: ' . $e->getMessage()
        ];
    }

}

function createProject(PDO $pdo, array $data) {
    try {
        $sql = "INSERT INTO projekt (fel, beställning, bil_register_nmr, kund_id, användar_id, p_status_fk)
                VALUES (:fel, :bestallning, :bil, :kund, :anvandare, :status)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':fel', $data['fel'] ?? null);
        $stmt->bindValue(':bestallning', $data['bestallning'] ?? null);
        $stmt->bindValue(':bil', $data['bil'] ?? null);
        $stmt->bindValue(':kund', $data['kund'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':anvandare', $data['anvandare'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':status', $data['status'] ?? 1, PDO::PARAM_INT); // default "Jonossa"
        $stmt->execute();

        $id = $pdo->lastInsertId();
        return [
            'success' => true,
            'message' => 'Projekt sparat.',
            'id' => $id ?: null
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => 'Databasfel: ' . $e->getMessage()
        ];
    }
}

?>
