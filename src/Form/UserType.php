<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, [
                'label' => $this->translator->trans('Nom d\'utilisateur'),
                'attr' => ['placeholder' => $this->translator->trans('Nom d\'utilisateur') . '...']
            ])
            ->add('firstName', TextType::class, [
                'label' => $this->translator->trans('Prénom'),
                'attr' => ['placeholder' => $this->translator->trans('Prénom') . '...']
            ])
            ->add('lastName', TextType::class, [
                'label' => $this->translator->trans('Nom'),
                'attr' => ['placeholder' => $this->translator->trans('Nom') . '...']
            ])
            ->add('roles', ChoiceType::class, [
                'label' => $this->translator->trans('Rôles'),
                'choices' => [
                    $this->translator->trans('Administrateur') => 'ROLE_ADMIN',
                    $this->translator->trans('Super administrateur') => 'ROLE_SUPER_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
