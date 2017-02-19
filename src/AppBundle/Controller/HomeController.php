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
    public function indexAction()
    {
        $allEvents = $this->getDoctrine()
            ->getRepository('AppBundle:Event')
            ->findBy([], ['id' => 'DESC']);

        return $this->render('@App/default/index.html.twig', [
            'events' => $allEvents
        ]);
    }
}