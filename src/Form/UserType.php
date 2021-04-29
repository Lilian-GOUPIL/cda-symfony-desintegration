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
                'label' => $this->translator->trans('username'),
                'attr' => ['placeholder' => $this->translator->trans('username')]
            ])
            ->add('firstName', TextType::class, [
                'label' => $this->translator->trans('first_name'),
                'attr' => ['placeholder' => $this->translator->trans('first_name')]
            ])
            ->add('lastName', TextType::class, [
                'label' => $this->translator->trans('last_name'),
                'attr' => ['placeholder' => $this->translator->trans('last_name')]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => $this->translator->trans('roles'),
                'choices' => [
                    $this->translator->trans('admin') => 'ROLE_ADMIN',
                    $this->translator->trans('super_admin') => 'ROLE_SUPER_ADMIN'
                ],
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
