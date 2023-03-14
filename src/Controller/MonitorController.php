<?php

namespace App\Controller;

use App\Entity\Geolocation;
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
    public function showStation(EntityManagerInterface $entityManager, string $id): Response
    {
        $stationRepository = $entityManager->getRepository(Station::class);
        $station = $stationRepository->find($id);
        
        if(!$station) {
            throw $this->createNotFoundException("No station found for id {$id}");
        }


        return $this->render('monitor/station.html.twig', [
            'controller_name' => 'MonitorController',
            'station' => $station
        ]);
    }
}
