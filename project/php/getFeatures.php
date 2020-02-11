<?php
require_once "persistence/resource/FeatureRepository.php";
require_once "persistence/resource/FeatureRepositorySQL.php";

$featureRepository = new FeatureRepositorySQL();
$features = $featureRepository->getResources();
echo (json_encode($features));