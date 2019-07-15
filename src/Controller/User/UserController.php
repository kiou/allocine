<?php

namespace App\Controller\User;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Knp\Component\Pager\PaginatorInterface;
use App\Utilities\Recherche;
use App\Entity\User\Historique;
use App\Entity\User\User;
use App\Entity\User\Reinitialisation;
use App\Entity\User\Newsletter;
use App\Form\User\RegisterType;
use App\Form\User\ReinitialisationType;
use App\Form\User\UserPasswordType;
use App\Form\User\NewsletterType;
use App\Form\User\UserType;
use App\Form\User\CompteType;

class UserController extends Controller
{
    /**
     * Connexion
     */
    public function Login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        /* Historique utilisateur */
        if(!empty($error)){

            $em = $this->getDoctrine()->getManager();

            $historique = new Historique;
            $historique->setContenu('Erreur de connexion avec l\'email suivant: '.$lastUsername);
            $historique->setIp($request->getClientIp());
            $em->persist($historique);
            $em->flush();

        }

        return $this->render(
            'User/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * Inscription
     */
    public function Register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User;
        $form = $this->createForm(RegisterType::class, $user);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
                $user->uploadAvatar();
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $request->getSession()->getFlashBag()->add('succes', 'Vous êtes maintenant inscrit, votre compte est en attente de validation');
                return $this->redirect($this->generateUrl('login'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Connexion' => $this->generateUrl('login'),
            'Inscription' => ''
        );

        return $this->render( 'User/register.html.twig', array(
                'form' => $form->createView(),
                'breadcrumb' => $breadcrumb
            )
        );
    }

    /**
     * Réinitialisation
     */
    public function Reinitialisation(Request $request, TranslatorInterface $translator, \Swift_Mailer $mailer)
    {
        $base_url = $request->getScheme() . '://' . $request->getHttpHost();

        $reinitialisation = new Reinitialisation;
        $form = $this->createForm(ReinitialisationType::class, $reinitialisation);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $token = md5(uniqid(rand(), true));
            $reinitialisation->setToken($token);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reinitialisation);
            $em->flush();

            
            /* Notification*/
            $message = (new \Swift_Message($translator->trans('reinitialisation.mail.title')))
            ->setFrom('contact@colocarts.com')
            ->setTo($form->getData()->getEmail())
            ->setBody(
                $this->renderView('General/Mail/simple.html.twig', array(
                        'titre' => $translator->trans('reinitialisation.mail.title'),
                        'contenu' => $translator->trans('reinitialisation.mail.content').' <a href="'.$base_url.$this->generateUrl('reinitialisation_password',['token' => $token]).'">'.$translator->trans('reinitialisation.mail.link').'</a>'
                    )
                ),
                'text/html'
            );

            /* Envoyer le message */
            $mailer->send($message);

            $request->getSession()->getFlashBag()->add('succes', $translator->trans('reinitialisation.validators.succes'));
            return $this->redirect($this->generateUrl('login'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            $translator->trans('reinitialisation.breadcrumb.niveau1') => $this->generateUrl('login'),
            $translator->trans('reinitialisation.breadcrumb.niveau2') => ''
        );

        return $this->render('User/reinitialisation.html.twig', array(
                'form' => $form->createView(),
                'breadcrumb' => $breadcrumb
            )
        );
    }

    /**
     * Réinitialisation password
     */
    public function ReinitialisationPassword(Request $request, $token, TranslatorInterface $translator, UserPasswordEncoderInterface $passwordEncoder)
    {

        $reinitialisation = $this->getDoctrine()
                                 ->getRepository(Reinitialisation::class)
                                 ->findOneBy(['token' => $token, 'isActive' => true],['id' => 'DESC']);

        if(empty($reinitialisation)) throw new NotFoundHttpException('Cette page n\'est pas disponible');

        $user = $this->getDoctrine()
                     ->getRepository(User::class)
                     ->findOneBy(['email' => $reinitialisation->getEmail()],[]);

        $form = $this->createForm(UserPasswordType::class, $user);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            /* Modifier le password */
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));

            $em->persist($user);
            $em->flush();

            /* Modifier la/les reinitialisation(s) */
            $reinitialisations = $this->getDoctrine()
                                      ->getRepository(Reinitialisation::class)
                                      ->findBy(['email' => $user->getEmail(), 'isActive' => true],['id' => 'DESC']);

            foreach ($reinitialisations as $reinitialisation){
                $reinitialisation->setIsActive(false);

                $em->persist($reinitialisation);
                $em->flush();
            }

            $request->getSession()->getFlashBag()->add('succes', $translator->trans('reinitialisationpassword.validators.succes'));
            return $this->redirect($this->generateUrl('login'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            $translator->trans('reinitialisationpassword.breadcrumb.niveau1') => $this->generateUrl('login'),
            $translator->trans('reinitialisationpassword.breadcrumb.niveau2') => ''
        );

        return $this->render('User/reinitialisation_password.html.twig', array(
                'breadcrumb' => $breadcrumb,
                'form' => $form->createView()
            )
        );

    }

     /**
     * Compte
     */
    public function ClientCompte()
    {
        return $this->render('User/Compte/dashboard.html.twig');
    }

