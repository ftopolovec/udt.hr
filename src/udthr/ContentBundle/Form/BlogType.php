<?php

namespace udthr\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('label' => 'Naslov'))
            ->add('abstract', 'textarea', array('label' => 'Sažetak'))
            ->add('file', null, array('label' => 'Slika'))
            ->add('date')
            ->add('content', 'ckeditor', array(
                'config' => array(
                    'filebrowser_image_browse_url' => array(
                        'route' => 'elfinder',
                        'route_parameters' => array('instance' => 'default'),
                    ),
                    'uiColor' => '#ffffff',
                    //...
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'udthr\ContentBundle\Entity\Blog'
        ));
    }
}
