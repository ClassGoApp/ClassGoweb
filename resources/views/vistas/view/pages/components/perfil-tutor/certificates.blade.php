@if($tutor->certificates->isNotEmpty())
    @foreach ($tutor->certificates as $certificate )
    <div class="info-card">
        <div class="info-card-header">
            <div class="info-card-content">
                <h3 class="info-card-title">{{ $certificate->title}}</h3>
                <div class="info-card-meta">
                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                        <span>{{ $certificate->institute_name}}</span>
                    </div>

                    <?php
                        $fechaInicial = $certificate->issue_date;
                        $fechaInicialFormateado = date('d/m/Y', strtotime($fechaInicial)) ;
                        $fechaFinal = $certificate->expiry_date;
                        $fechaFinalFormateado = date('d/m/Y', strtotime($fechaFinal));
                    ?>
                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ $fechaInicialFormateado}}</span>
                    </div>
                    <div class="info-card-meta-item">
                        <svg class="info-card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ $fechaFinalFormateado}}</span>
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