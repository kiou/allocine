<?php

namespace App\Controller\Page;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Utilities\Recherche;
use App\Utilities\Tool;
use App\Entity\Page\Menu;
use App\Entity\General\Langue;
use App\Form\Page\MenuType;

class MenuController extends Controller{

    private $return = [];

    /**
     * Ajouter
     */
    public function ajouterAdmin(Request $request)
    {
        $menu = new Menu;
        $form = $this->createForm(MenuType::class, $menu);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Onglet menu enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_menu_manager'));
        }

        return $this->render('Menu/Admin/ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Gestion
     */
    public function managerAdmin(Recherche $recherche)
    {
        /* Services */
        $recherches = $recherche->setRecherche('menu_manager', array(
                'langue'
            )
        );

        /* En Français par défaut */
        if(empty($recherches['langue'])) $recherches['langue'] = 'fr';

        /* La liste des langues */
        $langues = $this->getDoctrine()->getRepository(Langue::class)->findAll();

        return $this->render('Menu/Admin/manager.html.twig', array(
                'menus' => $this->getRecursiveMenu(3, null, $recherches['langue'], true),
                'recherches' => $recherches,
                'langues' => $langues
            )
        );
    }

    /**
     * Gestion update
     */
    public function managerUpdateAdmin(Request $request)
    {
        if($request->isXmlHttpRequest()){

            $count = 1;
            foreach ($request->request->get('data') as $data){
                $menu = $this->getDoctrine()
                             ->getRepository(Menu::class)
                             ->find($data['id']);

                $menu->setParent(empty($data['parent_id']) ? 0 : $data['parent_id']);
                $menu->setPoid($count);

                $em = $this->getDoctrine()->getManager();
                $em->persist($menu);
                $em->flush();

                $count ++;
            }

            return new JsonResponse(array('state' => 'OK'));
        }
    }

    /**
     * Publication
     */
    public function publierAdmin(Request $request, Menu $menu){

        if($request->isXmlHttpRequest()){
            $state = $menu->reverseState();
            $menu->setIsActive($state);

            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Supprimer
     */
    public function supprimerAdmin(Request $request, Menu $menu)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($menu);
        $em->flush();

        $request->getSession()->getFlashBag()->add('succes', 'Onglet menu supprimé avec succès');
        return $this->redirect($this->generateUrl('admin_menu_manager'));
    }

    /**
     * Modifier
     */
    public function modifierAdmin(Request $request, Menu $menu)
    {
        $form = $this->createForm(MenuType::class, $menu);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Onglet menu enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_menu_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion du menu' => $this->generateUrl('admin_menu_manager'),
            'Modifier un onglet' => ''
        );

        return $this->render('Menu/Admin/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'menu' => $menu,
                'form' => $form->createView()
            )
        );

    }

    /**
     * Gestion client
     */
    public function managerClient(Request $request, $sfmenu)
    {
        return $this->render('Menu/manager.html.twig', array(
                'menus' => $this->getRecursiveMenu(3, null, $request->getLocale(), false),
                'sfmenu' => $sfmenu
            )
        );
    }

    /**
     * Créer le menu sous forme de tableau récursif
     */
    public function getRecursiveMenu($recursive ,$parent, $langue, $admin){

        $tool = new Tool;

        $recursive --;

        if($recursive >= 0){

            $menus = $this->getDoctrine()
                          ->getRepository(Menu::class)
                          ->getAllMenuAdmin($parent, $langue, $admin);

            foreach ($menus as $menu) {

                $datas = array(
                    'id' => $menu->getId(),
                    'titre' => $menu->getTitre(),
                    'lien' => $menu->getLien(),
                    'parent' => $menu->getParent(),
                    'isActive' => $menu->getIsActive(),
                    'destination' => $menu->getDestination(),
                    'langue' => $menu->getLangue()
                );

                if(empty($menu->getParent())){
                    $this->return[$menu->getId()] = $datas;
                }else{
                    $found_key = $tool->recursive_array_search($menu->getParent(), $this->return);

                    if($found_key == $menu->getParent()){
                        if(!isset($this->return[$found_key]['enfants'])) $this->return[$found_key]['enfants'] = [];
                        $this->return[$found_key]['enfants'][$menu->getId()] = $datas;
                    }else{
                        if(!isset($this->return[$found_key]['enfants'][$menu->getParent()]['enfants'])) $this->return[$found_key]['enfants'][$menu->getParent()]['enfants'] = [];
                        $this->return[$found_key]['enfants'][$menu->getParent()]['enfants'][$menu->getId()] = $datas;
                    }
                }

                $this->getRecursiveMenu($recursive, $menu->getId(), $langue, $admin);

            }

        }

        return $this->return;

    }

}
?>