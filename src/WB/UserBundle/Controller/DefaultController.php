<?php

namespace WB\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WB\UserBundle\Entity\User;
use WB\UserBundle\Form\Type\UserType;
use WB\QbankBundle\Enums\ActiveButtons;

class DefaultController extends Controller
{
    public function indexAction($search)
    {
        $repository = $this->getDoctrine()->getRepository('WBUserBundle:User');

        $users = $repository->searchUsers($search);

        return $this->render('WBUserBundle:Default:index.html.twig', array(
            'users' => $users,
            'active_button' => ActiveButtons::AdminUsers
        ));
    }

    public function addUserAction(Request $request)
    {

        $user = new User();

        $form = $this->createForm(new UserType($this->get('security.context')->isGranted('ROLE_ADMIN')), $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            if($plainPass = $user->getPlainPassword()) {
                $encoded_pass = $encoder->encodePassword($plainPass, $user->getSalt());
                $user->setPassword($encoded_pass);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('wb_user_homepage'));
        }

        return $this->render('WBUserBundle:Default:addOrEditUser.html.twig', array(
            'form' => $form->createView(),
            'isEdit' => false,
            'active_button' => ActiveButtons::AdminUsers,
            'title' => 'Add User'
        ));
    }
    
    public function editUserAction($userId, Request $request)
    {
        // user by id
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('WBUserBundle:User')
            ->find($userId);
            
        // create form
        $form = $this->createForm(new UserType($this->get('security.context')->isGranted('ROLE_ADMIN')), $user);
            
        $form->handleRequest($request);
        
        // submitted form
        if ($form->isValid()) {
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            if($plainPass = $user->getPlainPassword()) {
                $encoded_pass = $encoder->encodePassword($plainPass, $user->getSalt());
                $user->setPassword($encoded_pass);
            }

            $em->flush();
            
            return $this->redirect($this->generateUrl('wb_user_homepage'));
        }

        return $this->render('WBUserBundle:Default:addOrEditUser.html.twig', array(
            'form' => $form->createView(),
            'isEdit' => true,
            'active_button' => ActiveButtons::AdminUsers,
            'title' => 'Edit User'
        ));
    }

    public function registerUserAction(Request $request){
        $user = new User();

        $form = $this->createForm(new UserType($this->get('security.context')->isGranted('ROLE_ADMIN')), $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $encoder_service = $this->get('security.encoder_factory');
            $encoder = $encoder_service->getEncoder($user);
            if($plainPass = $user->getPlainPassword()) {
                $encoded_pass = $encoder->encodePassword($plainPass, $user->getSalt());
                $user->setPassword($encoded_pass);
            }

            $user->setRoles(array('ROLE_USER'));
            $user->setEnabled(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        return $this->render('WBUserBundle:Default:registerUser.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function deleteUserAction($userId ,Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('WBUserBundle:User')
            ->find($userId);
        if($user){
            $em->remove($user);
            $em->flush();
        }

        return new Response('ok');
        //return $this->redirect($this->generateUrl('wb_user_homepage'));
    }
}
