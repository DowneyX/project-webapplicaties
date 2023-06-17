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

        foreach ($body["WEATHERDATA"] as $data) {
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

                if ($data["DEWP"] != 'None') {
                    $measurement->setDewPoint($data["DEWP"]);
                } else {
                    $measurement
                        ->setDewPoint(null)
                        ->addFault("dew_point");
                }

                if ($data["STP"] != 'None') {
                    $measurement->setStationAirPressure($data["STP"]);
                } else {
                    $measurement
                        ->setStationAirPressure(null)
                        ->addFault("station_air_pressure");
                }

                if ($data["SLP"] != 'None') {
                    $measurement->setSeaLevelAirPressure($data["SLP"]);
                } else {
                    $measurement
                        ->setSeaLevelAirPressure(null)
                        ->addFault("sea_level_air_pressure");
                }

                if ($data["VISIB"] != 'None') {
                    $measurement->setVisibility($data["VISIB"]);
                } else {
                    $measurement
                        ->setVisibility(null)
                        ->addFault("visibility");
                }

                if ($data["WDSP"] != 'None') {
                    $measurement->setWindSpeed($data["WDSP"]);
                } else {
                    $measurement
                        ->setWindSpeed(null)
                        ->addFault("wind_speed");
                }

                if ($data["PRCP"] != 'None') {
                    $measurement->setPrecipitation($data["PRCP"]);
                } else {
                    $measurement
                        ->setPrecipitation(null)
                        ->addFault("precipitation");
                }

                if ($data["SNDP"] != 'None') {
                    $measurement->setSnowDepth($data["SNDP"]);
                } else {
                    $measurement
                        ->setSnowDepth(null)
                        ->addFault("snow_depth");
                }

                if ($data["FRSHTT"] != 'None') {
                    $measurement->setFRSHTT($data["FRSHTT"]);
                } else {
                    $measurement
                        ->setFRSHTT(null)
                        ->addFault("FRSHTT");
                }

                if ($data["CLDC"] != 'None') {
                    $measurement->setCloudPercentage($data["CLDC"]);
                } else {
                    $measurement
                        ->setCloudPercentage($data["CLDC"])
                        ->addFault("cloud_percentage");
                }

                if ($data["WNDDIR"] != 'None') {
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

    #[Route('/api/contract/stations', name: 'app_api_contract_stations', methods: ['GET'])]
    public function contract(Request $request, EntityManagerInterface $entityManager): Response
    {
        $auth = $request->headers->get("API-key");

        $contractRepository = $entityManager->getRepository(Contract::class);
        $contract = $contractRepository->findOneBy(["api_key" => $auth]);

        if ($contract == null) {
            return new Response('', 401);
        }

        $contractQuery = htmlspecialchars_decode(Strip_tags($contract->getQueryStations()));

        $query = $entityManager->createQuery($contractQuery);
        $stationList = $query->getArrayResult();

        $json = json_encode($stationList);
        return new JsonResponse($json, 200, [], true);
    }


    #[Route('/api/contract/station/{id}/measurements', name: 'app_api_contract_station_measurements', methods: ['GET'])]
    public function contractStationMeasurement(Request $request, EntityManagerInterface $entityManager, int $id, )
    {
        $auth = $request->headers->get("API-key");

        $contractRepository = $entityManager->getRepository(Contract::class);
        $contract = $contractRepository->findOneBy(["api_key" => $auth]);

        if ($contract == null) {
            return new Response('', 401);
        }

        $contractQuery = htmlspecialchars_decode(Strip_tags($contract->getQueryMeasurments()));
        $Query = $entityManager->createQuery($contractQuery);
        $Query->setParameters(["id" => $id]);
        $result = $Query->getArrayResult();

        return new JsonResponse($result, 200, [], false);
    }

    #[Route('/api/contract/station/{date}/measurementss', name: 'app_api_contract_station_measurementss', methods: ['GET'])]
    public function contractStationssMeasurement(Request $request, EntityManagerInterface $entityManager, string $date, )
    {
        $auth = $request->headers->get("API-key");

        $contractRepository = $entityManager->getRepository(Contract::class);
        $contract = $contractRepository->findOneBy(["api_key" => $auth]);

        if ($contract == null) {
            return new Response('', 401);
        }

        $contractQuery = htmlspecialchars_decode(Strip_tags($contract->getQueryStations()));

        $query = $entityManager->createQuery($contractQuery);
        $stationList = $query->getArrayResult();

        $ids = array_column($stationList, 'id');

        $measurements = array();

        for ($x=0; $x < count($ids); $x++) {
            settype($ids[$x], 'integer');
            $contract2Query = htmlspecialchars_decode(Strip_tags($contract->getQueryMeasurments()));
            $Query2 = $entityManager->createQuery($contract2Query);
            $Query2->setParameters(["id" => $ids[$x]]);
            $result = $Query2->getArrayResult();
            for ($y=0; $y < count($result); $y++) {
                $dateTime = $result[$y]['timestamp']; 
                $dateStation = $dateTime->format('Y-m-d');
                if ($dateStation == $date) {
                    array_push($measurements, $result[$y]);
                }
            }
        }

        // veranderen naar sorteren op station_air_pressure
        usort($measurements, function($a, $b) {
            return $a['wind_speed'] < $b['wind_speed'];
        });

        $measurementData = array();
        for ($c=0; $c < 10; $c++) {
            array_push($measurementData, $measurements[$c]);
        }

        return new JsonResponse($measurementData, 200, [], false);
    }
}
