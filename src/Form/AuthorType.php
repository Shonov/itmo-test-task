<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions = [
            'attr' => ['class' => 'form__field'],
            'label_attr' => ['class' => 'form__label'],
            'row_attr' => ['class' => 'form__row'],
        ];

        $builder
            ->add('firstName', TextType::class, $fieldOptions)
            ->add('lastName', TextType::class, $fieldOptions)
            ->add('middleName', TextType::class, $fieldOptions)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
