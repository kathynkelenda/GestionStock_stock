<?php

namespace App\Controller;

use App\Entity\Nature;
use App\Form\NatureType;

use App\Repository\NatureRepository;

use Doctrine\Persistence\ManagerRegistry;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class NatureController extends AbstractController
{   

    //AFFICHE TOUTES LES NATURE DE PRODUIT
    /**
     * @Route("/nature/list",name="nature.list")
     */
    public function list(NatureRepository $NatureRepository,ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator): Response
    {
        //Vérifie si l'utilisateur est connecté
        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        $nature = $doctrine->getRepository(Nature::class)->findAll();

        //$pagination = $paginator->paginate(
           // $nature,
            //$NatureRepository->paginationQuery(),
            /** On va get la page actuelle, et par défaut si on n'a pas de page, ce sera la page numéro 1. */
            //$request->query->getInt('page',1),
            /** Limite le nombre d'éléments sur une page. */
           // 2
    
        //);
       
        return $this->render('nature/list.html.twig', [
            'nature' => $nature, 
            //'pagination'=>$pagination  
        ]);
    }
    

    // CREE ET MODIFIE UNE NATURE
     /**
      * @IsGranted("ROLE_ADMIN") 
     * @Route("/nature/new",name="nature.new")
     * @Route("/nature/{id}/edit", name="nature.edit")
     */
    public function create(Nature $nature = null, Request $request, ManagerRegistry $doctrine){

        
        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        if(!$nature){
            $nature= new Nature();
        }
        
        $form=$this->createForm(NatureType::class,$nature);
        

        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()){

            /*if(!$Nature->getId()){
                $Nature->setCreatedAt(new \DateTimeImmutable('now'));
            }else{
                $Nature->SetUpdateAt(new \DateTimeImmutable('now'));
            }*/

            $manager = $doctrine->getManager();
            $manager->persist($nature);
            $manager->flush();

            return $this->redirectToRoute('nature.show',['id'=>$nature->getId()]);

        }

        return $this->render('nature/new.html.twig',[
            'form'=>$form->createView(),
            'editAction' => $nature->getId() !== null
        ]);
    }

      //VOIR UN NATURE DE PRODUIT 
    /**
     * @Route("nature/show/{id}", name="nature.show")
     */
    public function show(int $id, ManagerRegistry $doctrine): Response{

        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        $nature = $doctrine->getRepository(Nature::class)->find($id);
        
        if(!$id){
            throw $this->createNotFoundException(
                'Cette nature de produit n\'a pas été trouvé' 
            );
        }
        return $this->render('nature/show.html.twig',[
            'nature'=>$nature,
        ]);


    }


    //SUPPRIME UN PRODUIT 
    /**
     * @IsGranted("ROLE_ADMIN") 
     * @Route("/nature/delete/{id}",name="nature.delete")
     */
    public function delete(ManagerRegistry $doctrine, int $id):Response{

        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        $nature = $doctrine->getRepository(Nature::class)->find($id);

        if(!$nature){
            $this->addFlash(
                'Produit',
                'non retrouvé!'
            );
            return $this->redirectToRoute('nature.list');
        } 

        $manager = $doctrine->getManager();
        $manager->remove($nature);
        $manager->flush();

        $this->addFlash(
            'success',
            'Suppression effectuée!'
        );

        return $this->redirectToRoute('nature.list');
    }

}