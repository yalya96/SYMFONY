<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Entity\User;
use App\Form\PrestataireType;
use App\Form\UsersystemeType;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SystemeController extends AbstractController
{
    /**
     * @Route("/systeme", name="systeme")
     */
    public function index()
    {
        return $this->render('systeme/index.html.twig', [
            'controller_name' => 'SystemeController',
        ]);
    }
    /**
     * @Route("/addsys")
     */
    public function addsys(Request $request,UserPasswordEncoderInterface $PasswordEncoder,EntityManagerInterface $entityManager,SerializerInterface $serializer,ProfilRepository $profilRepository){
        $systeme= new User();
        $form= $this->createForm(UsersystemeType::class,$systeme);
        $reception=$request->request->all();
        $form->submit($reception);
        $username=$reception['Prenom'][0].$reception['Nom'][0].$reception['Prenom'][1].$reception['Nom'][0].rand(1,100).date('i').date('s');
        $systeme->setUsername($username);
        $systeme->setPassword($PasswordEncoder->encodePassword($systeme,"welcome"));
        $systeme->setStatut("ACTIF");
        $a=$profilRepository->findOneBy([
            'Libeller'=>$reception['Profil']
        ]);
        //dump($a);die();
        $b=$reception['Profil'];
        $systeme->setRoles(["ROLE_$b"]);
        $entityManager->persist($systeme);
        
        $entityManager->flush();
        $retour=$serializer->serialize($systeme, 'json');

        return new Response($retour, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
    /**
     * @Route("/rien")
     */
    public function addprest(Request $request,UserPasswordEncoderInterface $PasswordEncoder,EntityManagerInterface $entityManager,SerializerInterface $serializer,ProfilRepository $profilRepository){
        $prestataire= new Prestataire();
        $systeme= new User();
        $form= $this->createForm(PrestataireType::class,$prestataire);
        $reception=$request->request->all();
        $form->submit($reception);
        $form1= $this->createForm(UsersystemeType::class,$systeme);
        $reception=$request->request->all();
        $form1->submit($reception);
        $username=$reception['Prenom'][0].$reception['Nom'][0].$reception['Prenom'][1].$reception['Nom'][0].rand(1,100).date('i').date('s');
        $systeme->setUsername($username);
        $systeme->setPassword($PasswordEncoder->encodePassword($systeme,"welcome"));
        $systeme->setStatut("ACTIF");
        $prestataire->setStatut("ACTIF");
        $b=$reception['Profil'];
        $systeme->setRoles(["ROLE_$b"]);
        $systeme->setPrest($prestataire);
        $entityManager->persist($systeme);
        $entityManager->persist($prestataire);
        $entityManager->flush();
        $retour=[
            'Message'=>'Bravo'
        ];
        return new JsonResponse($retour);
        
       
    }
}
