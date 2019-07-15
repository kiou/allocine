<?php

	namespace App\Utilities;

    use Cocur\Slugify\Slugify;

	class Upload{

        /**
         * Retourne le nom d'un fichier dans un format stockable
         * @param $name
         * @param $file
         * @param $folders
         * @return string
         */
        public function createName($name, $file, $folders){

            $slugify = new Slugify();

            $nameInfo = pathinfo($file.strtolower($name), PATHINFO_FILENAME);
            $nameExt =  pathinfo($file.strtolower($name), PATHINFO_EXTENSION);
            $nameSlug = $slugify->slugify($nameInfo);
            $nameSlugExt = $nameSlug.'.'.$nameExt;

            foreach ($folders as $folder){
                if (file_exists($file.$folder.$nameSlugExt)){
                    $name = $nameSlug.'_'.uniqid().'.'.$nameExt;
                    return $name;
                }
            }

            return $nameSlugExt;

        }

	}

?>