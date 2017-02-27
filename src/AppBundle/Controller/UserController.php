<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 2/25/17
 * Time: 1:20 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserConversation;
use AppBundle\Entity\UserMessage;
use AppBundle\Form\MessageType;
use Doctrine\ORM\EntityNotFoundException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\HttpFoundation\Request;
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
use AppBundle\Form\UserAvatarType;
use Symfony\Component\HttpFoundation\File\File;

class UserController extends Controller
{
    /**
     * @Route("users/{id}", requirements={"id" : "\d+"}, name="user_profile")
     */
    public function viewProfileAction(Request $request, $id)
    {

        $message = new UserMessage();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $author = $em->find('AppBundle:User', $this->getUser()->getId());
            $reciever = $em->find('AppBundle:User', $id);

            $conversation = new UserConversation();
            $conversation->setTitle('title')
                ->addUser($author)
                ->addUser($reciever)
                ->setCreatedAt(new \DateTime("now"));

            $message->setConversation($conversation)
                ->setAuthor($this->getUser())
                ->setIsRead(false)
                ->setCreatedAt(new \DateTime("now"));

            $conversation->addMessage($message);
            $em = $this->getDoctrine()->getManager();
            $em->persist($conversation);
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('conversation',
                ['idUser' => $author->getId(), 'idConversation' => $conversation->getId()]
            );
        }

        ## user image form
        if ($this->getUser()) {
            $user = $this->getUser();
            if ($user->getImage()) {
                $user->setImage(
                    new File($this->getParameter('user_avatar_directory').'/'.$user->getImage())
                );
            }
            $avatarForm = $this->createForm(UserAvatarType::class, $user);
            $avatarForm->handleRequest($request);
            if ($avatarForm->isSubmitted() && $avatarForm->isValid()) {
                $file = $user->getImage();
                $fileName = 'user-'.$user->getId().'.'.$file->guessExtension();
                $file->move(
                    $this->getParameter('user_avatar_directory'),
                    $fileName
                );
                $user->setImage($fileName);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
            }
        }
        $user = $this->getDoctrine()->getRepository("AppBundle:User")->find($id);
        return $this->render('@App/default/user-profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'avatarForm' => ($avatarForm) ? $avatarForm->createView() : null
        ]);
    }

    public function uploadImageAction(Request $request, $userId)
    {
        $image = $request->get('');
    }


}