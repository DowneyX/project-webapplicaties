<?php

namespace App\Controller;

use App\Entity\Geolocation;
use App\Entity\Measurement;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonitorController extends AbstractController
{

    public function __construct(private Security $security)
    {

    }
    /**
     * @throws InvalidArgumentException
     */
    #[Route('/monitor', name: 'app_monitor')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        if ($this->security->isGranted('ROLE_RESEARCHER')) {
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
        } else {
            $geolocations = [];
            foreach ($this->getUser()->getSubscriptions() as $subscription) {
                $geolocations[] = $subscription->getStation()->getGeolocation();
            }
        }

        return $this->render('monitor/index.html.twig', [
            'controller_name' => 'MonitorController',
            'geolocations' => $geolocations
        ]);
    }

    #[Route('/monitor/{id}', name: 'app_monitor_station')]
    public function station(EntityManagerInterface $entityManager, string $id): Response
    {
        $subscriptionType = "";

        if (!$this->security->isGranted('ROLE_RESEARCHER')) {
            $subscriptions = $this->getUser()->getSubscriptions();
            $hit = false;

            foreach ($subscriptions as $subscription) {
                if($id == $subscription->getStation()->getId()) {
                    $hit = true;
                    $subscriptionType = $subscription->getSubscriptionType()->getDescription();
                }
            }

            if(!$hit) {
                return new Response("Access denied", Response::HTTP_UNAUTHORIZED);
            }
        }

        $stationRepository = $entityManager->getRepository(Station::class);
        $measurementRepository = $entityManager->getRepository(Measurement::class);
        $station = $stationRepository->findOneBy(array('id' => $id));
        $latestMeasurement = null;

        foreach ($station->getMeasurements() as $measurement) {
            $timestamp = $measurement->getTimestamp();
            if($latestMeasurement == null || $timestamp > $latestMeasurement->getTimestamp()){
                $latestMeasurement = $measurement;
            }
        }


        if(!$station) {
            throw $this->createNotFoundException("No station found for id {$id}");
        }

        $measurements = $measurementRepository->findByCurrentWeek($station);

        if ($this->security->isGranted('ROLE_RESEARCHER')) {
            $measurements = $station->getMeasurements();
        }

        return $this->render('monitor/station.html.twig', [
            'station' => $station,
            'subscriptionType' => $subscriptionType ?: "admin",
            'measurements' => $station->getMeasurements(),
            'geolocation' => $station->getGeolocation(),
            'latestMeasurement' => $latestMeasurement
        ]);
    }
}
