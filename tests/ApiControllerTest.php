<?php

namespace App\Tests;

use App\Controller\ApiController;
use App\Entity\Measurement;
use App\Entity\Station;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ApiControllerTest extends KernelTestCase
{
    public function setUp(): void {
        $this->request = $this->createMock(Request::class);
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->station = $this->createMock(Station::class);
        $this->stationRepository = $this->createMock(EntityRepository::class);
    }

    public function testApiPostData(): void
    {

        $this->request->method("getContent")->willReturn(json_encode(
            ["WEATHERDATA" => [
                [
                    "STN" => 637100,
                    "DATE" => "2022-02-09",
                    "TIME" => "00:00:58",
                    "TEMP" => 10.1,
                    "DEWP" => 1.5,
                    "STP" => 984.1,
                    "SLP" => 1012.6,
                    "VISIB" => 23.4,
                    "WDSP" => 13.8,
                    "PRCP" => 0.00,
                    "SNDP" => 0.0,
                    "FRSHTT" => "000000",
                    "CLDC" => 96.8,
                    "WNDDIR" => 228
                ]
            ]]
        ));

        $this->entityManager->method("getRepository")->with(Station::class)->willReturn($this->stationRepository);
        $this->stationRepository->method("findOneBy")->with(array("id" => "637100"))->willReturn($this->station);

        $controller = new ApiController();
        $response = $controller->index($this->request, $this->entityManager, $this->validator);

        $this->assertEquals(202, $response->getStatusCode());
    }

    public function testApiPostDataFaulty(): void
    {

        $this->request->method("getContent")->willReturn(json_encode(
            ["WEATHERDATA" => [
                [
                    "STN" => 637100,
                    "DATE" => "2022-02-09",
                    "TIME" => "00:00:58",
                    "TEMP" => 10.1,
                    "DEWP" => null,
                    "STP" => 984.1,
                    "SLP" => 1012.6,
                    "VISIB" => 23.4,
                    "WDSP" => 13.8,
                    "PRCP" => 0.00,
                    "SNDP" => 0.0,
                    "FRSHTT" => "000000",
                    "CLDC" => 96.8,
                    "WNDDIR" => 228
                ]
            ]]
        ));

        $this->entityManager->method("getRepository")->with(Station::class)->willReturn($this->stationRepository);
        $this->stationRepository->method("findOneBy")->with(array("id" => "637100"))->willReturn($this->station);

        $controller = new ApiController();
        $response = $controller->index($this->request, $this->entityManager, $this->validator);

        $this->assertEquals(500, $response->getStatusCode());
    }
}
