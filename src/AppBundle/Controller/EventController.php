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
use Symfony\Component\HttpFoundation\Request;


class EventController extends Controller
{

    /**
     * @Route("/event/create", name="create-event")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createEventAction()
    {
        return $this->render('@App/default/event/create-event.html.twig');
    }
}