@if($tutor->experiences->isNotEmpty())
    @foreach ($tutor->experiences as $experience)
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-content">
                <h3 class="info-card-title">{{ $experience->title}}</h3>
                <span style="color: #9ca3af; margin-left: 1rem;">{!! $experience->description!!}</span>
                <div class="info-card-meta">
                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>{{ $experience->company}}</span>
                    </div>
                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ $experience->employment_type}}</span>
                    </div>
                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h8a2 2 0 002-2v-1a2 2 0 012-2h1.945M7.707 4.293a1 1 0 010 1.414L4.414 9H19.586l-3.293-3.293a1 1 0 010-1.414a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L19.586 15H4.414l3.293 3.293a1 1 0 01-1.414 1.414l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 0z"></path></svg>
                        <span>{{ $experience->location}}</span>
                    </div>
                    <?php 
                        $fechaInicial = $experience->start_date;
                        $fechaInicialFormateada = date('d/m/Y', strtotime($fechaInicial));

                        $fechaFinal = $experience->end_date;
                        $fechaFinalFormateada = date('d/m/Y', strtotime($fechaFinal));
                    ?>
                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ $fechaInicialFormateada}} - {{ $fechaFinalFormateada}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>       
    @endforeach
@else
    <!--En caso de estar vacio-->
    <div class="tutor-empty-box">
        <div class="am-norecord">
            @include('livewire.components.no-record')
        </div>
    </div>
@endif