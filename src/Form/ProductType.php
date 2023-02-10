<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label' , TextType::class,[
                'label' => 'Nom Produit',
                'attr' => ['class' => 'form-control']
            ])
            ->add('purchasePrice', NumberType::class,[
                'label' => 'Prix Achat',
                'attr' => ['class' => 'form-control']
            ])
            ->add('sellingPrice', NumberType::class,[
                'label' => 'Prix de vente',
                'attr' => ['class' => 'form-control']
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'QTE',
                'attr' => ['class' => 'form-control']
            ])

            ->add('available' , TextType::class,[
                
                'attr' => ['class' => 'form-control']
            ])
            
        ;
    }

    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }

}
