<?php

    namespace App\Utilities\Twig;

    use Symfony\Component\HttpFoundation\RequestStack;

    class TruncateText extends \Twig_Extension
    {

        private $request;

        public function __construct(RequestStack $request)
        {
            $this->request = $request;
        }

        public function getFunctions()
        {
            return array(
                new \Twig_SimpleFunction('TruncateText', array($this, 'TruncateText')),
            );
        }

        public function TruncateText($text, $nombre)
        {
            if (strlen($text)>$nombre){
                $text = substr($text, 0, $nombre);
                $position_espace = strrpos($text, " ");

                if($position_espace == false)
                    $position_espace = strrpos($text, "-");

                $text = substr($text, 0, $position_espace);
                $text = $text."...";
            }

            return $text;
        }
        
        public function getName()
        {
            return 'TruncateText';
        }

    }
