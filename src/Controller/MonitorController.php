<?php

namespace App\Controller;

use App\Entity\Geolocation;
use App\Entity\Measurement;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonitorController extends AbstractController
{
    #[Route('/monitor', name: 'app_monitor')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $geolocationRepository = $entityManager->getRepository(Geolocation::class);
        $geolocations = $geolocationRepository->findBy(
            array(),
            array('id' => 'DESC'),
            500,
            0
        );

        $stationArray = [];
        foreach ($geolocations as $geolocation) {
            $station = $geolocation->getStation();

            $stationArray[] = [
                "id" => $station->getId(),
                "latitude" => $station->getLatitude(),
                "longitude" => $station->getLongitude(),
                "country_code" => $geolocation->getCountryCode()->getId(),
                "city" => $geolocation->getCity(),
                "country" => $geolocation->getCountry()
            ];
        }

        return $this->render('monitor/index.html.twig', [
            'controller_name' => 'MonitorController',
            'stations' => $stationArray
        ]);
    }

    #[Route('/monitor/{id}', name: 'app_monitor_station')]
    public function station(EntityManagerInterface $entityManager, string $id): Response
    {
        $stationRepository = $entityManager->getRepository(Station::class);
        $station = $stationRepository->find($id);
        
        if(!$station) {
            throw $this->createNotFoundException("No station found for id {$id}");
        }

        $measurementRepository = $entityManager->getRepository(Measurement::class);
        $measurements = $measurementRepository->findBy(array("station" => $station));
        $measurementList = [];

        foreach ($measurements as $measurement) {
            $measurementList[] = [
                "id" => $measurement->getId(),
                "station" => $station->getId(),
                "timestamp" => $measurement->getTimestamp()->format("Y-m-d H:i:s"),
                "temperature" => $measurement->getTemperature(),
                "dew_point" => $measurement->getDewPoint(),
                "station_air_pressure" => $measurement->getStationAirPressure(),
                "sea_level_air_pressure" => $measurement->getSeaLevelAirPressure(),
                "wind_speed" => $measurement->getWindSpeed(),
                "precipitation" => $measurement->getPrecipitation(),
                "snow_depth" => $measurement->getSnowDepth(),
                "FRSHTT" => $measurement->getFRSHTT(),
                "cloud_percentage" => $measurement->getWindDirection(),
                "visibility" => $measurement->getVisibility(),
                "wind_direction" => $measurement->getWindDirection()
            ];
        }

        return $this->render('monitor/station.html.twig', [
            'controller_name' => 'MonitorController',
            'station' => $station->getId(),
            'measurements' => $measurementList
        ]);
    }
}
