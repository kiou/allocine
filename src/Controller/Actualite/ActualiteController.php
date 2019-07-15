<?php

namespace App\Controller\Actualite;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use App\Form\Actualite\ActualiteType;
use App\Entity\Actualite\Categorie;
use App\Entity\Actualite\Actualite;
use App\Entity\General\Langue;
use App\Utilities\Recherche;

class ActualiteController extends Controller
{
    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {
        $actualite = new Actualite;
        $form = $this->createForm(ActualiteType::class, $actualite);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualite->uploadImage();
            $actualite->getReferencement()->uploadOgimage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($actualite);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Actualité enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_actualite_manager'));
        }

        return $this->render('Actualite/Admin/ajouter.html.twig',
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
        $recherches = $recherche->setRecherche('actualite_manager', array(
                'recherche',
                'langue'
            )
        );

        /* La liste des actualités */
        $actualites = $this->getDoctrine()
                           ->getRepository(Actualite::class)
                           ->getAllActualites($recherches['recherche'], $recherches['langue'], null, true);

        $pagination = $paginator->paginate(
            $actualites, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('Actualite/Admin/manager.html.twig',array(
                'pagination' => $pagination,
                'recherches' => $recherches,
                'langues' => $langues
            )
        );
    }

    /**
     * Publication
     */
    public function publierAdmin(Request $request, Actualite $actualite){

        if($request->isXmlHttpRequest()){
            $state = $actualite->reverseState();
            $actualite->setIsActive($state);

            $em = $this->getDoctrine()->getManager();
            $em->persist($actualite);
            $em->flush();

            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Actualite $actualite)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($actualite);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Actualité supprimée avec succès');
        return $this->redirect($this->generateUrl('admin_actualite_manager'));
    }

    /**
     * Poid
     */
    public function poidAdmin(Request $request, Actualite $actualite, $poid){

        if($request->isXmlHttpRequest()){
            $actualite->setPoid($poid);

            $em = $this->getDoctrine()->getManager();
            $em->persist($actualite);
            $em->flush();

            return new JsonResponse(array('status' => 'succes'));
        }

    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Actualite $actualite)
    {
        $form = $this->createForm(ActualiteType::class, $actualite);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualite->uploadImage();
            $actualite->getReferencement()->uploadOgimage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($actualite);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Actualité enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_actualite_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des actualités' => $this->generateUrl('admin_actualite_manager'),
            'Modifier une actualité' => ''
        );

        return $this->render('Actualite/Admin/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'actualite' => $actualite,
                'form' => $form->createView()
            )
        );

    }

    /**
     * Supprimer l'image
     */
    public function AdminSupprimerImage(Request $request, Actualite $actualite)
    {
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $actualite->setImage(null);
            $em->flush();

            return new JsonResponse(array('state' => 'ok'));
        }
    }

    /**
     * Manager client
     */
    public function managerClient(Request $request, Recherche $recherche, PaginatorInterface $paginator)
    {
        /* Services */
        $recherches = $recherche->setRecherche('actualites', array(
                'categorie',
            )
        );

        /* La liste des actualités */
        $actualites = $this->getDoctrine()
                           ->getRepository(Actualite::class)
                           ->getAllActualites(null, $request->getLocale(), $recherches['categorie'], false);

        /* L'actualité mise en avant */
        $avant = $this->getDoctrine()
                      ->getRepository(Actualite::class)
                      ->getAvantActualite($request->getLocale());

        /* La liste des catégories */
        $categories = $this->getDoctrine()
                           ->getRepository(Categorie::class)
                           ->getAllCategorie($request->getLocale());

        $pagination = $paginator->paginate(
            $actualites, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            9 /*limit per page*/
        );

        return $this->render('Actualite/manager.html.twig', array(
                'pagination' => $pagination,
                'categories' => $categories,
                'recherches' => $recherches,
                'avant' => $avant
            )
        );
    }

    /*
     * View
     */
    public function viewClient($id, TranslatorInterface $translator)
    {
        /* Actualité en cours */
        $actualite = $this->getDoctrine()
                          ->getRepository(Actualite::class)
                          ->getCurrentActualite($id);

        if(is_null($actualite)) throw new NotFoundHttpException('Cette page n\'est pas disponible');

        /* BreadCrumb */
        $breadcrumb = array(
            $translator->trans('actualite.client.manager.breadcrumb.niveau1') => $this->generateUrl('client_actualite_manager'),
            $actualite->getTitre() => ''
        );

        return $this->render( 'Actualite/view.html.twig',array(
                'actualite' => $actualite,
                'breadcrumb' => $breadcrumb
            )
        );
    }

    /**
     * Block template
     */
    public function lastActualite(Request $request, $limit)
    {
        $actualites = $this->getDoctrine()
                           ->getRepository(Actualite::class)
                           ->getAllActualites(null, $request->getLocale(), null, false, $limit);

        return $this->render( 'Actualite/Include/liste.html.twig',array(
                'actualites' => $actualites
            )
        );
    }
}
