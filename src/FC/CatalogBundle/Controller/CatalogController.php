<?php

namespace FC\CatalogBundle\Controller;

use FC\CatalogBundle\Entity\Catalog;
use FC\CatalogBundle\Form\CatalogType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\Finder\Exception\AccessDeniedException;

/**
 * Catalog controller.
 *
 * @Route("catalog")
 * @Template()
 */
class CatalogController extends Controller
{
    /**
     * Lists all catalog entities.
     *
     * @Route("/", name="catalog_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $catalogs = $em->getRepository('CatalogBundle:Catalog')->findAll();

        return array(
            'catalogs' => $catalogs,
        );
    }

    /**
     * Creates a new catalog entity.
     *
     * @Route("/new", name="catalog_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $securityContext = $this->get('security.context');
        if(!$securityContext->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException("Session for admin only");
        }
        $catalog = new Catalog();
        $form = $this->createForm(new CatalogType(), $catalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->get('security.context')->getToken()->getUser();
            $catalog->setAuthor($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($catalog);
            $em->flush();

            return $this->redirect($this->generateUrl('catalog_show', array('id' => $catalog->getId())));
        }

        return array(
            'catalog' => $catalog,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a catalog entity.
     *
     * @Route("/{id}", name="catalog_show")
     * @Method("GET")
     */
    public function showAction(Catalog $catalog)
    {
        $deleteForm = $this->createDeleteForm($catalog);

        return array(
            'catalog' => $catalog,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing catalog entity.
     *
     * @Route("/{id}/edit", name="catalog_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Catalog $catalog)
    {
        $deleteForm = $this->createDeleteForm($catalog);
        $editForm = $this->createForm('FC\CatalogBundle\Form\CatalogType', $catalog);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('catalog_edit', array('id' => $catalog->getId()));
        }

        return array(
            'catalog' => $catalog,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a catalog entity.
     *
     * @Route("/{id}", name="catalog_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Catalog $catalog)
    {
        $form = $this->createDeleteForm($catalog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($catalog);
            $em->flush();
        }

        return $this->redirectToRoute('catalog_index');
    }

    /**
     * Creates a form to delete a catalog entity.
     *
     * @param Catalog $catalog The catalog entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Catalog $catalog)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('catalog_delete', array('id' => $catalog->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
