<?php

namespace App\Form;

use App\Entity\Proposal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProposalType extends AbstractType
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
                'label' => $this->translator->trans('title'),
                'attr' => ['placeholder' => $this->translator->trans('title')]
            ])
            ->add('description', TextType::class, [
                'label' => $this->translator->trans('description'),
                'attr' => ['placeholder' => $this->translator->trans('title')]
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $formEvent) {
            $proposal = $formEvent->getData();
            $form = $formEvent->getForm();

            if ($proposal->getImage() !== null) {
                $form->add('image', FileType::class, [
                    'data_class' => null,
                    'required' => false,
                    'label' => $this->translator->trans('image_and_formats'),
                    'constraints' => [
                        new File([
                            'maxSize' => '10m',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif'
                            ],
                            'mimeTypesMessage' => $this->translator->trans('please_upload_valid_image_format'),
                        ])
                    ],
                    'attr' => ['accept' => 'image/jpeg, image/png, image/gif']
                ]);
            } else {
                $form->add('image', FileType::class, [
                    'data_class' => null,
                    'required' => true,
                    'label' => $this->translator->trans('image_and_formats'),
                    'constraints' => [
                        new File([
                            'maxSize' => '10m',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/gif'
                            ],
                            'mimeTypesMessage' => $this->translator->trans('please_upload_valid_image_format'),
                        ])
                    ],
                    'attr' => ['accept' => 'image/jpeg, image/png, image/gif']
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Proposal::class,
        ]);
    }
}
