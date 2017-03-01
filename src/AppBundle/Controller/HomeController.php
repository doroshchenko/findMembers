<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/9/17
 * Time: 2:50 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getRepository('AppBundle:Event');
        $filters = array_keys($request->query->all());

        if ($filters) {
            $qb = $em->createQueryBuilder('e');
            $allEvents = $qb->innerJoin('e.event_tags', 't')
                ->add('where', $qb->expr()->orX($qb->expr()->in('t.name', $filters)))
                ->orderBy('e.id','desc')
                ->getQuery()
                ->getResult();
        } else {
            $allEvents = $em->findBy([], ['id' => 'desc']);
        }

        $allTags = $this->getDoctrine()
            ->getRepository('AppBundle:EventTag')
            ->findAll();
        $unreadMsg = ($this->getUser())
            ? $unreadMsg = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->countUnreadMessages($this->getUser())
            : 0;
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')->findAll();

        return $this->render('@App/default/index.html.twig', [
            'events' => $allEvents,
            'tags' => $allTags,
            'unreadMsg' => $unreadMsg,
            'users' => $users
        ]);
    }
}