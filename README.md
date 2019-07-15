# Orani sur Symfony 4.x

Mise en place des elements de base pour le developpement d'applications web


* Symfony
* Composer
* Sass/Compass
* Font awesome
* Grunt
* Administration avec Bootstrap(maison) simple d'utilisation / reponsive


## Fonctinnalités
* Orani utilisateur: compris dans la base
* Orani page/menu: compris dans la base
* Orani référencement: compris dans la base
* Orani actualités: [Github](https://github.com/kiou/Orani-actualite2018) 
* Orani événements: [Github](https://github.com/kiou/Orani-evenement2018) 
* Orani contact: [Github](https://github.com/kiou/Orani-contact2018) 
* Orani slider: [Github](https://github.com/kiou/Orani-slider2018) 
* Orani galerie image: [Github](https://github.com/kiou/Orani-diaporama2018) 

## Gestion de contenu

![alt tag](https://colocarts.com/gitimg/manager2.jpg)


## Modifier / ajouter

![alt tag](https://colocarts.com/gitimg/modifier2.jpg)


## Gestion de page et de menu en drag&drop

![alt tag](https://colocarts.com/gitimg/menu2.jpg)


## Wysiwyg

![alt tag](https://colocarts.com/gitimg/wysiwyg2.jpg)


## Installation
* composer install
* php bin/console doctrine:database:create
* php bin/console make:migration
* php bin/console doctrine:migrations:migrate
* php bin/console doctrine:fixtures:load

## Multilangue

* Prefix de route dans le fichier racine route.yml
* Selecteur de langue dynamique dans le header

## Compte
Pour l'administration

* url : /admin
* email : admin@colocarts.com
* mot de passe : admin


## Production

* Minimifier le JS avec GRUNT
* Minimifier le CSS avec SASS (deja) en place en dev dans le fichier config.rb


## Module (libraire complementaire)

* Tinymce: [www.tinymce.com](https://www.tinymce.com/)
* Filemanager pour tinymce: [www.responsivefilemanager.com](http://www.responsivefilemanager.com/)
* Crop: [fengyuanchen.github.io/cropperjs](https://fengyuanchen.github.io/cropperjs/)
* Gestion du menu: [https://superfish.joelbirch.co/examples/](https://superfish.joelbirch.co/examples/)
* OWL Slider: [https://owlcarousel2.github.io/OwlCarousel2/](https://owlcarousel2.github.io/OwlCarousel2/)
* Lightbox2: [http://lokeshdhakar.com/projects/lightbox2/](http://lokeshdhakar.com/projects/lightbox2/)
* Select2: [https://select2.org/](https://select2.org/)

## Documentation
MakeBundle [https://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html](https://symfony.com/doc/current/bundles/SymfonyMakerBundle/index.html)
