<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 11:12 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Event;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\Type\EntityHiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class EventController extends Controller
{

    /**
     * @Route("/event/create", name="create-event")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $event = new Event();
        $author = $this->getDoctrine()->getRepository('AppBundle:User')
            ->find($this->getUser()->getId());
        $event->setAuthor($author);

        $form = $this->createFormBuilder($event)
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
            ->add('text', TextType::class)
            ->add('event_date_time', DateTimeType::class, ['date_widget' => 'single_text', 'time_widget' => 'single_text'])
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

            return $this->redirectToRoute('user_events',[
                'id' => $event->getAuthor()->getId()
            ]);
        }

        return $this->render(
            '@App/default/event/create-event.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/events/user/{id}", requirements={"id": "\d+"}, name="user_events")
     */
    public function userEventsListAction(Request $request)
    {
        $userId = $request->get('id');
        $repository = $this->getDoctrine()->getRepository('AppBundle:Event');
        $events = $repository->findBy(['author' => $userId], ['id' => 'DESC']);
        return $this->render('@App/default/event/user-events.html.twig', [
            'events' => $events
        ]);

    }

    /**
     * @Route("/event/join", name="join_event")
     * @Method({"POST"})
     */
    public function joinEventAction(Request $request)
    {
        $member = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find((int)($request->get('user')));
        $event = $this->getDoctrine()
            ->getRepository('AppBundle:Event')
            ->find((int)$request->get('event'));

        if ($event->isMember($member)) {
            $event->removeMember($member);
        } else {
            $event->addMember($member);
        }

        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
        } catch(Exception $e) {
            return new JsonResponse(['server_error' => $e->getMessage()]);
        }

        return new JsonResponse(['ok' => true]);
    }

}