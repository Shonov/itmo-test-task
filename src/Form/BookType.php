<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form__field'],
                'label_attr' => ['class' => 'form__label'],
                'row_attr' => ['class' => 'form__row'],
            ])
            ->add('publicationDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Publication Year',
                'attr' => ['class' => 'form__field form__field--year'],
                'label_attr' => ['class' => 'form__label'],
                'row_attr' => ['class' => 'form__row'],
            ])
            ->add('isbn', TextType::class, [
                'attr' => ['class' => 'form__field'],
                'label_attr' => ['class' => 'form__label'],
                'row_attr' => ['class' => 'form__row'],
            ])
            ->add('pageCount', NumberType::class, [
                'attr' => ['class' => 'form__field'],
                'label_attr' => ['class' => 'form__label'],
                'row_attr' => ['class' => 'form__row'],
            ])
            ->add('image', FileType::class, [
                'attr' => ['class' => 'form__field form__field--upload-images'],
                'label_attr' => ['class' => 'form__label'],
                'row_attr' => ['class' => 'form__row'],
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid png or jpeg image',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
