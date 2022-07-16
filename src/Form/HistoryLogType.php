<?php

namespace App\Form;

use App\Entity\HistoryLog;
use DateTime;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class HistoryLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('export_name')
            ->add('export_date', DateTimeType::class,  ['widget' => 'single_text',])
            ->add('user_name')
            ->add('location');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HistoryLog::class,
        ]);
    }
}
