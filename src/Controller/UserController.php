<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Status;
use App\Form\UserType;
use App\Entity\Movement;
use App\Form\UserPasswordType;
use App\Repository\UserRepository;
use App\Repository\StatusRepository;
use App\Repository\MovementRepository;

use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

     //AFFICHE TOUS LES UTILISATEURS
    /**
     * @Route("/user/list",name="user.list")
     */
    public function list(ManagerRegistry $doctrine): Response
    {
    
        $user = $doctrine->getRepository(User::class)->findAll();
       

        return $this->render('user/list.html.twig',[
            'user' => $user,
        ]);
    }

    // MODIFIER UN UTILISATEUR
    /**
     * @Route("/user/{id}/edit", name="user.edit")
     */
    
     public function edit(User $user, int $id , Request $request, ManagerRegistry $doctrine):Response
     {

        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        $user = $doctrine->getRepository(User::class)->find($id);

        $form=$this->createForm(UserType::class,$user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $user = $form->getData();

            $manager = $doctrine->getManager();
            $manager->persist($user);
            $manager->flush();

            
        }

        return $this->render('user/edit.html.twig',[
            'form'=>$form->createView(),
            'user'=>$user
        ]);
    }  



    //SUPPRIMER UN UTILISATEUR 
    /**
     * @Route("/user/delete/{id}",name="user.delete")
     */
    public function delete(ManagerRegistry $doctrine, int $id):Response{

        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        $user = $doctrine->getRepository(User::class)->find($id);

        if(!$user){
            $this->addFlash(
                'success',
                'Utilisateur non retrouvé!'
            );
            return $this->redirectToRoute('user.list');
        } 
        $session = new Session();
        $session->invalidate();

        $manager = $doctrine->getManager();
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'Suppression effectuée!'
        );

        return $this->redirectToRoute( 'security.logout' );
        
    }


    //VOIR UN UTILISATEUR 
    /**
     * @Route("user/show/{id}", name="user.show")
     */
    public function show(int $id, ManagerRegistry $doctrine): Response{

        if(!$this->getUser()){
            return $this->redirectToRoute('security.login');
        }

        $user = $doctrine->getRepository(User::class)->find($id);
        
        if(!$id){
            throw $this->createNotFoundException(
                'Cet User n\'a pas été trouvé' 
            );
        }
        return $this->render('user/show.html.twig',[
            'user'=>$user,
        ]);
        
  
    }

    /**
     * @Route("user/{id}/editmdp", name="user.editmdp")
     */
    public function editPassword(User $user, int $id ,Request $request, ManagerRegistry $doctrine, UserPasswordEncoderInterface $encoder){

        $user = $doctrine->getRepository(User::class)->find($id);

        $form=$this->createForm(UserPasswordType::class,$id);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            if($hasher->isPasswordvali($user, $form->getDate()->getPlainPassword())){

                $user->setPassword(

                    $form->getData()->getNewPassword()
                );

                $this->addFlush(
                    'success',
                    'Le mot de passe a été modifié.'
                );
                return $this->redirectToRoute('security.login');
            }else{
                $this->addFlush(
                    'success',
                    'Le mot de passe renseigné est incorrect.'
                );
            }
            

            $manager = $doctrine->getManager();
            $manager->persist($user);
            $manager->flush();
   
        }

        return  $this->render('user/editmdp.html.twig',[
            'form'=>$form->createView(),
            'user'=>$user
        ]);
    }
    
}
