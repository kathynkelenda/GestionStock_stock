<?php

namespace App\Controller;


use App\phpmailer\ServiceMail;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Form\ForgotPasswordRequestType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;







class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security.inscription")
     */
    public function registration(Request $request, ManagerRegistry $doctrine, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();

        $form=$this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $hash = $encoder->encodePassword($user,$user->getPassword());

            $user->setPassword($hash);

            $manager = $doctrine->getManager();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security.login');
            $this->addFlash(
                'success',
                'Vous venez d\'ajouter un nouvel utilisateur'
            );
            
        }
        

        return $this->render('security/registration.html.twig',[
            'form'=>$form->createView(),
        ]);
    }


     

    /**
     * @Route("/connexion",name="security.login", methods={"GET", "POST"})
     */
        public function login(AuthenticationUtils $authenticationUtils): Response
      {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
         // last username entered by the user
         $lastUsername = $authenticationUtils->getLastUsername();

          return $this->render('security/login.html.twig', [
             'last_username' => $lastUsername,
             'error'         => $error,
          ]);
      }


    /**
     * @Route("/deconnexion",name="security.logout")
     */
    public function logout(){
        
    }














    
    //Permet en donnant son email, de recevoir un lien de réinitialisation
    /**
     * @Route("/forgotPass",name="security.forgotPass")
     */
    public function forgotPass(UserRepository $UserRepository, TokenGeneratorInterface $TokenGeneratorInterface,
        ManagerRegistry $doctrine, Request $request):Response{

        $form=$this->createForm(ForgotPasswordRequestType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            
            //Rétrouve un utilisateur par son email
            $user = $UserRepository->findOneByEmail($form->get('email')->getData());

            //Verifie si on a un utilisateur
            if($user){

                //On génere un token de réinitialisation(Permettra d'identifier de manière unique l'utilisateur)  
                $token = $TokenGeneratorInterface->generateToken();
                $user ->setResetToken($token);

                $manager = $doctrine->getManager();
                $manager->persist($user);
                $manager->flush();

               
                //On genere un lien de réinitialisation du mdp 
                $url = $this->generateUrl('security.lienPass',['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
               
                //On crée les données du mail
                $context = compact(['url'=>$url,'$user'=>$user]);

                /*Envoi mail
                $mail->send(
                    'no-reply@gestionStock.fr',
                     $user->getEmail(),
                    'Réinitialisation de mot de passe',
                    'resetPass_lien.html.twig',
                    $context
                    
                );*/

                    //Si l'utilisateur n'est pas retrouvé
                    $this->addFlash('success','Email envoyé avec succès'
                    );
            return $this->redirectToRoute('security.login');

            }

            //Si l'utilisateur n'est pas retrouvé
            $this->addFlash( 'danger','Un problème est survenu'
            );
            return $this->redirectToRoute('security.login');
   
        }
    
         return $this->render('security/resetPass_request.html.twig',[
            'form' => $form->createView()
         ]) ;
        
    }



    //Permet en en cliquant sur le lien de réinitialisation, reçu par mail de choisir un mdp
     

    /**
     * @Route("/forgotPass/{token}",name="security.lienPass")
     */
    public function lienPass(){
        
    }



    


}