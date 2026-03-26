<?php

use Dompdf\Dompdf;

function create_dompdf(): Dompdf
{
  $pdf = new Dompdf();
  $pdf->setPaper('A4', 'portrait');
  return $pdf;
}
