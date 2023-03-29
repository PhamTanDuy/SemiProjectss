<?php

namespace App\Form;
use App\Entity\Inventor;
use App\Entity\Genre;
use App\Entity\Water;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;


class WaterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('WaterName',TextType::class)
            ->add('inventor',EntityType::class,array('class'=>'App\Entity\Inventor','choice_label'=>'Name'))
            ->add('genre',EntityType::class,array('class'=>'App\Entity\Genre','choice_label'=>'GenreName'))
            ->add('Description',TextareaType::class)
            ->add('Price',TextType::class)
            ->add('Image',FileType::class, [
                'mapped'=> false,
                'required'=> false,
                'constraints'=>[

                ],
            ])

//            ->add('genre')
//            ->add('inventor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Water::class,
        ]);
    }
}
