<?php
/**
 * Created by PhpStorm.
 * User: tri.tran
 * Date: 6/8/2018
 * Time: 4:42 PM
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AuthorFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['constraints' => [new NotBlank()], 'attr' => ['class' => 'form-control']]);
        $builder->add('title', TextType::class, ['constraints' => [new NotBlank()], 'attr' => ['class' => 'form-control']]);
        $builder->add('company', TextType::class, ['constraints' => [new NotBlank()], 'attr' => ['class' => 'form-control']]);
        $builder->add('shortBio', TextareaType::class, ['constraints' => [new NotBlank()], 'attr' => ['class' => 'form-control']]);
        $builder->add('phone', TextType::class, ['attr' => ['class' => 'form-control']]);
        $builder->add('facebook', TextType::class, ['attr' => ['class' => 'form-control']]);
        $builder->add('twitter', TextType::class, ['attr' => ['class' => 'form-control']]);
        $builder->add('github', TextType::class, ['attr' => ['class' => 'form-control']]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'App\Entity\Author']);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'author_form';
    }

}