<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/24/17
 * Time: 9:03 AM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\Type\EntityHiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\User;
use AppBundle\Entity\UserConversation;
use AppBundle\Entity\UserMessage;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('conversation', EntityHiddenType::class, [
                'class' => 'AppBundle:UserConversation', 'label' => false ])
            ->add('author', EntityHiddenType::class, [
                'class' => 'AppBundle:User', 'label' => false  ])
            ->add('text', TextareaType::class, [ 'required' =>true, 'label' => false ])
            ->add('save', SubmitType::class, array('label' => 'отправить'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => UserMessage::class,
        ));
    }
}