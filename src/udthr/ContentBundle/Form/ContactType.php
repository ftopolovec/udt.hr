<?php

namespace udthr\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ime', 'text', array(
                'attr' => array(
                    'placeholder' => 'Vaše cijenjeno ime?',
                    'pattern'     => '.{2,}', //minlength,
                    'class' => 'form-control'
                )
            ))
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'Da bi vam mogli odgovoriti',
                    'class' => 'form-control'
                )
            ))
            ->add('poruka', 'textarea', array(
                'attr' => array(
                    'cols' => 90,
                    'rows' => 10,
                    'placeholder' => 'Vaša poruka za nas...',
                    'class' => 'form-control'
                )
            ))
            ->add('submit', 'submit', array(
                'label' => 'Pošalji',
                'attr' => array(
                    'class' => 'btn btn-danger btn-lg'
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $collectionConstraint = new Collection(array(
            'ime' => array(
                new NotBlank(array('message' => 'Ovo polje ne smije ostati prazno')),
                new Length(array('min' => 2))
            ),
            'email' => array(
                new NotBlank(array('message' => 'Ovo polje ne smije ostati prazno')),
                new Email(array('message' => 'Neispravna email adresa'))
            ),
            'poruka' => array(
                new NotBlank(array('message' => 'Ovo polje ne smije ostati prazno')),
                new Length(array('min' => 5))
            )
        ));

        $resolver->setDefaults(array(
            'constraints' => $collectionConstraint
        ));
    }

    public function getName()
    {
        return null;
    }
}