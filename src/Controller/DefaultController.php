<?php
declare(strict_types = 1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
class DefaultController extends AbstractController
{
    #[Route("/", name: "index", methods: ["GET"])]
    public function index(): Response
    {
        return $this->render("index.html.twig");
    }
}