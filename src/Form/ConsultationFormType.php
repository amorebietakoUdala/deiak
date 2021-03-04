<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Topic;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConsultationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locale = $options['locale'];
        $builder
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm',
                'constraints' => [new NotBlank()],
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm',
                'empty_data' => (new DateTime())->format('Y-m-d H:i'),
            ])
            ->add('topic', EntityType::class, [
                //                'class' => 'App:Topic',
                'class' => Topic::class,
                'choice_label' => function (?Topic $topic) use ($locale) {
                    if ($locale == 'es') {
                        return $topic->getDescriptionEs();
                    } else {
                        return $topic->getDescriptionEu();
                    }
                },
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consultation::class,
            'locale' => 'eu',
        ]);
    }
}
