<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/13/17
 * Time: 11:12 AM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\EventTag;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityNotFoundException;
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
use AppBundle\Form\EventType;
use Doctrine\ORM\Query;

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

        $form = $this->createForm(EventType::class, $event);

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
     * @param Request $request
     * @Route("event/{eventId}/edit", requirements={"eventId": "\d+"}, name="edit_event")
     *
     */
    public function editEventAction(Request $request, $eventId)
    {
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')->find($eventId);
        if (!$event) {
            throw new EntityNotFoundException('event is not found');
        }

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
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
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('homepage');
        }
        $userId = $this->getUser()->getId();
        $requestId = $request->get('id');
        if ($requestId != $userId) {
            return $this->redirectToRoute('homepage');
        }
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

    /**
     * @param Request $request
     * @Route("event/delete", name="delete_event")
     * @Method({"POST"})
     */
    public function deleteEventAction(Request $request)
    {
        $eventId = $request->get('eventId');
        if (!$eventId) {
            return new JsonResponse(['error' => 'missed eventId']);
        }
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')
            ->find($eventId);

        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return new JsonResponse(['ok' => true]);
    }

    /**
     * @param Request $request
     * @param $idEvent
     * @Route("/event/{idEvent}", requirements={"idEvent": "\d+"}, name="event")
     */
    public function  viewEventAction(Request $request, $idEvent)
    {
        $event = $this->getDoctrine()->getRepository('AppBundle:Event')->find($idEvent);

        return $this->render('@App/default/event/view-event.html.twig',[
            'event' => $event
        ]);
    }

    /**
     * @param Request $request
     * @Route("/event/find", name="find-event")
     */
    public function findEventAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $options = [];
        $options['tags'] = $em->getRepository('AppBundle:EventTag')
            ->createQueryBuilder('et')
            ->select()->getQuery()
            ->getResult(Query::HYDRATE_ARRAY);

        # hard code tag placeholder
            array_unshift($options['tags'], ['id'=>0, 'name' => 'Выберите теги']);
            $formatted = [];
            foreach ($options['tags'] as $k => $tag) {
                $formatted[$tag['name']] = $tag['id'];
            }
            $options['tags'] = $formatted;
            unset($formatted);
        # ------------------------

        $options['countries'] = $em->getRepository('AppBundle:Location\Country')->findAll();
        $options['membersRanges'] = ['< 3' => 1, '3 - 8' => 2, '> 8' => 3];
        $options['startRanges'] = ['1-3 дня' => 1, 'месяц' => 2, 'более' => 3];

        $defaultData = $options;
        $form = $this->createFormBuilder([])
            ->add('country', EntityType::class, [
                'class' => 'AppBundle:Location\Country',
                'label' => '#Страна',
                'placeholder' => 'Выберите страну', 'required' => false
            ])
            ->add('tags', ChoiceType::class, [
                'multiple' => true,
                'required' => false,
                'choice_attr' => function ($val, $key) {
                    if ($val == 'Выберите теги') {
                        return ['disabled selected' => 'disabled'];
                    } else return [];
                },
                'choices' => $options['tags']
            ])
            ->add('membersRanges', ChoiceType::class, [
                'placeholder' => 'Кол-во человек',
                'required' => false,
                'choices' => $options['membersRanges']
            ])
            ->add('startRanges', ChoiceType::class, [
                'placeholder' => 'До начала',
                'required' => false,
                'choices' => $options['startRanges']
            ])
            ->add('textSearch', TextType::class, [
                'required' => false,
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->getData()) {
            $filters = $form->getData();
            $qb = $em->getRepository('AppBundle:Event')->createQueryBuilder('e');
            $events = $qb->innerJoin('e.event_tags', 't')
                ->add('where', $qb->expr()->orX($qb->expr()->in('t.id', $filters['tags'])))
                ->innerJoin('e.country', 'c')
                ->where('c.name =?1')
                ->setParameters([1 => $filters['country']->getName()])
                ->orderBy('e.id','desc')
                ->getQuery()
                ->getResult();
        }
        return $this->render('@App/default/event/find-event.html.twig', [
            'events' => isset($events) ? $events : null,
            'form' => $form->createView()
        ]);
    }

}