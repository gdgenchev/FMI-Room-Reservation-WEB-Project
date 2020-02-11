<?php


interface FeatureRepository
{
    function getResources();

    function addFeaturesForRoom($buildingName, $roomNumber, $features);
}