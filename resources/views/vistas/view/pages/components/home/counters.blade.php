<!-- CONTADORES -->
<div class="counters">
    <div class="counter-box">
        <div class="counter-number fade-up" data-target="{{ $totalUsers }}">+0</div>
        <h1 class="{{ $color ?? 'text-dark' }}"><span data-translate="us_check"></span></h1>
    </div>
    <div class="box-sky fade-up"></div>
    <div class="counter-box">
        <div class="counter-number fade-up" data-target="{{ $totalTutores }}">+0</div>
        <h1 class="{{ $color ?? 'text-dark' }}"><span data-translate="tutor_ok"></span></h1>
    </div>
    <div class="box-sky fade-up"></div>
    <div class="counter-box">
        <div class="counter-number fade-up" data-target="{{ $totalEstudiantes }}">0</div>
        <h1 class="{{ $color ?? 'text-dark' }}"><span data-translate="est_check"></span></h1>
    </div>
    <div class="box-sky fade-up"></div>
    <div class="counter-box">
        <div class="counter-numbe fade-up"><i class="fa fa-star"></i>4.5</div>
        <h1 class="{{ $color ?? 'text-dark' }}"><span data-translate="play_s"></span></h1>
    </div>
</div>