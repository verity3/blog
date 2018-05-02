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


/**
 * Description of BlogType
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class TagType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add(
                        'name', TextType::class, [
                    // 'constraints' => [new NotBlank()],
                    'attr' => ['class' => 'form-control']
                        ]
                )
                
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
            'data_class' => 'BlogBundle\Entity\Tags',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'validation_groups' => array('tags'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'tags_form';
    }

}
