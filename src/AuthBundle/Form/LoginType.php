<?php

namespace AuthBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AuthBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Description of LoginType
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username',EmailType::class,[
                    'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control']
                ])
            ->add('_password', PasswordType::class,[
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

