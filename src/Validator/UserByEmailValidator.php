<?php

namespace App\Validator;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User\User;

class UserByEmailValidator extends ConstraintValidator
{

    private $em;

    private $translator;

    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $this->em = $em;
        $this->translator = $translator;
    }

    public function validate($value, Constraint $constraint)
    {
        if (empty($value)) $this->context->addViolation($this->translator->trans('user.validators.email'));
        else{
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)) $this->context->addViolation($this->translator->trans('user.validators.emailvalide'));
            else{
                $user = $this->em->getRepository(User::class)
                                 ->findBy(['email' => $value, 'isActive' => true],[]);
                if(empty($user)) $this->context->addViolation($this->translator->trans('reinitialisation.validators.verifuser'));
            }
        }

    }
}