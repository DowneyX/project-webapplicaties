<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(EntityManagerInterface $em): Response
    {
        $cache = new FilesystemAdapter();

        if($cache->hasItem('users')) {
            $users = $cache->getItem('users')->get();
        } else {
            $userRepository = $em->getRepository(User::class);
            $users = $userRepository->findAll();

            $cache->save($cache->getItem('users')->set($users));
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
        ]);
    }
}
