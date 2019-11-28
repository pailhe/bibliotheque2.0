<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
            ])
            ->add('nb_pages', IntegerType::class,[
                'required' => true,
            ])
            ->add('style', ChoiceType::class, [
                'choices' => [
                    'thriller' => 'thriller',
                    'roman' => 'roman',
                    'escroquerie' => 'escroquerie',
                    'biographie' => 'biographie',
                    'bande dessinée' => 'bande dessinnée'
                ],
                'required' => true,


            ])
            ->add('in_stock', CheckboxType::class, [
                'label' => 'En stock?',
            ])
            ->add('image', TextType::class, [
                'required' => false,
            ])
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
