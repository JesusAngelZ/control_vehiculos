
    @if (auth()->check())
        <h1>Entro</h1>
    @else
        @extends('layouts.plantillabase')
    @endif
