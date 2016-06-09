<?php

namespace YallaWebsite\BackendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CreateArticleForm extends AbstractType
{

    public function __construct(\Doctrine\ORM\EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', 'text', array(
                    'label' => false,
                    'attr' => array(
                        'class' => 'form-control',
                        'placeholder' => 'Article Name')))
                ->add('content', 'textarea', array(
                    'label' => false,
                    'attr' => array(
                        'class' => 'tinymce')))
                ->add('tags', 'dcs_tag', array(
                    'attr' => array('class' => 'form-control',
            )))
                ->add('media', 'media_file', array())
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'YallaWebsite\BackendBundle\Entity\Article',
        ));
    }

    public function getName()
    {
        return 'article';
    }

}
