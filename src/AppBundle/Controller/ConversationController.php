<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/23/17
 * Time: 2:43 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserMessage;
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
use AppBundle\Form\MessageType;


class ConversationController extends Controller
{
    /**
     * show all user's dialogs
     * @Route("user/{id}/conversations", requirements={"id" : "\d+"}, name="user_conversations")
     */
    public function listAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
            ->find($id);
        $conversations = $user->getConversations();

        return $this->render('@App/default/user-cabinet/user-conversations.html.twig', [
            'conversations' => $conversations
        ]);
    }

    /**
     * show conversation
     *
     * @Route("user/{idUser}/conversation/{idConversation}",
     *      requirements={"idUser" : "\d+", "idConversation": "\d+"}, name="conversation")
     */
    public function viewAction(Request $request, $idUser, $idConversation)
    {
        $conversation = $this->getDoctrine()->getRepository('AppBundle:UserConversation')
            ->find($idConversation);
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
            ->find($idUser);

        if (!$conversation || !$user) {
            throw new Exception();
        }
        if (!$conversation->hasUser($user)) {
            throw new Exception();
        }

        $messages = $conversation->getMessages();

        $message = new UserMessage();
        $message->setConversation($conversation)
            ->setAuthor($this->getUser())
            ->setIsRead(false)
            ->setCreatedAt(new \DateTime("now"));

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('conversation',
                ['idUser' => $idUser, 'idConversation' => $idConversation]
            );
        }

        return $this->render('@App/default/user-cabinet/conversation.html.twig', [
            'messages' => $messages,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("user/{idUser}/conversation/{idConversation}/save",
     *      requirements={"idUser" : "\d+", "idConversation": "\d+"}, name="conversation_message_save")
     */
    public function  saveMessageAction(Request $request, $idUser, $idConversation)
    {
        $conversation = $this->getDoctrine()->getRepository('AppBundle:UserConversation')
            ->find($idConversation);

        $message = new UserMessage();
        $message->setConversation($conversation)
            ->setAuthor($this->getUser())
            ->setIsRead(false)
            ->setCreatedAt(new \DateTime("now"));

        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
        }

        return $this->redirectToRoute('conversation',
            ['idUser' => $idUser, 'idConversation' => $idConversation]
        );
    }

    /**
     * @param Request $request
     * @param $messageId
     * @Route("/message/{idMessage}/read", requirements={"idMessage": "\d+"},
     *      options = { "expose" = true },
     *      name="read-message")
     * @Method({"POST"})
     * @return JsonResponse
     */
    public function markMessageAsRead(Request $request, $idMessage)
    {
        $message = $this->getDoctrine()->getRepository('AppBundle:UserMessage')
            ->find($idMessage);

        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        try {
            $em->persist($message);
            $em->flush();

        } catch (\Exception $e ) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }

        return new JsonResponse(['ok' => true]);
    }
}