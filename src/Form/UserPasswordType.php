<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('password',PasswordType::class,[
            'empty_data' => ''
        ])
        ->add('confirmPassword', PasswordType::class,[
            'empty_data' => ''
        ])
        ->add('newPassword',PasswordType::class,[
            'empty_data' => ''
        ]
        );
        
           
    }

}
