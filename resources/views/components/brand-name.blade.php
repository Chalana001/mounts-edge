@props(['accent' => 'text-brand-orange'])

{{-- The logo's own wordmark sets EDGE in orange (#fe7f02) on its own line, roughly
     twice the size of MOUNTS and REGENCY. Writing the name as text with the same
     word accented keeps the lockup and the typography in step.

     Pick the accent for the ground it sits on:
       light ground -> text-brand-ember  (5.3:1; brand-orange is only 2.7:1 there)
       dark ground  -> text-brand-orange (5.0:1 on brand-green) --}}
Mounts <span class="{{ $accent }}">Edge</span> Regency
