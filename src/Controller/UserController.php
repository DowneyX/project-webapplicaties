<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\Hasher\PasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, PasswordHasherInterface $hasher, ValidatorInterface $validator, JWTTokenManagerInterface $jwtManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->submit($request->request->all());

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse(['error' => 'Invalid registration data'], Response::HTTP_BAD_REQUEST);
        }

        $hashedPassword = $hasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);

        $errors = $validator->validate($user);

        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        return new Response('The user is valid');


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $token = $jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(Request $request, JWTTokenManagerInterface $jwtManager, PasswordHasherInterface $hasher, TokenStorageInterface $tokenStorage): JsonResponse
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['username' => $username]);


        if (!$user || !$this->isPasswordValid($hasher, $user, $password)) {
            throw new AuthenticationException('Invalid credentials');
        }

        $token = $jwtManager->create($user);

        $tokenStorage->setToken($token);

        return new JsonResponse(['token' => $token]);
    }

    private function isPasswordValid(PasswordHasherInterface $hasher, UserInterface $user, string $password): bool
    {
        return $hasher->isPasswordValid($user, $password);
    }
}