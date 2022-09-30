<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Form\EmployesType;
use App\Repository\EmployesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response as BrowserKitResponse;

class EntrepriseController extends AbstractController
{
   


    #[Route('/entreprise', name: 'app_entreprise')]
    public function index(): Response
    {
        return $this->render('entreprise/index.html.twig', [
            'controller_name' => 'EntrepriseController',
        ]);
    }

    #[Route('/', name: "accueil" )]
    public function liste(EmployesRepository $repo): Response
    {
        $employes=$repo->findAll();
        // dd($employes);
        return $this->render('entreprise/liste.html.twig', [
        'employes'=>$employes
       ]);

    }
    #[Route('/employes/edit/{id}', name: 'edit')]
    #[Route ('/employes/ajouter', name: "employes_ajouter")]
    public function add(Request $globals, EntityManagerInterface $manager,Employes $employes = null): Response
    {
      if($employes == null){
        $employes= new Employes;
      }
      $form = $this->createForm(EmployesType::class, $employes);
      $form->handleRequest($globals);

      if($form->isSubmitted() && $form->isValid())
      {
        $manager->persist($employes);
        $manager->flush();
        return $this->redirectToRoute('accueil');
      }
       
      return $this->renderForm('entreprise/form.html.twig',
      [
        'formEmployes'=>$form,
        'editMode'=> $employes-> getId() !== null
      ]);

    }
    
    #[Route("/employes/delete/{id}", name:"delete")]
    public function delete($id, EntityManagerInterface $manager, EmployesRepository $repo)
    {
        $employes= $repo->find($id);

        $manager->remove($employes);
        $manager->flush();
        return $this->redirectToRoute('accueil');
    }




}

 