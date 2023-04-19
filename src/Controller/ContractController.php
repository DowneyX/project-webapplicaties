<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Entity\Station;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ContractController extends AbstractController
{
    #[Route('/contract', name: 'app_contract')]
    public function index(UserInterface $user, EntityManagerInterface $em): Response
    {
        $stationRepository = $em->getRepository(Station::class);
        $stationList = [];

        foreach ($user->getContracts() as $contract) {
            $query = $stationRepository
                ->createQueryBuilder('u')
                ->select('u');

            if($contract->getMinLatitude() !== null && $contract->getMaxLatitude() !== null) {
                $query = $query
                    ->andWhere('u.latitude > :min_latitude')
                    ->setParameter('min_latitude', $contract->getMinLatitude())
                    ->andWhere('u.latitude < :max_latitude')
                    ->setParameter('max_latitude', $contract->getMaxLatitude());
            }

            if($contract->getMinLongitude() !== null && $contract->getMaxLongitude() !== null) {
                $query = $query
                    ->andWhere('u.longitude > :min_longitude')
                    ->setParameter('min_longitude', $contract->getMinLongitude())
                    ->andWhere('u.longitude < :max_longitude')
                    ->setParameter('max_longitude', $contract->getMaxLongitude());
            }

            if($contract->getMinElevation() !== null && $contract->getMaxElevation() !== null) {
                $query = $query
                    ->andWhere('u.elevation > :min_elevation')
                    ->setParameter('min_elevation', $contract->getMinElevation())
                    ->andWhere('u.elevation < :max_elevation')
                    ->setParameter('max_elevation', $contract->getMaxElevation());
            }

            $stationList[] = $query->getQuery()->getResult();
        }

        return $this->render('contract/index.html.twig', [
            'contracts' => $user->getContracts(),
            'stationList' => $stationList,
        ]);
    }
}
