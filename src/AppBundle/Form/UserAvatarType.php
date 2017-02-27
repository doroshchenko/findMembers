<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/27/17
 * Time: 6:20 PM
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
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UserAvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, ['label' => false ])
            ->add('save', SubmitType::class, array('label' => 'отправить'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}