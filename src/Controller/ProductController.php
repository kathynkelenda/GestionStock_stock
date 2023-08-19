<?php

namespace App\Controller;

use App\Entity\Nature;
use App\Entity\Product;
use App\Entity\Movement;
use App\Form\NewProductType;
use App\Repository\NatureRepository;
use App\Repository\ProductRepository;
use App\Repository\MovementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    
    //AFFICHE TOUS LES PRODUITS
    /**
     * @Route("/product/list",name="product.list")
     */
    public function list(ManagerRegistry $doctrine): Response
    {
        //Vérifie si l'utilisateur est connecté
        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        $product = $doctrine->getRepository(Product::class)->findAll();
        //dd($tickets);

        return $this->render('product/list.html.twig', [
            'product' => $product
        ]);
    }
    
    
    
    // CREE ET MODIFIE UN PRODUIT
     /**
    * @IsGranted("ROLE_ADMIN") 
     * @Route("/product/new",name="product.new")
     * @Route("/product/{id}/edit", name="product.edit")
     */
    public function create(Product $product = null, Request $request, ManagerRegistry $doctrine){

        
        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        if(!$product){
            $product= new Product();
        }
        
        $form=$this->createForm(NewProductType::class,$product);
        

        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()){

            /*if(!$product->getId()){
                $product->setCreatedAt(new \DateTimeImmutable('now'));
            }else{
                $product->SetUpdateAt(new \DateTimeImmutable('now'));
            }*/

            $manager = $doctrine->getManager();
            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute('product.show',['id'=>$product->getId()]);

        }

        return $this->render('product/new.html.twig',[
            'form'=>$form->createView(),
            'editAction' => $product->getId() !== null
        ]);
    }


    //SUPPRIME UN PRODUIT 
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/product/delete/{id}",name="product.delete")
     */
    public function delete(ManagerRegistry $doctrine, int $id):Response{

        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        $product = $doctrine->getRepository(Product::class)->find($id);

        if(!$product){
            $this->addFlash(
                'Produit',
                'non retrouvé!'
            );
            return $this->redirectToRoute('product.list');
        } 

        $manager = $doctrine->getManager();
        $manager->remove($product);
        $manager->flush();

        $this->addFlash(
            'Suppression',
            'Effectuée!'
        );

        return $this->redirectToRoute('product.list');
    }


    //VOIR UN PRODUIT 
    /**
     * @Route("product/show/{id}", name="product.show")
     */
    public function show(int $id, ManagerRegistry $doctrine): Response{

        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        $product = $doctrine->getRepository(Product::class)->find($id);
        
        if(!$id){
            throw $this->createNotFoundException(
                'Ce produit n\'a pas été trouvé' 
            );
        }
        return $this->render('product/show.html.twig',[
            'product'=>$product,
        ]);
        
  
    }

}
