<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Nature;
use App\Entity\Movement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class NewProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nameProduct')
        ->add('priceProduct')
        ->add('To_possess',EntityType::class,[
            'class'=> Nature::class,
            'choice_label'=>'nameNature'
        ])  
        ->add('vatProdut')
        ->add('codeProduct')
        ->add('quantityProduct')
        ->add('quantityAlert');
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

  
}
