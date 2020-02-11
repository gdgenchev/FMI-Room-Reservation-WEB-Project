<?php
require_once "persistence/building/BuildingRepository.php";
require_once "persistence/building/BuildingRepositorySQL.php";
require_once "util/DbConnectionCreator.php";

$conn = DbConnectionCreator::createConnection();

$buildingsRepository = new BuildingRepositorySQL($conn);
$buildingsNames = $buildingsRepository->getBuildingsNames();
echo (json_encode($buildingsNames));
