<?php

namespace App\Controller;

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
        $stationRepository = $entityManager->getRepository(Station::class);
        $stations = $stationRepository->findAll();

        return $this->render('monitor/index.html.twig', [
            'controller_name' => 'MonitorController',
            'stations' => $stations
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

        return new Response("id: {$station->getId()}, latitude: {$station->getLatitude()}, longitude: {$station->getLongitude()}");
    }
}
