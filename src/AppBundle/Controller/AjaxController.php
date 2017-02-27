<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/10/17
 * Time: 7:01 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\Query;

class AjaxController extends Controller
{
    /**
     * @Route ("/ajax/login", name="ajax_login")
     */
    public function loginAction(Request $request)
    {
        $loginController = $this->get('dimad_security_controller');
        $loginController->setContainer($this->container);
        $loginForm = $loginController->loginAction($request)->getContent();

        $registerController = $this->get('dimad_registration_controller');
        $registerController->setContainer($this->container);
        $registerForm = $registerController->registerAction($request)->getContent();

        return $this->render('@App/default/auth-modal.html.twig',
            ['loginForm' => $loginForm, 'registerForm' => $registerForm]);
    }

    /**
     * @Route("ajax/regions", name="ajax_regions", options = { "expose" = true })
     * @Method({"POST"})
     */
    public function getRegionListAction(Request $request)
    {
        $countryId = $request->get('countryId');
        $em = $this->getDoctrine()->getRepository('AppBundle:Location\Region');
        $qb = $em->createQueryBuilder('r')
            ->where('r.country = :id')
            ->setParameter('id', $countryId)
            ->getQuery();

        $regions = $qb->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse(['regions' => $regions]);
    }

    /**
     * @Route("ajax/cities", name="ajax_cities", options = { "expose" = true })
     * @Method({"POST"})
     */
    public function getCityListAction(Request $request)
    {
        $regionId = $request->get('regionId');
        $em = $this->getDoctrine()->getRepository('AppBundle:Location\City');
        $qb = $em->createQueryBuilder('c')
            ->where('c.region = :id')
            ->setParameter('id', $regionId)
            ->getQuery();

        $cities = $qb->getResult(Query::HYDRATE_ARRAY);

        return new JsonResponse(['cities' => $cities]);
    }

}