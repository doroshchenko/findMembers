<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 1/17/17
 * Time: 1:39 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Gardener;

/**
 * @Route("/garden")
 * Class GardenerController
 * @package AppBundle\Controller
 *
 */
class GardenerController extends Controller
{
    /**
     * @Route("/save")
     */
    public function saveGardenerAction()
    {
        $gardener = new Gardener();
        $gardener->setName('victor');
        $gardener->setAge(44);
        $gardener->setWorkExperience(12);
        $em = $this->getDoctrine()->getManager();
        $em->persist($gardener);
        $em->flush();
    }

    /**
     * @Route("/show")
     */
    public function showGardenersAction()
    {
        $gardeners = $this->getDoctrine()
            ->getRepository('AppBundle:Gardener')
            ->findAll();

        $arr = function ($gardeners) {
            foreach ($gardeners as $gardener) {
                yield $gardener->getName();
            }
        };
        foreach ($arr($gardeners) as $gardener) {
            echo $gardener .'<br>';
        }

    }
}