    /**
     * Bloc newsletter
     */
    public function ClientNewsletterBloc()
    {
        /* Création du fomulaire*/
        $newsletter = new Newsletter;
        $form = $this->createForm(NewsletterType::class, $newsletter);

        return $this->render('User/Newsletter/bloc.html.twig',array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * Inscription newsletter
     */
    public function ClientNewsletterAjouter(Request $request, TranslatorInterface $translator)
    {
        if($request->isXmlHttpRequest()) {

            /* Création du fomulaire */
            $newsletter = new Newsletter;
            $form = $this->createForm(NewsletterType::class, $newsletter);

            /* Récéption du formulaire */
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($newsletter);
                $em->flush();

                return new JsonResponse(array(
                        'succes' => $translator->trans('newsletter.client.validators.succes')
                    )
                );
            }

            return new JsonResponse(array(
                    'error' => $this->getErrorsAsArray($form)
                )
            );

        }
    }

    /**
     * Ajouter
     */
    public function AdminAjouter(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User;
        $form = $this->createForm(UserType::class, $user);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getData()));
            $user->uploadAvatar();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Utilisateur enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_user_manager'));
        }

        return $this->render( 'User/Admin/ajouter.html.twig',
            array(
                'form' => $form->createView()
            )
        );

    }

    /**
     * Gestion
     */
    public function AdminManager(Request $request, Recherche $recherche, PaginatorInterface $paginator)
    {

        $recherches = $recherche->setRecherche('user_manager', ['recherche']);

        /* La liste des utilisateurs */
        $utilisateurs = $this->getDoctrine()
                             ->getRepository(User::class)
                             ->getAllUser($recherches['recherche']);

        $pagination = $paginator->paginate(
            $utilisateurs, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            50/*limit per page*/
        );

        return $this->render( 'User/Admin/manager.html.twig', array(
                'pagination' => $pagination,
                'recherches' => $recherches
            )
        );

    }

    /**
     * Publication
     */
    public function AdminPublier(Request $request, User $user){

        if($request->isXmlHttpRequest()){
            $state = $user->reverseState();
            $user->setIsActive($state);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse(array('state' => $state));
        }

    }

    /**
     * Modifier
     */
    public function AdminModifier(Request $request, User $user)
    {
        $form = $this->createForm(CompteType::class, $user);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->uploadAvatar();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Utilisateur enregistré avec succès');
            return $this->redirect($this->generateUrl('admin_user_manager'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Gestion des utilisateurs' => $this->generateUrl('admin_user_manager'),
            'Modifier un utilisateur' => ''
        );

        return $this->render( 'User/Admin/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'form' => $form->createView(),
                'utilisateur' => $user
            )
        );

    }

    /**
     * Supprimer l'avatar
     */
    public function AdminSupprimerAvatar(Request $request, User $user)
    {
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $user->setAvatar(null);
            $em->flush();

            return new JsonResponse(array('state' => 'ok'));
        }
    }

    /**
     * Modification compte
     */
    public function AdminCompteModifier(Request $request)
    {
        /* Création du fomulaire */
        $user = $this->getUser();
        $form = $this->createForm(CompteType::class, $user);

        /* Récéption du formulaire */
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->uploadAvatar();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('succes', 'Informations modifiés avec succès');
            return $this->redirect($this->generateUrl('admin_page_index'));
        }

        /* BreadCrumb */
        $breadcrumb = array(
            'Accueil' => $this->generateUrl('admin_page_index'),
            'Mes informations' => ''
        );

        return $this->render( 'User/Admin/Compte/modifier.html.twig',
            array(
                'breadcrumb' => $breadcrumb,
                'utilisateur' => $user,
                'form' => $form->createView()
            )
        );
    }

    /**
     * Gestion historique
     */
    public function AdminHistorique()
    {
        $historiques = $this->getDoctrine()
                            ->getRepository(Historique::class)
                            ->findBy(array(),array('id' => 'DESC'));

        return $this->render( 'User/Admin/historique.html.twig', array(
                'historiques' => $historiques
            )
        );
    }

    /**
     * Export
     */
    public function AdminNewsletterExport()
    {
        $file = __DIR__.'/../../../public/file/export/newsletter.csv';

        $fp = fopen($file,'w');

        fputcsv($fp,array('Date','Email','Langue'),';');

        $newsletters = $this->getDoctrine()
                            ->getRepository(Newsletter::class)
                            ->findBy([],['id' => 'DESC']);

        foreach ($newsletters as $newsletter){

            $row = array(
                'Date' => $newsletter->getCreated()->format('d-m-Y H:i:s'),
                'Email' => $newsletter->getEmail(),
                'Langue' => $newsletter->getLangue()
            );

            $row = array_map("utf8_decode", $row);
            fputcsv($fp, $row,';');

        }

        fclose($fp);

        $response = new Response();
        $response->headers->set('Content-type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="newsletter.csv";');
        $response->sendHeaders();
        $response->setContent(file_get_contents($file));
        return $response;

    }

    /**
     * Retourne les erreurs d'un formulaire
     */
    protected function getErrorsAsArray($form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error)
            $errors[] = $error->getMessage();

        foreach ($form->all() as $key => $child) {
            if ($err = $this->getErrorsAsArray($child))
                $errors[$key] = $err;
        }
        return $errors;
    }

}

?>