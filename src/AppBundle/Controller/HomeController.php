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
        $filters = array_keys($request->query->all());
        $em = $this->getDoctrine()->getRepository('AppBundle:Event');

        if ($filters) {
            $qb = $em->createQueryBuilder('e');
            $allEvents = $qb->innerJoin('e.event_tags', 't')
                ->add('where', $qb->expr()->orX(
                    $qb->expr()->in('t.name', $filters)
                ))
                ->orderBy('e.id','desc')
                ->getQuery()
                ->getResult();
        } else {
            $allEvents = $em->findAll();
        }
        $allTags = $this->getDoctrine()
            ->getRepository('AppBundle:EventTag')
            ->findAll();

        return $this->render('@App/default/index.html.twig', [
            'events' => $allEvents,
            'tags' => $allTags
        ]);
    }
}