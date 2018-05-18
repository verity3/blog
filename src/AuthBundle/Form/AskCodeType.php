<?php

namespace AuthBundle\Form;

use AuthBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Description of AskCodeType
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class AskCodeType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', EmailType::class, [
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control']
                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
           // 'data_class' => User::class,
        ));
    }

}
