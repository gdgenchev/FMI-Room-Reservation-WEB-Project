<?php


interface FeatureRepository
{
    function getResources();

    function addFeaturesForRoom($buildingName, $roomNumber, $features);

    function getResourceIconsForRoom($buildingName, $roomNumber);
}