<?php

namespace WB\QbankBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class OrganizationsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea', array(
                'required'    => false,
            ))
            ->add('nickName', 'text', array(
                'required'    => false,
                'label'  => 'Nickname'
            ))
            ->add('address', 'text', array(
                'required'    => false,
            ))
            ->add('country', 'text', array(
                'required'    => false,
            ))
            ->add('telephone', 'text', array(
                'required'    => false,
            ))
            ->add('fax', 'text', array(
                'required'    => false,
            ))
            ->add('email', 'email', array(
                'required'    => false,
            ))
            ->add('url', 'url', array(
                'required'    => false,
            ))
            ->add('notes', 'text', array(
                'required'    => false,
            ))


            ->add('published', 'hidden')
            ->add('save', 'submit');

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\QbankBundle\Entity\Organizations'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'organizations';
    }
}
