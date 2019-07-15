<?php

    namespace App\Validator;

    use Symfony\Component\Validator\Constraint;

    /**
     * @Annotation
     */
    class UserByEmail extends Constraint
    {
        public $message = '';

        public function validatedBy()
        {
            return get_class($this).'Validator';
        }
    }

?>