<?php

namespace App\Form\Admin;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $roles = [
            'Super Admin'   => 'ROLE_SUPER_ADMIN',
            'Admin'         => 'ROLE_ADMIN',
            'Editor'        => 'ROLE_EDITOR',
            'User'          => 'ROLE_USER'
        ];

        $builder
            ->add('email', TextType::class, [
                'required' => true
            ])
            ->add('username', TextType::class, [
                'required' => true
            ])
            ->add('isVerified', CheckboxType::class, [
                'required' => true
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Roles',
                'choices' => $roles,
                'required' => true,
                'multiple' => true,
                'expanded' => true
            ])
        ;
        if ($options['mode'] == 'creation' || $options['mode'] == 'password_reset') {
            
            $builder->add('password', PasswordType::class, [
                'required' => true,
                'hash_property_path' => 'password',
                'mapped' => false,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'mode' => 'edition',
        ]);
    }
}
