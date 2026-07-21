<div id="ocultar-elemento" class="am-dbbox">
    <div class="am-dbbox_title">
        <h2 data-translate="tutor_earning_details">
            {{ __('tutor.earning_details') }}
        </h2>

        <div class="am-dbbox_title_sorting">
            <em data-translate="tutor_filter_by">
                {{ __('tutor.filter_by') }}
            </em>

            <div class="am-booking-calander-date flatpicker" wire:ignore>
                <input type="text"
                    class="form-control"
                    id="calendar-month-year"
                    placeholder="Seleccionar mes"
                    data-placeholder-key="tutor_select_month">
            </div>
        </div>
    </div>

    <div class="am-dbbox_content" wire:ignore>
        <canvas id="am-themechart" width="400" height="200"></canvas>
    </div>
</div>
