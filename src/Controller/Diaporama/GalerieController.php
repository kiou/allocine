<?php

namespace App\Controller\Diaporama;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\TranslatorInterface;
use App\Form\Diaporama\GalerieType;
use App\Entity\Diaporama\Galerie;
use App\Entity\Diaporama\Categorie;
use App\Utilities\Recherche;
use App\Entity\General\Langue;

class GalerieController extends Controller
{
    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {
        $galerie = new Galerie;
        $form = $this->createForm(GalerieType::class, $galerie);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galerie->uploadImage();
            $galerie->getReferencement()->uploadOgimage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($galerie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Galerie d\'image enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_diaporama_manager'));
        }

        return $this->render('Diaporama/Admin/ajouter.html.twig',
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
        $recherches = $recherche->setRecherche('diaporama_manager', array(
                'recherche',
                'langue'
            )
        );

        /* La liste des galeries d'images */
        $galeries = $this->getDoctrine()
                         ->getRepository(Galerie::class)
                         ->getAllGaleries($recherches['recherche'], null, $recherches['langue'], true);

        $pagination = $paginator->paginate(
            $galeries, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('Diaporama/Admin/manager.html.twig',array(
                'pagination' => $pagination,
                'recherches' => $recherches,
                'langues' => $langues
            )
        );
    }

    /**
     * Publication
     */
    public function publierAdmin(Request $request, Galerie $galerie){

        if($request->isXmlHttpRequest()){
            $state = $galerie->reverseState();
            $galerie->setIsActive($state);

            $em = $this->getDoctrine()->getManager();
            $em->persist($galerie);
            $em->flush();

            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Galerie $galerie)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($galerie);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Galerie d\'image supprimée avec succès');
        return $this->redirect($this->generateUrl('admin_diaporama_manager'));
    }

    /**
     * Poid
     */
    public function poidAdmin(Request $request, Galerie $galerie, $poid){

        if($request->isXmlHttpRequest()){
            $galerie->setPoid($poid);

            $em = $this->getDoctrine()->getManager();
            $em->persist($galerie);
            $em->flush();

            return new JsonResponse(array('status' => 'succes'));
        }

    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Galerie $galerie)
    {
        $form = $this->createForm(GalerieType::class, $galerie);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $galerie->uploadImage();
            $galerie->getReferencement()->uploadOgimage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($galerie);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Galerie d\'image enregistrée avec succès');
            return $this->redirect($this->generateUrl('admin_diaporama_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des galeries d\'images' => $this->generateUrl('admin_diaporama_manager'),
            'Modifier une galerie d\'image' => ''
        );

        return $this->render('Diaporama/Admin/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'galerie' => $galerie,
                'form' => $form->createView()
            )
        );

    }

    /**
     * Supprimer l'image
     */
    public function AdminSupprimerImage(Request $request, Galerie $galerie)
    {
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $galerie->setImage(null);
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
        $recherches = $recherche->setRecherche('galeries-images', array(
                'categorie',
            )
        );

        /* La liste des galeries d'images */
        $galeries = $this->getDoctrine()
                         ->getRepository(Galerie::class)
                         ->getAllGaleries(null, $recherches['categorie'], $request->getLocale(), false);

        /* La liste des catégories */
        $categories = $this->getDoctrine()
                           ->getRepository(Categorie::class)
                           ->getAllCategories($request->getLocale());

        $pagination = $paginator->paginate(
            $galeries, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            9 /*limit per page*/
        );

        return $this->render('Diaporama/manager.html.twig', array(
                'pagination' => $pagination,
                'categories' => $categories,
                'recherches' => $recherches
            )
        );
    }

    /**
     * View
     */
    public function viewClient($id, TranslatorInterface $translator)
    {
        /* galerie d'image en cours */
        $galerie = $this->getDoctrine()
                        ->getRepository(Galerie::class)
                        ->getCurrentGalerie($id);

        if(is_null($galerie)) throw new NotFoundHttpException('Cette page n\'est pas disponible');

        /* BreadCrumb */
        $breadcrumb = array(
            $translator->trans('diaporama.client.view.breadcrumb.niveau1') => $this->generateUrl('client_diaporama_manager'),
            $galerie->getTitre() => ''
        );

        return $this->render( 'Diaporama/view.html.twig',array(
                'galerie' => $galerie,
                'breadcrumb' => $breadcrumb
            )
        );
    }

    /**
     * Block template
     */
    public function lastGalerie(Request $request, $limit)
    {

        $galeries = $this->getDoctrine()
                         ->getRepository(Galerie::class)
                         ->getAllGaleries(null, null, $request->getLocale(), false, $limit);

        return $this->render( 'Diaporama/Include/liste.html.twig',array(
                'galeries' => $galeries
            )
        );

    }

}
