<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/23/17
 * Time: 2:43 PM
 */

namespace AppBundle\Controller;

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


class ConversationController extends Controller
{
    /**
     * @Route("user/{id}/conversations", requirements={"id" : "\d+"}, name="user_conversations")
     */
    public function listAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
            ->find(2);
        $conversations = $user->getConversations();

        return $this->render('@App/default/user-cabinet/user-conversations.html.twig', [
            'conversations' => $conversations
        ]);
    }

    /**
     * @Route("user/{idUser}/conversation/{idConversation}",
     *      requirements={"idUser" : "\d+", "idConversation": "\d+"}, name="conversation")
     */
    public function viewAction(Request $request, $idUser, $idConversation)
    {
        $conversation = $this->getDoctrine()->getRepository('AppBundle:UserConversation')
            ->find($idConversation);
        $messages = $conversation->getMessages();

        return $this->render('@App/default/user-cabinet/conversation.html.twig', [
            'messages' => $messages
        ]);
    }
}