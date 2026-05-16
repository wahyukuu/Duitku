<?php

function icon($name, $class = 'w-5 h-5')
{
  $icons = [

    'saldo' => '',
    'penghasilan' => '',
    'pengeluaran' => '',
    'operasional' => '',

  ];

  return $icons[$name] ?? '';
}
