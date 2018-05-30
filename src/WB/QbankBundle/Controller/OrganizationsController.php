<?php

namespace WB\QbankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WB\QbankBundle\Form\Type\OrganizationsType;
use WB\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WB\QbankBundle\Entity\Organizations;
use WB\QbankBundle\Enums\ActiveButtons;

class OrganizationsController extends Controller
{

    public function organizationsAction($publishedOnly, $search, Request $request)
    {
        $excludedIds = $request->request->get('excludedIds');

        $showPublishedOnly = ($publishedOnly == 'true') ? true : false;

        $paramPublished = $showPublishedOnly ? 1 : false;

        $repository = $this->getDoctrine()->getRepository("WBQbankBundle:Organizations");

        $organizations = $repository->searchOrganizations($paramPublished, $search, $excludedIds);

        return $this->render('@WBQbank/Organizations/organizations.html.twig', array(
            'active_button' => ActiveButtons::AdminOrganizations,
            'organizations' => $organizations
        ));
    }

    public function addOrganizationAction(Request $request)
    {

        $organization = new Organizations();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new OrganizationsType(), $organization);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $date = new \DateTime("now");
            $organization->setChanged($date);
            $organization->setCreated($date);
            $organization->setPublished(0);
            $em->persist($organization);
            $em->flush();

            return $this->redirect($this->generateUrl('organizations'));
        }

        return $this->render('@WBQbank/Organizations/addOrganization.html.twig', array(
            'form' => $form->createView(),
            'active_button' => ActiveButtons::AdminOrganizations
        ));

    }

    public function editOrganizationAction($id, Request $request)
    {
        // get organization by id
        $organization = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Organizations')
            ->find($id);

        if (!$organization) {
            throw $this->createNotFoundException(
                'No Organization found'
            );
        }

        // form
        $form = $this->createForm(new OrganizationsType(), $organization);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirect($this->generateUrl('organizations'));
        }

        return $this->render('WBQbankBundle:Organizations:editOrganization.html.twig', array(
            'form' => $form->createView(),
            'organizationId' => $id,
            'active_button' => ActiveButtons::AdminOrganizations
        ));
    }

    public function deleteOrganizationAction($id)
    {
        // find organization by id
        $em = $this->getDoctrine()->getManager();
        $organization = $em->getRepository('WBQbankBundle:Organizations')
            ->findOneById($id);

        if (!$organization) {
            throw $this->createNotFoundException(
                'No Organization found'
            );
        }

        // delete organization
        $em->remove($organization);
        $em->flush();
        return new Response('ok');
    }

    public function batchDeleteOrganizationsAction(Request $request)
    {
        $ids = $this->get('request')->request->get('ids');

        // find organizations by ids
        $em = $this->getDoctrine()->getManager();
        $organizations = $em->getRepository('WBQbankBundle:Organizations');

        if(count($ids)) {
            foreach($ids as $organizationId) {
                $em->remove($organizations->find($organizationId));
            }
        }

        if (!$organizations) {
            throw $this->createNotFoundException(
                'No Organizations found'
            );
        }

        // delete organizations
        $em->flush();
        return new Response('ok');
    }
    public function publishUnpublishAction($id, $publish)
    {

        $em = $this->getDoctrine()->getManager();
        $publish = (boolean)$publish;
        $entity = $em->getRepository('WBQbankBundle:Organizations')->findOneBy(["id" => $id]);

        $entity->setPublished($publish);
        $em->flush();

        return new Response("ok");
    }

}
