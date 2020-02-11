<?php
require_once "persistence/feature/FeatureRepository.php";
require_once "persistence/feature/FeatureRepositorySQL.php";
require_once "util/DbConnectionCreator.php";

$conn = DbConnectionCreator::createConnection();

$featureRepository = new FeatureRepositorySQL($conn);
$features = $featureRepository->getResources();
echo (json_encode($features));