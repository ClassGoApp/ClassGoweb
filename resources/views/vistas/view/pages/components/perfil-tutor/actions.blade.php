<div class="tutor-actions-card">
    <div class="tutor-actions-price-box">
        <div class="price-container">
            <p class="tutor-actions-price">💸 {{ $tutor->profile->price ?? '15.00' }} Bs.</p> 
            <p class="tutor-actions-price-text"> / tutoría</p>
        </div>
        <div class="tutor-actions-meta">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-actions-meta-icon"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>20 min</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-actions-meta-icon tutor-actions-meta-icon-green"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <span class="tutor-actions-meta-verified">Tutor verificado</span>
        </div>
    </div>
    <div class="tutor-actions-btns">
        @role('student')
            <!--<a href="#reservar">
                <button onclick="goToTab('disponibilidad')" class="tutor-btn tutor-btn-now" id="btn-go-disponibilidad">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-btn-icon"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg>
                    <span>Reservar</span>
                </button>
            </a>-->
            <a href="#reservar" class="tutor-tooltip-wrapper">
                
                <button onclick="goToTab('disponibilidad')" class="tutor-btn tutor-btn-now" id="btn-go-disponibilidad">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-btn-icon"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect><line x1="16" x2="16" y1="2" y2="6"></line><line x1="8" x2="8" y1="2" y2="6"></line><line x1="3" x2="21" y1="10" y2="10"></line></svg>
                    <span>Reservar</span>
                </button>

                <div class="tutor-tooltip-content">
                    <strong>Reserva ahora!</strong>
                    <p>Haz clic para ver el calendario y seleccionar el horario disponible.</p>
                    <div class="tutor-tooltip-arrow"></div>
                </div>
            </a>
                <!--Boton para añadir a favoritos-->
            <livewire:favourite-button :tutorId="$tutor->id" />
        
        @elserole('tutor')
        <a href="{{ route('tutor.dashboard')}}">
            <button class="tutor-btn tutor-btn-now">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            <span>Mi Panel</span>
            </button>
        </a>

        <a href="{{ route('buscar')}}">
                <button class="tutor-btn tutor-btn-reservar" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <span>Buscar más Tutores</span>
                </button>
        </a>
        @endrole    
        

        @auth
            <button class="tutor-btn tutor-btn-share" id="btn-share-profile">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-btn-icon"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line></svg>
                <span>Mis reservas</span>
            </button>
        
        @else
            <a href="{{ route('buscar')}}">
                <button class="tutor-btn tutor-btn-reservar" >
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <span>Buscar más Tutores</span>
                </button>
            </a>
            <button class="tutor-btn tutor-btn-share" id="btn-share-profile">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="tutor-btn-icon"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line></svg>
                <span>Compartir perfil</span>
            </button>
            
        @endauth

        
    </div>
</div>