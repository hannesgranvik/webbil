<?php
session_start();
require_once "config.php";
require_once "functions.php";
?>

<!doctype html>
<html lang="sv">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Webbil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Webbil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <form method="GET" action="listings.php" class="d-flex">
        <input class="form-control me-2" name="car-search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit" name="car-search-submit">Search</button>
        <label for="maxkm">Max km</label>
        <input class="form-control me-2" name="filter-maxkm" id="maxkm" type="number">
          <label for="maxpris">Max pris</label>
        <input class="form-control me-2" name="filter-maxpris" id="maxpris" type="number">
          <label for="minar">Min år</label>
        <input class="form-control me-2" name="filter-minar" id="minar" type="number">
          <label for="bransletyp">Välj bränsletyp</label>
       <select name="bransletyp" id="bransletyp">
        <option value="alla">Alla</option>
        <option value="bensin">Bensin</option>
        <option value="diesel">Diesel</option>
        <option value="el">El</option>
        <option value="hybrid-b">Hybrid, bensin</option>
        <option value="hybri-d">Hybrid, diesel</option>
      </select>
          <label for="marke">Märke</label>
        <input class="form-control me-2" name="filter-marke" id="marke" type="text">
          <label for="modell">Modell</label>
        <input class="form-control me-2" name="filter-modell" id="modell" type="text">
      </form>
    </div>
  </div>
</nav>