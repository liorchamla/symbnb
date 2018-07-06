<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType
{
    protected function getConfiguration($label, $placeholder, $others = []) {
        return array_merge(['label' => $label, 'attr' => [
            'placeholder' => $placeholder
        ]], $others);
    }
}

?>