<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    protected function getConfiguration($label, $placeholder) {
        return ['label' => $label, 'attr' => [
            'placeholder' => $placeholder
        ]];
    }
}

?>