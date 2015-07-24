<?php
namespace Omeka\Form;

class ResetPasswordForm extends AbstractForm
{
    public function buildForm()
    {
        $translator = $this->getTranslator();

        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => $translator->translate('New Password'),
            ),
            'attributes' => array(
                'id' => 'password',
                'required' => true,
            ),
        ));
        $this->add(array(
            'name' => 'password-confirm',
            'type' => 'Password',
            'options' => array(
                'label' => $translator->translate('Confirm Password'),
            ),
            'attributes' => array(
                'id' => 'password-confirm',
                'required' => true,
            ),
        ));


        $inputFilter = $this->getInputFilter();

        $inputFilter->add(array(
            'name' => 'password',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 6,
                    ),
                ),
            ),
        ));
        $inputFilter->add(array(
            'name' => 'password-confirm',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'Identical',
                    'options' => array(
                        'token' => 'password',
                    ),
                ),
            ),
        ));
    }
}