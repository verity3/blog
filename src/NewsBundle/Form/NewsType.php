<?php

namespace NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use NewsBundle\Form\FilesType;

/**
 * Description of NewsType
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class NewsType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add(
                        'title', TextType::class, [
                    'attr' => ['class' => 'form-control']
                        ]
                )
                ->add(
                        'text', FroalaEditorType::class, []
                )
                ->add(
                        'date', DateType::class, [
                    'widget' => 'single_text',
                    'attr' => ['class' => 'js-datepicker form-control'],
                    'html5' => false,
                        ]
                )
                 ->add('files', CollectionType::class,array(
                    'entry_type' => FilesType::class,
                    'allow_add' => true,
                    'by_reference' => false,
                     'label' => " "
                ))
                ->add('active', CheckboxType::class, array(
                    'label' => 'Active',
                    'attr' => ['class' => ' mx-auto'],
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
            'data_class' => 'NewsBundle\Entity\NewsPost',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'validation_groups' => array('news_post'),
            'dataTags' => []
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'news_form';
    }

}
