<div class="alianzas">
    <h1>Alianzas que potencian la educación</h1>
    <p>En ClassGo creemos en el poder de la colaboración para transformar el aprendizaje. Por eso, trabajamos junto a instituciones educativas, clubes y organizaciones comprometidas con la formación académica y el desarrollo personal.</p>
    <div class="cards-container">
        @foreach($alianzas as $alianza)
        <a href="{{ $alianza->enlace }}" target="_blank">
            <div class="alianzas-card">
                <img src="{{ $alianza->imagen ? asset('storage/' . $alianza->imagen) : asset('images/tutors/default.png') }}" alt="Imagen de {{ $alianza->titulo }}">
                <div class="card-content">
                    <p>{{ $alianza->titulo }}</p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div> 


