<?php

namespace App\Controller\Evenement;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\TranslatorInterface;
use App\Form\Evenement\EvenementType;
use App\Entity\Evenement\Evenement;
use App\Entity\Evenement\Categorie;
use App\Utilities\Recherche;
use App\Utilities\Agenda;
use App\Utilities\Tool;
use App\Entity\General\Langue;

class EvenementController extends Controller
{
    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {
        $evenement = new Evenement;
        $form = $this->createForm(EvenementType::class, $evenement);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->getReferencement()->UploadOgimage();
            $evenement->uploadImage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Evénement enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_evenement_manager'));
        }

        return $this->render('Evenement/Admin/ajouter.html.twig',
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
        $recherches = $recherche->setRecherche('evenement_manager', array(
                'recherche',
                'langue'
            )
        );

        /* La liste des événements */
        $evenements = $this->getDoctrine()
                           ->getRepository(Evenement::class)
                           ->getAllEvenements($recherches['recherche'], $recherches['langue'], null, true);

        $pagination = $paginator->paginate(
            $evenements, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('Evenement/Admin/manager.html.twig',array(
                'pagination' => $pagination,
                'recherches' => $recherches,
                'langues' => $langues
            )
        );
    }

    /**
     * Publication
     */
    public function publierAdmin(Request $request, Evenement $evenement){

        if($request->isXmlHttpRequest()){
            $state = $evenement->reverseState();
            $evenement->setIsActive($state);

            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Evenement $evenement)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Evenement supprimé avec succès');
        return $this->redirect($this->generateUrl('admin_evenement_manager'));
    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Evenement $evenement)
    {
        $form = $this->createForm(EvenementType::class, $evenement);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->getReferencement()->UploadOgimage();
            $evenement->uploadImage();

            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Evenement enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_evenement_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des événements' => $this->generateUrl('admin_evenement_manager'),
            'Modifier un événement' => ''
        );

        return $this->render('Evenement/Admin/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'evenement' => $evenement,
                'form' => $form->createView()
            )
        );

    }

    /**
     * Supprimer l'image
     */
    public function AdminSupprimerImage(Request $request, Evenement $evenement)
    {
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $evenement->setImage(null);
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
        $recherches = $recherche->setRecherche('evenements', array(
                'categorie',
            )
        );

        /* La liste des événements */
        $evenements = $this->getDoctrine()
                           ->getRepository(Evenement::class)
                           ->getAllEvenements(null, $request->getLocale(), $recherches['categorie'], false);

        /* L'événement mis en avant */
        $avant = $this->getDoctrine()
                      ->getRepository(Evenement::class)
                      ->getAvantEvenement($request->getLocale());

        /* La liste des catégories */
        $categories = $this->getDoctrine()
                           ->getRepository(Categorie::class)
                           ->getAlLCategorie($request->getLocale());

        $pagination = $paginator->paginate(
            $evenements, /* query NOT result */
            $request->query->getInt('page', 1) /*page number*/,
            9 /*limit per page*/
        );

        return $this->render('Evenement/manager.html.twig', array(
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
        /* Evenement en cours */
        $evenement = $this->getDoctrine()
                          ->getRepository(Evenement::class)
                          ->getCurrentEvenement($id);

        if(is_null($evenement)) throw new NotFoundHttpException('Cette page n\'est pas disponible');

        /* BreadCrumb */
        $breadcrumb = array(
            $translator->trans('evenement.client.view.breadcrumb.niveau1') => $this->generateUrl('client_evenement_manager'),
            $evenement->getTitre() => ''
        );

        return $this->render( 'Evenement/view.html.twig',array(
                'evenement' => $evenement,
                'breadcrumb' => $breadcrumb
            )
        );
    }

    /**
     * Block template liste
     */
    public function lastEvenement(Request $request, $limit)
    {

        $evenements = $this->getDoctrine()
                           ->getRepository(Evenement::class)
                           ->getAllEvenements(null, $request->getLocale(), null, false, $limit);

        return $this->render( 'Evenement/Include/liste.html.twig',array(
                'evenements' => $evenements
            )
        );

    }

    /**
     * Block template calendrier
     */
    public function calendrierEvenement(Request $request, $annee = null, $mois = null, Agenda $agenda, Tool $tool)
    {
        $moisi18 = $agenda->getMois();
        $joursi18 = $agenda->getJours();
        $evenementsRCalendar = array();

        /* La liste des événements pour le calendier */
        $evenementsCalendar = $this->getDoctrine()
                                   ->getRepository(Evenement::class)
                                   ->getAllEvenementsCalendrier($request->getLocale());

        /* Les 2 derniers événements pour le bloc */
        $evenementsBloc = $this->getDoctrine()
                               ->getRepository(Evenement::class)
                               ->getAllEvenements(null, $request->getLocale(), null, false, 2);

        /* Formater les événements pour la calendrier */
        foreach ($evenementsCalendar as $evenement){
            $evenementsRCalendar[$evenement->getDebut()->format('Y-n-j')][$evenement->getId()] = '<a href="'.$this->generateUrl('client_evenement_view',array('slug' => $evenement->getSlug(), 'id' => $evenement->getId())).'">'.$evenement->getTitre().'</a><p>'.$tool->truncate($evenement->getResume(),70).'</p>';
        }

        /* Retour en ajax */
        if($request->isXmlHttpRequest()){

            return new JsonResponse(array(
                    'date' => $moisi18[$mois -1].' '.$annee,
                    'contenu' => $this->render('Evenement/Include/calendrier-ajax.html.twig', array(
                        'calendrier' => $agenda->getCalendrier($annee),
                        'evenements' => $evenementsRCalendar,
                        'annee' => $annee,
                        'mois' => $mois,
                    ))->getContent()
                )
            );
        }else{
            /* Retour sans ajax */
            $annee = date('Y');
            $mois = date('n');

            return $this->render( 'Evenement/Include/calendrier.html.twig',array(
                    'calendrier' => $agenda->getCalendrier($annee),
                    'evenements' => $evenementsRCalendar,
                    'evenementsBloc' => $evenementsBloc,
                    'joursi18' => $joursi18,
                    'moisi18' => $moisi18,
                    'annee' => $annee,
                    'mois' => $mois
                )
            );
        }
    }
}
