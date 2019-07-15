<?php

namespace App\Controller\Film;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Film\Film;
use App\Form\Film\FilmType;
use App\Utilities\Recherche;
use App\Entity\General\Langue;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Film\Commentaire;
use App\Entity\Film\Categorie;
use App\Entity\Film\SousCategorie;
use App\Entity\Personne\Personne;

class FilmController extends Controller{

    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {
        $film = new Film;
        $form = $this->createForm(FilmType::class, $film);
        
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $film->uploadImage();
            $film->getReferencement()->uploadOgimage();

            $em->persist($film);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Film enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_film_manager'));
        }

        return $this->render('Film/Admin/ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function managerAdmin(Request $request, Recherche $recherche, PaginatorInterface $paginator)
    {
        /* Services */
        $recherches = $recherche->setRecherche('film_manager', array(
                'recherche',
                'langue'
            )
        );

        /* La liste des films */
        $films = $this->getDoctrine()
                      ->getRepository(Film::class)
                      ->getAllFilms($recherches['recherche'], $recherches['langue']);
        $pagination = $paginator->paginate(
            $films, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('Film/Admin/manager.html.twig',array(
                'pagination' => $pagination,
                'recherches' => $recherches,
                'langues' => $langues
            )
        );
    }

     /**
     * Publication
     */
    public function publierAdmin(Request $request, Film $film){
        
        if($request->isXmlHttpRequest()){
            $state = $film->reverseState();
            $film->setIsActive($state);
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Film $film)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($film);
        $em->flush();
        $request->getSession()->getFlashBag()->add('succes', 'Film supprimé avec succès');
        return $this->redirect($this->generateUrl('admin_film_manager'));
    }


    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Film $film)
    {
        $form = $this->createForm(FilmType::class, $film);
        
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $film->uploadImage();
            $film->getReferencement()->uploadOgimage();

            $em->persist($film);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Film enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_film_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des films' => $this->generateUrl('admin_film_manager'),
            'Modifier un film' => ''
        );

        return $this->render('Film/Admin/modifier.html.twig',
            array(
                'form' => $form->createView(),
                'film' => $film,
                'breadcrumb' => $breadcrumb
            )
        );
    }

     /**
     * Supprimer l'image
     */
    public function AdminSupprimerImage(Request $request, Film $film)
    {
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $film->setImage(null);
            $em->flush();
            return new JsonResponse(array('state' => 'ok'));
        }
    }

    /* 
     * Derrnier films ajoutés 
     */
    public function listeAvant($limit = null){

        $films = $this->getDoctrine()
                      ->getRepository(Film::class)
                      ->findBy(['isActive' => true],['id' => 'desc']);
             
        return $this->render('Film/Include/listeavant.html.twig',
            array(
                'films' => $films
            )
        );
    }

    /**
     * Fiche film
     */
    public function ClientView($slug, $id){

        $film = $this->getDoctrine()
                     ->getRepository(Film::class)
                     ->getSingleFilm($id);

        $user = $this->getUser();

        $postActive = true;
        if(!is_null($user)){
            $commentaire = $this->getDoctrine()
                                ->getRepository(Commentaire::class)
                                ->findBy(['user' => $user, 'film'=> $film],[]);
            if(!empty($commentaire)) $postActive = false;
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('client_page_index'),
            'Liste des films' => $this->generateUrl('client_film_manager'),
            $film->getTitre() => ''
        );

        return $this->render( 'Film/view.html.twig',array(
            'film' => $film,
            'breadcrumb' => $breadcrumb,
            'postActive' => $postActive
            )
        );

    }

    public function ajouterCommentaireClient(Request $request){

        $erreur = [];
        
        $rating = $request->request->get('rating');
        $filmid = $request->request->get('filmid');
        $filmslug = $request->request->get('filmslug');
        $commentairePost = $request->request->get('commentaire');

        if(empty($rating)) array_push($erreur, $request->getSession()->getFlashBag()->add('error', 'Veuillez compléter le champ rating'));
        if(empty($commentairePost)) array_push($erreur, $request->getSession()->getFlashBag()->add('error', 'Veuillez compléter le champ commentaire'));

        if(empty($erreur)){
            $request->getSession()->getFlashBag()->add('succes', 'Commentaire enregistré avec succès');

            $commentaire = new Commentaire;

            $commentaire->setRating($rating);
            $commentaire->setCommentaire($commentairePost);

            $film = $this->getDoctrine()
                         ->getRepository(Film::class)
                         ->find($filmid);

            $commentaire->setFilm($film);
            $commentaire->setUser($this->getUser());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('client_film_view',['slug'=> $filmslug, 'id'=> $filmid]));
    }

    public static function ClientManager(Request $request, PaginatorInterface $paginator, Recherche $recherche)
    {

        /* Services */
        $recherches = $recherche->setRecherche('film_manager_client', array(
                'categorie',
                'souscategorie',
                'acteur'
            )
        );

        $categories = $this->getDoctrine()
                           ->getRepository(Categorie::class)
                           ->findAll();

        $souscategories = $this->getDoctrine()
                               ->getRepository(SousCategorie::class)
                               ->getByCategorie($recherches['categorie']);

        $acteurs = $this->getDoctrine()
                        ->getRepository(Personne::class)
                        ->findAll();

        $films = $this->getDoctrine()
                       ->getRepository(Film::class)
                       ->allFilmSearch($recherches['categorie'], $recherches['souscategorie'], $recherches['acteur']);
        
        $pagination = $paginator->paginate(
            $films, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('client_page_index'),
            'Liste des films' => ''
        );

        return $this->render('Film/manager.html.twig',array(
                'films' => $pagination,
                'breadcrumb' => $breadcrumb,
                'categories' => $categories,
                'souscategories' => $souscategories,
                'recherches' => $recherches,
                'acteurs' => $acteurs
            )
        );

    }

}

?>