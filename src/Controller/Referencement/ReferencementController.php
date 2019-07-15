<?php

namespace App\Controller\Referencement;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Referencement\Referencement;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReferencementController extends Controller{

    /**
     * Supprimer l'ogimage
     */
    public function supprimerOgimageAdmin(Request $request, Referencement $referencement)
    {
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $referencement->setOgimage(null);
            $em->flush();

            return new JsonResponse(array('state' => 'ok'));
        }
    }

}

?>