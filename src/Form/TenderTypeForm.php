<?php

namespace App\Form;

use App\Entity\Tender;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TenderTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('externalCode')
            ->add('number')
            ->add('status')
            ->add('name')
            ->add('updatedAt', DateType::class, [
                'widget' => 'single_text',
                'html5' => true,
                'label' => 'Дата изменения',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tender::class,
        ]);
    }
}
