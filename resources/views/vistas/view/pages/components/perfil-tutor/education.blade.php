@if($tutor->educations->isNotEmpty())
    @foreach ($tutor->educations as $education)
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-content">
                <h3 class="info-card-title">{{ $education->course_title}}</h3>
                <div class="info-card-meta">

                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>{{ $education->institute_name}}</span>
                    </div>
                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span> {{ $education->city }}, {{ $education->country->short_code}}</span>
                    </div>
                    <?php
                        $fechaInicial = $education->start_date;
                        $fechaInicioFormateada = date("d/m/Y", strtotime($fechaInicial));

                        $fechaFinal = $education->end_date;
                        $fechaEndFormateada = date("d/m/Y", strtotime($fechaFinal));
                    ?>
                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ $fechaInicioFormateada}} - {{ $fechaEndFormateada}}</span>
                    </div>

                </div>
            </div>
        </div>
    </div>   
    @endforeach
    
@else

<div class="tutor-empty-box">
    <div class="am-norecord">
        @include('livewire.components.no-record') 
    </div>
</div>
@endif 