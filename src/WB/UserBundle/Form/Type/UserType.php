<?php

namespace WB\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;
use WB\UserBundle\Entity\User;

class UserType extends AbstractType
{
    private $isRoleAdmin;

    function __construct($isRoleAdmin)
    {
        $this->isRoleAdmin = $isRoleAdmin;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username', 'text')
            ->add('email', 'text')
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('company', 'text')
            ->add('phone', 'text')
            ->add('countryId', 'entity', array(
                'class' => 'WB\QbankBundle\Entity\Countries',
                'property' => 'name',
                'empty_value' => 'Choose a country',
                'multiple' => false,
                'label' => 'Country'
            ))
            ->add('plain_password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ));
        if ($this->isRoleAdmin) {
            $builder->add('enabled', 'choice', array(
                'choices' => array('1' => 'Active', '0' => 'Blocked'),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('roles', 'choice', array(
                'choices' => array('ROLE_USER' => 'User', 'ROLE_ADMIN' => 'Administrator'),
                'multiple' => true,
                'expanded' => true
            ));
        }

        $builder->add('save', 'submit');

    }

    // specify the data_class option
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WB\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'userEdit';
    }
}
