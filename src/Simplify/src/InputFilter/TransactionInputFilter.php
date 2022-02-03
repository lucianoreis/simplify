<?php

namespace Fintech\Simplify\InputFilter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\ToFloat;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\GreaterThan;
use Laminas\Validator\NotEmpty;

class TransactionInputFilter extends InputFilter
{
    public function init()
    {
        $this->add([
            'name' => 'payer',
            'required' => true,
            'allow_empty' => false,
            'filters' => [
                [
                    'name' => ToInt::class,
                ],
            ],
        ]);
        $this->add([
            'name' => 'payee',
            'required' => true,
            'allow_empty' => false,
            'filters' => [
                [
                    'name' => ToInt::class,
                ],
            ],
        ]);
        $this->add([
            'name' => 'amount',
            'required' => true,
            'allow_empty' => false,
            'filters' => [
                [
                    'name' => ToFloat::class,
                ],
            ],
           'validators' => [
               [
                   'name' => NotEmpty::class,
               ],
               [
                   'name' => GreaterThan::class,
                   'options' => [
                       'min' => 0.01
                   ],
               ],
           ],
        ]);
        $this->add([
            'name' => 'description',
            'required' => false,
            'allow_empty' => true,
            'filters' => [
                [
                    'name' => StringTrim::class,
                ],
            ],
            'fallback_value' => 1,
        ]);
    }
}
