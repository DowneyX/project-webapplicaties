<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Geolocation;
use App\Entity\Measurement;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class HomeController extends AbstractController
{
    #[Route("/", name: "index", methods: ["GET"])]
    public function index(ChartBuilderInterface $chartBuilder, EntityManagerInterface $em): Response
    {
        $stationRepository = $em->getRepository(Station::class);
        $stationCount = $stationRepository->count([]);

        $measurementRepository = $em->getRepository(Measurement::class);
        $measurementCount = $measurementRepository->count([]);

        $geolocationRepository = $em->getRepository(Geolocation::class);
        $geolocationCount = $geolocationRepository->count([]);

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render("index.html.twig", [
            'chart' => $chart,
            'stationCount' => $stationCount,
            'measurementCount' => $measurementCount,
            'geolocationCount' => $geolocationCount
        ]);
    }
}