<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 11:12 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventController extends Controller
{

    /**
     * @Route("/event/create", name="create-event")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $event = new Event();
        $form = $this->createFormBuilder($event)
            ->add('title', TextType::class)
            ->add('author', EntityType::class, [
                'class' => 'AppBundle:User', 'choice_label' => 'id'])
            ->add('people_needed', RangeType::class, ['label' => 'Нужно человек'])
            ->add('country', EntityType::class, [
                'class' => 'AppBundle:Location\Country', 'choice_label' => 'name'])
            ->add('text', TextType::class)
            ->add('event_date_time', TextType::class)
            ->add('event_tags', null,
                ['expanded' => 'true', 'multiple' => 'true', 'choice_label' => 'name'])
            ->add('save', SubmitType::class, array('label' => 'create event'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('user_events');
        }

        return $this->render(
            '@App/default/event/create-event.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function saveAction()
    {

    }


}