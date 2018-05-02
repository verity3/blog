<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Description of BlogType
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class BlogType extends AbstractType {
    

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add(
                        'title', TextType::class, [
                    // 'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control']
                        ]
                )
                ->add(
                        'url', TextType::class, [
                    // 'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control']
                        ]
                )
                ->add(
                        'text', FroalaEditorType::class, [
                        // 'constraints' => [new NotBlank()],
                        //   'attr' => ['class' => 'form-control']
                        ]
                )
                ->add(
                        'date', DateType::class, [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker form-control'],
                    'html5' => false,
                        ]
                )
                ->add('active', CheckboxType::class, array(
                    'label' => 'Active',
                    'attr' => ['class' => ' mx-auto'],
                ))
                ->add('tags', EntityType::class, array(
                    'class' => 'BlogBundle:Tags',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => true,
                    'mapped' => false,
                    'attr' => ['class' => ' mx-auto'],
                    'data' => $options['dataTags']
                ))
                ->add(
                        'create', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary pull-right'],
                    'label' => 'Save'
                        ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => 'BlogBundle\Entity\BlogPost',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'validation_groups' => array('blog_post'),
            'dataTags' => []
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'blog_form';
    }

}
