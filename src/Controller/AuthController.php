<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthController extends AbstractController
{
    /**
     * @Route("/auth", name="auth")
     */
    public function index()
    {
        return $this->render('auth/index.html.twig', [
            'controller_name' => 'AuthController',
        ]);
    }
    /**
     * @Route("/login")
     * @param JWTEncoderInterface $JWTEncoder
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function login(Request $request,UserRepository $userRepository,UserPasswordEncoderInterface $userPassword, JWTEncoderInterface $JWTEncoder){
        $reception= $request->request->all();
        $user= $userRepository->findOneBy(['username'=>$reception['username']]);
        if ($user) {
            $validation=$userPassword->isPasswordValid($user,$reception['password']);
            
            if ($validation) {
                if ($user->getStatut()==NULL) {
                    $token = $JWTEncoder->encode([
                        'email' => $user->getUsername(),
                        'roles' => $user->getRoles(),
                        'exp' => time() + 3600 // 1 hour expiration
                    ]);
                    return new JsonResponse(['token' => $token]);
                }
                if ($user->getStatut()=="BLOQUER") {
                    $retour=[
                        'Message'=>"BLOQUER"
                    ];
                    return new JsonResponse($retour);
                }


            }
            else {
                $retour=[
                    'Message'=>'Password Invalid'
                ];
                return new JsonResponse($retour);
            }
        }
        else {
            $retour=[
                'Message'=>'Username Invalid'
            ];
            return new JsonResponse($retour);
        }

    }
}
