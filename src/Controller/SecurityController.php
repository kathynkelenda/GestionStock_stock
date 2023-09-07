<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\UserPasswordType;
use App\phpmailer\ServiceMail;
use App\Repository\UserRepository;
use Symfony\Component\Form\FormError;
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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;



// Inscription, connexion, déconnexion et resetPassword


class SecurityController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
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

            return $this->redirectToRoute('user.list');
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



    /**
 * @Route("/{id}/passwordUpdate", name="user.passwordUpdate")
 */
 
public function modificationPassword(User $user, Request $request, UserPasswordEncoderInterface $hasher, ManagerRegistry $doctrine)
{
    //On vérifie si l'utilisateur est connecté
    if(!$this->getUser()){
        return $this->redirectToRoute('security.login');
    }
    $form = $this->createForm(UserPasswordType::class);
 
    $form->handleRequest($request);
    //dd($form->getData());
    if($form->isSubmitted() && $form->isValid())
    {   
        if($hasher->isPasswordValid($user,$form->getData()['password']))
            {
                $user->setPassword(
                    $hasher->encodePassword(
                        $user,
                        $form->getData()['newPassword']
                    )    
                );

                $manager = $doctrine->getManager();
                $manager->persist($user);
                $manager->flush();
                
                //Mdp modifié
                $this->addFlash( 'success','Le mot de passe a été modifié');
                return $this->redirectToRoute('product.list');
            }else{
                //Mdp modifié
                echo'mot de passe erroné.';  
            }
    }
    return $this->render('user/editmdp.html.twig', [
        'form' => $form->createView(),
        'user' => $user
    ]);
}




}