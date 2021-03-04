<?php

namespace App\Form;

use App\Entity\Consultation;
use App\Entity\Topic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConsultationSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $locale = $options['locale'];
        $builder
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm',
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm',
            ])
            ->add('topic', EntityType::class, [
                'class' => Topic::class,
                'multiple' => true,
                'choice_label' => function (Topic $topic) use ($locale) {
                    if ($locale === 'es') {
                        $label = $topic->getDescriptionEs();
                    } else {
                        $label = $topic->getDescriptionEu();
                    };
                    return $label;
                }
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
