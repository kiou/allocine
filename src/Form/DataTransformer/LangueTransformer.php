<?php

    namespace App\Form\DataTransformer;

    use App\Entity\General\Langue;
    use Doctrine\Common\Persistence\ObjectManager;
    use Symfony\Component\Form\DataTransformerInterface;

    class LangueTransformer implements DataTransformerInterface{

        private $manager;

        public function __construct(ObjectManager $manager)
        {
            $this->manager = $manager;
        }

        public function transform($code)
        {
            return $this->manager->getRepository(Langue::class)->findOneBy(['code' => $code]);
        }

        public function reverseTransform($entity)
        {
            return $entity->getCode();
        }

    }

?>