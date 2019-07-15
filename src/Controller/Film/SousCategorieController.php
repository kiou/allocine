<?php

namespace App\Controller\Film;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Film\SousCategorie;
use App\Entity\Film\Categorie;

class SousCategorieController extends Controller{

    public function getAdminSousCategorie(Request $request, Categorie $categorie)
    {
        if($request->isXmlHttpRequest()){
            $return = [];
            
            $souscategories = $this->getDoctrine()
                                   ->getRepository(SousCategorie::class)
                                   ->getByCategorie($categorie, false);

            foreach ($souscategories as $souscategorie) {
                array_push($return, array(
                        'id' => $souscategorie->getId(),
                        'titre' => $souscategorie->getTitre(),
                    )
                );
            }
                

            return new JsonResponse(array('return' => $return));
        }
    }

}

?>