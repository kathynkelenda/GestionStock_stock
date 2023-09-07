<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Status;
use App\Entity\Position;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



//Formulaire de modification des informations des utilisateurs

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('prenom')
            ->add('email')

            ->add('roles', ChoiceType::class,[
                'choices' => [
                    'utilisateur' => 'ROLE_USER',
                    'Gestionnaire des produits' => 'ROLE_PRODUCT',
                    'administrateur' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'multiple' => true
            ])
            
            ->add('To_occupy',EntityType::class,[
                'class'=> Position::class,
                'choice_label'=>'namePosition'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
