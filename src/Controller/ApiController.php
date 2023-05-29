<?php

namespace App\Controller;

use App\Entity\FaultyMeasurement;
use App\Entity\Measurement;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsSuccessful;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\Contract;
use DateTime;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api', methods: ['POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $body = json_decode($request->getContent(), true);
        $stationRepository = $entityManager->getRepository(Station::class);

        foreach ($body["WEATHERDATA"] as $data){
            try {
                $station = $stationRepository->findOneBy(array("id" => $data["STN"]));

                $measurement = new Measurement();
                $measurement
                    ->setStation($station)
                    ->setTimestamp(new DateTime("{$data['DATE']} {$data['TIME']}"));

                if ($data["TEMP"] != 'None') {
                    $measurement->setTemperature($data["TEMP"]);
                } else {
                    $measurement
                        ->setTemperature(null)
                        ->addFault("temperature");
                }

                if ($data["DEWP"]  != 'None') {
                    $measurement->setDewPoint($data["DEWP"]);
                } else {
                    $measurement
                        ->setDewPoint(null)
                        ->addFault("dew_point");
                }

                if ($data["STP"]  != 'None') {
                    $measurement->setStationAirPressure($data["STP"]);
                } else {
                    $measurement
                        ->setStationAirPressure(null)
                        ->addFault("station_air_pressure");
                }

                if ($data["SLP"]  != 'None') {
                    $measurement->setSeaLevelAirPressure($data["SLP"]);
                } else {
                    $measurement
                        ->setSeaLevelAirPressure(null)
                        ->addFault("sea_level_air_pressure");
                }

                if ($data["VISIB"]  != 'None') {
                    $measurement->setVisibility($data["VISIB"]);
                } else {
                    $measurement
                        ->setVisibility(null)
                        ->addFault("visibility");
                }

                if ($data["WDSP"]  != 'None') {
                    $measurement->setWindSpeed($data["WDSP"]);
                } else {
                    $measurement
                        ->setWindSpeed(null)
                        ->addFault("wind_speed");
                }

                if ($data["PRCP"]  != 'None') {
                    $measurement->setPrecipitation($data["PRCP"]);
                } else {
                    $measurement
                        ->setPrecipitation(null)
                        ->addFault("precipitation");
                }

                if ($data["SNDP"]  != 'None') {
                    $measurement->setSnowDepth($data["SNDP"]);
                } else {
                    $measurement
                        ->setSnowDepth(null)
                        ->addFault("snow_depth");
                }

                if ($data["FRSHTT"]  != 'None') {
                    $measurement->setFRSHTT($data["FRSHTT"]);
                } else {
                    $measurement
                        ->setFRSHTT(null)
                        ->addFault("FRSHTT");
                }

                if ($data["CLDC"]  != 'None') {
                    $measurement->setCloudPercentage($data["CLDC"]);
                } else {
                    $measurement
                        ->setCloudPercentage($data["CLDC"])
                        ->addFault("cloud_percentage");
                }

                if ($data["WNDDIR"]  != 'None') {
                    $measurement->setWindDirection($data["WNDDIR"]);
                } else {
                    $measurement
                        ->setWindDirection(null)
                        ->addFault("wind_direction");
                }

                $station->addMeasurement($measurement);

                $errors = $validator->validate($measurement);
                if (count($errors) > 0) {
                    $errorString = (string) $errors;
                    return new Response(sprintf("%s\nInserted faulty measurement", $errorString), Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                $entityManager->persist($measurement);
            } catch (\Throwable $e) {
                return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $entityManager->flush();

        return new Response("Successfully inserted weather data", Response::HTTP_ACCEPTED);
    }

    #[Route('/api/contract/{id}/stations', name: 'app_api_contract_stations', methods: ['GET'])]
    public function contract(Request $request,  EntityManagerInterface $entityManager, int $id): Response
    {
        $contractRepository = $entityManager->getRepository(Contract::class);
        $stationRepository = $entityManager->getRepository(Station::class);

        $contract = $contractRepository->find($id);

        $stationRepository = $entityManager->getRepository(Station::class);
        $stationList = [];

        $query = $stationRepository
            ->createQueryBuilder('u')
            ->select('u');
        if($contract->getMinLatitude() !== null && $contract->getMaxLatitude() !== null) 
        {
            $query = $query
                ->andWhere('u.latitude > :min_latitude')
                ->setParameter('min_latitude', $contract->getMinLatitude())
                ->andWhere('u.latitude < :max_latitude')
                ->setParameter('max_latitude', $contract->getMaxLatitude());
        }
        if($contract->getMinLongitude() !== null && $contract->getMaxLongitude() !== null) 
        {
            $query = $query
                ->andWhere('u.longitude > :min_longitude')
                ->setParameter('min_longitude', $contract->getMinLongitude())
                ->andWhere('u.longitude < :max_longitude')
                ->setParameter('max_longitude', $contract->getMaxLongitude());
        }
        if($contract->getMinElevation() !== null && $contract->getMaxElevation() !== null) 
        {
            $query = $query
                ->andWhere('u.elevation > :min_elevation')
                ->setParameter('min_elevation', $contract->getMinElevation())
                ->andWhere('u.elevation < :max_elevation')
                ->setParameter('max_elevation', $contract->getMaxElevation());
        }
        $stationList = $query->getQuery()->getResult();

        $jsonArr = array();
        foreach ($stationList as $key => $value) {
            array_push($jsonArr, array('stationId' => $value->getId(), 
                                    'longitude' => $value->getLongitude(), 
                                    'latitude' => $value->getLatitude()));
        }
        $json = json_encode($jsonArr);
        return new JsonResponse($json, 200, [], true );
    }

    #[Route('/api/station/{id}', name: 'app_api_station', methods: ['GET'])]
    public function contractStation(Request $request,  EntityManagerInterface $entityManager, int $id,)
    {
        $stationRepository = $entityManager->getRepository(Station::class);
        $station = $stationRepository->findOneBy(array('id' => $id));
        $latestMeasurement = null;

        foreach ($station->getMeasurements() as $measurement) {
            $timestamp = $measurement->getTimestamp();
            if($latestMeasurement == null || $timestamp > $latestMeasurement->getTimestamp()){
                $latestMeasurement = $measurement;
            }
        }

        $jsonArr = 
            [   
                "station" => [
                    "stationId" => $station->getId(),
                    "longitude" => $station->getLongitude(),
                    "latitude" => $station->getLatitude(),
                    "measurement" => [
                        "DATE" => $latestMeasurement->getTimestamp()->format('d-m-y'),
                        "TIME"=> $latestMeasurement->getTimestamp()->format('H:i:s'),
                        "TEMP" => $latestMeasurement->getTemperature(),
                        "DEWP" => $latestMeasurement->getTemperature(),
                        "STP" => $latestMeasurement->getStationAirPressure(),
                        "SLP" => $latestMeasurement->getSeaLevelAirPressure(),
                        "VISIB" => $latestMeasurement->getVisibility(),
                        "WDSP" => $latestMeasurement->getWindSpeed(),
                        "PRCP" => $latestMeasurement->getPrecipitation(),
                        "SNDP" => $latestMeasurement->getSnowDepth(),
                        "FRSHTT" => $latestMeasurement->getFRSHTT(),
                        "CLDC" => $latestMeasurement->getCloudPercentage(),
                        "WNDDIR" => $latestMeasurement->getWindDirection()
                    ]
                ]
            ];
        $json = json_encode($jsonArr);
        return new JsonResponse($json, 200, [], true );
    }
}
