<?php

namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Utilities\Recherche;
use App\Entity\Page\Page;
use App\Entity\General\Langue;
use App\Form\Page\PageType;

class PageController extends Controller{
    
    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {
        $page = new Page;
        $form = $this->createForm(PageType::class, $page);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $page->getReferencement()->uploadOgimage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Page enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_page_manager'));
        }

        return $this->render('Page/Admin/ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Gestion
     */
    public function managerAdmin(Request $request, Recherche $recherche, PaginatorInterface $paginator)
    {
        /* Services */
        $recherches = $recherche->setRecherche('page_manager', array(
                'recherche',
                'langue'
            )
        );

        /* La liste des pages */
        $pages = $this->getDoctrine()
                      ->getRepository(Page::class)
                      ->getAllPages($recherches['recherche'], $recherches['langue']);

        $pagination = $paginator->paginate(
            $pages, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render( 'Page/Admin/manager.html.twig', array(
                'pagination' => $pagination,
                'recherches' => $recherches,
                'langues' => $langues
            )
        );

    }

    /**
     * Publication
     */
    public function publierAdmin(Request $request, Page $page){

        if($request->isXmlHttpRequest()){
            $state = $page->reverseState();
            $page->setIsActive($state);

            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Page $page)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($page);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Page supprimée avec succès');
        return $this->redirect($this->generateUrl('admin_page_manager'));
    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Page $page)
    {
        $form = $this->get('form.factory')->create(PageType::class, $page);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $page->getReferencement()->uploadOgimage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Page enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_page_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des pages' => $this->generateUrl('admin_page_manager'),
            'Modifier une page' => ''
        );

        return $this->render('Page/Admin/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'page' => $page,
                'form' => $form->createView()
            )
        );

    }

    /**
     * Poid
     */
    public function poidAdmin(Request $request, Page $page, $poid){

        if($request->isXmlHttpRequest()){
            $page->setPoid($poid);

            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();

            return new JsonResponse(array('status' => 'succes'));
        }

    }

    /*
    * View
    */
    public function viewClient(Page $page)
    {
        if(!$page->getIsActive()) throw new NotFoundHttpException('Cette page n\'est pas disponible');

        return $this->render( 'Page/view.html.twig',array(
                'page' => $page
            )
        );
    }

}

?>