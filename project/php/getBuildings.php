<?php
require_once "persistence/building/BuildingRepository.php";
require_once "persistence/building/BuildingRepositorySQL.php";

$buildingsRepository = new BuildingRepositorySQL();
$buildingsNames = $buildingsRepository->getBuildingsNames();
echo (json_encode($buildingsNames));
