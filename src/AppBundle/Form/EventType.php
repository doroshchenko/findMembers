<?php

/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/22/17
 * Time: 12:20 PM
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Form\Type\EntityHiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Event;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('author', EntityHiddenType::class, [
                'class' => 'AppBundle:User', 'label' => false
            ])
            ->add('people_needed', RangeType::class, ['label' => 'Нужно человек'])
            ->add('country', EntityType::class, [
                'class' => 'AppBundle:Location\Country',
                'placeholder' => 'Страна',
                'choice_label' => 'name'])
            ->add('region', EntityType::class, [
                'placeholder' => 'Регион', 'class' => 'AppBundle:Location\Region',
                'choice_label' => 'name', 'required' => false])
            ->add('city', EntityType::class, [ 'placeholder' => 'Город', 'class' => 'AppBundle:Location\City',
                'required' => false, 'choice_label' => 'name'])
            ->add('text', TextAreaType::class)
            ->add('event_date_time', DateTimeType::class, ['date_widget' => 'single_text', 'time_widget' => 'single_text'])
            ->add('event_tags', null,
                ['multiple' => 'true', 'choice_label' => 'name'])
            ->add('save', SubmitType::class, array('label' => 'create event'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Event::class,
        ));
    }
}