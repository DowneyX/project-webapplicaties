<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Entity\Station;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsSuccessful;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
                    ->setTimestamp(new DateTime("{$data['DATE']} {$data['TIME']}"))
                    ->setTemperature($data["TEMP"])
                    ->setDewPoint($data["DEWP"])
                    ->setStationAirPressure($data["STP"])
                    ->setSeaLevelAirPressure($data["SLP"])
                    ->setVisibility($data["VISIB"])
                    ->setWindSpeed($data["WDSP"])
                    ->setPrecipitation($data["PRCP"])
                    ->setSnowDepth($data["SNDP"])
                    ->setFRSHTT($data["FRSHTT"])
                    ->setCloudPercentage($data["CLDC"])
                    ->setWindDirection($data["WNDDIR"]);

                $station->addMeasurement($measurement);

                $errors = $validator->validate($measurement);
                if (count($errors) > 0) {
                    $errorString = (string) $errors;

                    return new Response($errorString, Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                $entityManager->persist($measurement);
            } catch (\Throwable $e) {
                return new Response($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        $entityManager->flush();

        return new Response("Successfully inserted weather data", Response::HTTP_ACCEPTED);
    }
}
