<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/10/17
 * Time: 7:01 AM
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\SecurityController;

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


}