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
        $fosLogin = $this->get('fos_security_controller');
        $fosLogin->setContainer($this->container);
        $loginForm = $fosLogin->loginAction($request)->getContent();

        $fosRegister = $this->get('fos_registration_controller');
        $fosRegister->setContainer($this->container);
        $registerForm = $fosRegister->registerAction($request)->getContent();

        return $this->render('@App/default/auth-modal.html.twig',
            ['loginForm' => $loginForm, 'registerForm' => $registerForm]);
    }


}