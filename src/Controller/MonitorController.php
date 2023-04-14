<?php

namespace App\Controller;

use App\Entity\Geolocation;
use App\Entity\Measurement;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonitorController extends AbstractController
{
    /**
     * @throws InvalidArgumentException
     */
    #[Route('/monitor', name: 'app_monitor')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $cache = new FilesystemAdapter();

        if($cache->hasItem('geolocations')) {
            $geolocations = $cache->getItem('geolocations')->get();
        } else {
            $geolocationRepository = $entityManager->getRepository(Geolocation::class);
            $geolocations = $geolocationRepository->findBy(
                array(),
                array('id' => 'DESC'),
                10000,
                0
            );

            $cache->save($cache->getItem('geolocations')->set($geolocations));
        }

        return $this->render('monitor/index.html.twig', [
            'controller_name' => 'MonitorController',
            'geolocations' => $geolocations
        ]);
    }

    #[Route('/monitor/{id}', name: 'app_monitor_station')]
    public function station(EntityManagerInterface $entityManager, string $id): Response
    {
        $stationRepository = $entityManager->getRepository(Station::class);
        $station = $stationRepository->findOneBy(array('id' => $id));

        if(!$station) {
            throw $this->createNotFoundException("No station found for id {$id}");
        }

        return $this->render('monitor/station.html.twig', [
            'station' => $station,
            'measurements' => $station->getMeasurements()
        ]);
    }
}
