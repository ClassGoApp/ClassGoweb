@extends('layouts.test-layout') 

@section('content')

    {{-- Usamos estilos inline en lugar de clases Tailwind --}}
    <div style="background-color: #f9f9f9; padding: 40px 0; min-height: 80vh;">
        
        <div style="width: 90%; max-width: 1200px; margin: 0 auto; text-align: center;">
            
            <h2 style="color: #333; font-size: 2rem; font-weight: bold; margin-bottom: 30px;">
                Prueba de Cards
            </h2>
            
            @include('vistas.view.pages.components.cards.cards-tutor')

        </div>
    </div>

@endsection