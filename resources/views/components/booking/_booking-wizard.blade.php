<div>

    <div id="js-booking-modal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;  z-index: 9999;">
        <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px;">

            <div id="js-modal-box"
                style="background:white; border-radius:16px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.25); width:100%; max-width:1100px; position:relative;">


                <div id="js-modal-body">


                    <div class="encabezado-modal">

                        <h2 style="text-align: center; font-size: 24px; font-weight: bold; color: #333;" data-translate="booking_title">
                            Reserva tu Clase
                        </h2>

                        <button id="js-close-modal-btn" type="button"
                            style="position: absolute;color:red; top: 8px; right: 16px; background: none; border: none; font-size: 28px; cursor: pointer; color: #999; line-height: 1;">
                            <svg viewBox="0 0 24 24" width="26" height="26" aria-hidden="true">
                                <path d="M6 6L18 18M18 6L6 18" fill="none" stroke="currentColor" stroke-width="2.8"
                                    stroke-linecap="round" />
                            </svg>
                        </button>


                        <div style="padding-top: 6px;">
                            <div id="stepper-track"
                                style="display: flex; align-items: center; justify-content: center; max-width: 500px; margin: 0 auto; position: relative;">


                                <div id="step-indicator"></div>

                                <div style="display: flex; flex-direction: column; align-items: center;">
                                    <div id="step-icon-1" class="step-icon"
                                        style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        1
                                    </div>
                                    <p class="step-label" style="font-size: 12px;" data-translate="booking_step_subject">Materia</p>
                                </div>

                                <div id="line-1" class="step-line" style="flex: 1; height: 2px; margin: 0 8px;">
                                </div>

                                <div style="display: flex; flex-direction: column; align-items: center;">
                                    <div id="step-icon-2" class="step-icon"
                                        style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        2
                                    </div>
                                    <p class="step-label" style="font-size: 12px;" data-translate="booking_step_schedule">Horario</p>
                                </div>

                                <div id="line-2" class="step-line" style="flex: 1; height: 2px; margin: 0 8px;">
                                </div>

                                <div style="display: flex; flex-direction: column; align-items: center;">
                                    <div id="step-icon-3" class="step-icon"
                                        style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        3
                                    </div>
                                    <p class="step-label" style="font-size: 12px;" data-translate="booking_step_payment">Pago</p>
                                </div>

                            </div>
                        </div>
                    </div>



                    <div style="min-height: 450px; position: relative;margin:10px;">

                        <div id="content-step-1" class="step-panel is-active">
                            <div class="step1-grid" style="display: grid; grid-template-columns: 220px 1fr; gap: 16px;">

                                <div>
                                    <label
                                        style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;"
                                        data-translate="booking_institution_type">
                                        Tipo de institución
                                    </label>
                                    <select id="js-institution-select" class="sr-only" aria-hidden="true">
                                        <option value="" data-translate="booking_select_institution">Selecciona tipo de institución</option>
                                        <option value="colegio" data-translate="booking_school">Colegio</option>
                                        <option value="universidad" data-translate="booking_university">Universidad</option>
                                        <option value="instituto" data-translate="booking_institute">Instituto</option>
                                    </select>


                                    <div class="dd" id="js-inst-dd">
                                        <button type="button" class="dd-btn" id="js-inst-btn" aria-expanded="false">
                                            <span class="dd-label" id="js-inst-label" data-translate="booking_select_institution">
                                                Selecciona tipo de institución
                                            </span>
                                            <span class="dd-chev" aria-hidden="true"></span>
                                        </button>

                                        <div class="dd-menu" id="js-inst-menu" role="listbox">
                                            <button type="button" class="dd-item" data-value="colegio" data-translate="booking_school">Colegio</button>
                                            <button type="button" class="dd-item"
                                                data-value="universidad" data-translate="booking_university">Universidad</button>
                                            <button type="button" class="dd-item"
                                                data-value="instituto" data-translate="booking_institute">Instituto</button>
                                        </div>
                                    </div>
                                </div>


                                <div>
                                    <label
                                        style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;"
                                        data-translate="booking_available_subjects">
                                        Materias disponibles
                                    </label>
                                    <input id="js-subject-search" type="text" class="form-control"
                                        placeholder="Escribe para filtrar tu materia..."
                                        style="margin-bottom: 8px; font-size: 14px;" disabled>

                                    <div id="js-subjects-list"
                                        style="max-height: 295px; overflow-y: auto; border: 1px solid #219EBC;
                             border-radius: 4px; ">
                                        <p
                                            style="padding: 16px; text-align: center; color: #666; margin: 0; font-size: 14px; "
                                            data-translate="booking_select_institution_first">
                                            Selecciona un tipo de institución.
                                        </p>
                                    </div>
                                </div>
                            </div>


                            <div id="js-tutor-container"
                                style="display:block; margin-top:24px; max-width:900px; margin-left:auto; margin-right:auto;">

                                <p id="js-tutor-helper" style="margin-bottom:12px; color:#666; font-size:14px; text-align:center;" data-translate="booking_choose_subject">
                                    Elige una materia para ver los tutores disponibles.
                                </p>

                                <div id="js-tutor-list" style="display:grid; gap:12px;">

                                </div>
                            </div>


                        </div>


                        <div id="content-step-2" class="step-panel" >
                            <div class="slots-layout">
                                <div style="justify-items: center;">
                                    <div id="js-mini-calendar"></div>
                                </div>

                                <div>
                                    <div class="slots-head">
                                        <div>
                                            <div class="slots-title" data-translate="booking_schedules">Horarios</div>
                                            <div class="slots-sub" id="js-selected-date-label" data-translate="booking_today">Hoy</div>
                                        </div>

                                    </div>
                                    

                                    <div id="js-slots-container"></div>
                                    <div style="margin-top: 16px; text-align: center;">
                                        <button type="button" id="js-req-custom-schedule-btn" style="border: 2px solid #219EBC; color: #219EBC; font-size: 13px; padding: 8px 16px; border-radius: 12px; font-weight: 600; cursor: pointer; background: transparent; transition: all 0.15s ease;" data-translate="booking_request_custom_schedule">
                                            Solicitar otro horario
                                        </button>
                                    </div>
                                    <button type="button" id="js-scroll-calendar" class="btn-scroll-calendar" aria-label="Subir al calendario">
                                        <span class="chev-up" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                        </div>



                      
                        <div id="content-step-3" class="step-panel" >

                            <div class="pay-layout"
                                style="display:grid; grid-template-columns: 1fr 1fr; gap:32px; align-items:start;">

                               
                                <div>
                                    <h3 style="color:#023047;font-size:18px; font-weight:600; margin-bottom:16px;" data-translate="booking_booking_summary">
                                        Reserva tu Clase
                                    </h3>

                                    <div style="background:#f8f9fa;  border-radius:12px;">
                                        
                                        <div class="float-field">
                                            <span class="float-label" data-translate="booking_subject">Materia</span>
                                            <span class="float-value" id="js-summary-subject"></span>
                                        </div>

                                        <div class="float-field">
                                            <span class="float-label" data-translate="booking_tutor">Tutor</span>
                                            <span class="float-value" id="js-summary-tutor"></span>
                                        </div>

                                        <div class="float-field">
                                            <span class="float-label" data-translate="booking_date">Fecha</span>
                                            <span class="float-value" id="js-summary-date"></span>
                                        </div>

                                        <div class="float-field">
                                            <span class="float-label" data-translate="booking_time">Hora</span>
                                            <span class="float-value" id="js-summary-time"></span>
                                        </div>

                                        <hr style="margin:16px 0;">

                                        <div style="font-size:18px; font-weight:bold;">
                                            <strong data-translate="booking_total">Total:</strong>
                                            <span id="js-summary-total" style="color:#219EBC;"></span>
                                        </div>

                                        <div id="js-summary-discount-row" style="display:none; margin-top:8px;">
                                            <b data-translate="booking_discount">Descuento</b> (<span id="js-summary-discount-pct">0</span>%):
                                            <span id="js-summary-discount-amount">-0.00</span> Bs.
                                        </div>

                                        <div id="js-summary-free-note"
                                            style="display:none; margin-top:10px; color:#16a34a; font-weight:800;" data-translate="booking_free_message">
                                            ¡Felicidades! Tienes una tutoría gratis <br>
                                             Presiona finalizar reserva.
                                        </div>
                                    </div>


                                    <div style="margin-top:24px;">
                                        <label style="display:block; font-weight:600; margin-bottom:8px;" data-translate="booking_coupon_question">
                                            ¿Tienes un cupón de descuento?
                                        </label>

                                        <div id="js-coupon-form" style="display:flex; gap:8px;">
                                            <input id="js-coupon-input" type="text" placeholder="Ej. classgo25"
                                                style="flex:1; border:1px solid #e5e7eb; border-radius:10px; padding:12px;">
                                            <button id="js-apply-coupon-btn" type="button" data-translate="booking_apply">
                                                Aplicar
                                            </button>
                                        </div>

                                        <p id="js-coupon-message" style="margin-top:8px; min-height:20px;"></p>

                                        
                                        <div id="js-coupon-bar"
                                            style="display:none; margin-top:10px; border:2px dashed #86efac; background:#ecfdf5; padding:10px 12px; border-radius:12px; align-items:center; justify-content:space-between;">
                                            <div style="font-weight:700;">
                                                <span data-translate="booking_coupon_applied">Cupón aplicado:</span>
                                                <span id="js-coupon-code">-</span>
                                            </div>
                                            <button type="button" id="js-remove-coupon"
                                                style="border:none; background:transparent; font-weight:800; color:#065f46; cursor:pointer;" data-translate="booking_remove">
                                                Quitar
                                            </button>
                                        </div>
                                    </div>
                                </div>


                              
                                <div>
                                    

                                    <div style="background:#f8f9fa; padding:24px; border-radius:12px;">
                                        <p style="color:#023047;font-size:14px; margin-bottom:12px;" data-translate="booking_tutor_payment_methods">
                                            Métodos de pago del tutor:
                                        </p>

                                       
                                        <div id="js-pay-grid"
                                            style="display:none; gap:16px; grid-template-columns:1fr 1fr; margin-bottom:14px; align-items:stretch;">

                                           
                                          
           
            <div id="js-card-qr"
                style="background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:14px;
                      display:flex; flex-direction:column; min-height:320px;">

                <div style="text-align:center;">
                    <div
                        style="width:58px; height:58px; border-radius:999px; background:#d1fae5; display:grid; place-items:center; margin:0 auto;">
                        <span style="font-size:24px;"><svg viewBox="0 0 24 24" width="32" height="32"
                                aria-hidden="true">
                              
                                <rect x=" 7" y="2.8" width="10" height="18.4" rx="2.2" fill="none"
                            stroke="currentColor" stroke-width="2" />
                        <path d="M10 5.7h4" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" />
                        <circle cx="12" cy="18.6" r="1" fill="currentColor" />


                        <rect x="2.8" y="7.2" width="3.2" height="3.2" fill="none" stroke="currentColor"
                            stroke-width="1.8" />
                        <rect x="2.8" y="12.0" width="3.2" height="3.2" fill="none" stroke="currentColor"
                            stroke-width="1.8" />
                        <rect x="18.0" y="7.2" width="3.2" height="3.2" fill="none" stroke="currentColor"
                            stroke-width="1.8" />
                        <path d="M18.4 12.2h2.8M18.4 14.2h1.6M20.0 14.2v2.8" fill="none" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" />
                        </svg>
                        </span>
                    </div>
                    <div style="color:#023047;margin-top:8px; font-weight:800;" data-translate="booking_qr_payment">
                        Pago con QR
                    </div>
                </div>

                <div style="margin-top:12px; display:flex; justify-content:center;">
                    <div
                        style="width:170px; height:170px; border:1px dashed #cbd5e1; border-radius:12px; display:grid; place-items:center; overflow:hidden; background:#fff;">
                        <img id="js-qr-img" src="" alt="QR de pago"
                            style="display:none; width:100%; height:100%; object-fit:contain;">
                        <span id="js-qr-empty"
                            style="font-size:12px; color:#6b7280; padding:10px; text-align:center; " data-translate="booking_no_qr">
                            Sin QR configurado
                        </span>
                    </div>
                </div>

                <div style="display:flex; justify-content:center; margin-top:auto; padding-top:12px;">
                    <a id="js-open-qr" href="#" target="_blank" rel="noopener"
                        style="display:none; text-decoration:none; border:1px solid #e5e7eb; background:#219EBC; color:#fff; border-radius:10px; padding:10px 12px; " data-translate="booking_view_qr">
                        Ver QR
                    </a>
                </div>
            </div>
        </div>

        <p id="js-pay-hint" style="display:none; margin:0 0 14px; font-size:12px; color:#6b7280; " data-translate="booking_pay_hint">
            Realiza el pago con el método disponible y luego sube tu comprobante.
        </p>


        <div id="js-receipt-block">
            <label for="js-file-upload"
                style="cursor:pointer; display:block; text-align:center; padding:32px; border:2px dashed #ddd; border-radius:8px;">
                <p style="margin:0; " data-translate="booking_upload_receipt">📄 Subir comprobante</p>
                <p id="js-file-name" style="font-size:12px; color:#999; margin-top:8px;"></p>
            </label>

            <input id="js-file-upload" type="file" accept="image/*,application/pdf" style="display:none;">
        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Panel de Solicitud de Tutores -->
                        <div id="content-step-request_tutor" class="step-panel">
                            <div style="max-width: 950px; margin: 0 auto; padding: 0px 20px;">
                                <h3 style="color:#023047; font-size: 18px; font-weight: 700; margin-bottom: 8px; text-align: center;" data-translate="booking_tutor_request_title">
                                    Solicitud de Tutores
                                </h3>
                                <p id="js-req-desc-text" style="color: #6b7280; font-size: 13px; margin-bottom: 16px; text-align: center;" data-translate="booking_tutor_request_description">
                                    No encontramos tutores disponibles. Envía una solicitud a todos los tutores calificados completando lo siguiente:
                                </p>

                                <div class="slots-layout">
                                    <!-- Columna Izquierda: Calendario -->
                                    <div style="justify-items: center; align-self: start;">
                                        <div id="js-req-mini-calendar"></div>
                                        <div style="margin-top: 8px; font-size: 13px; color: #023047; font-weight: 700; text-align: center;">
                                            <span data-translate="booking_suggested_date">Fecha sugerida:</span>
                                            <span id="js-req-selected-date-label" style="color: #219EBC;">
                                                Ninguna
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Columna Derecha: Campos -->
                                    <div>
                                        <!-- Campo Materia -->
                                        <div class="float-field" style="margin-top: 0;">
                                            <span class="float-label" data-translate="booking_requested_subject">Materia Solicitada</span>
                                            <span class="float-value" id="js-req-subject-name">Materia</span>
                                        </div>

                                        <!-- Sub-grid para Horario y Duración en paralelo -->
                                        <div class="req-details-grid">
                                            
                                            <!-- Horario Sugerido -->
                                            <div>
                                                <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 4px; color: #023047;" data-translate="booking_start_time">
                                                    Hora de inicio
                                                </label>
                                                <div class="digital-time-picker" style="padding: 8px; margin-top: 0; width: 100%; box-sizing: border-box; justify-content: space-between;">
                                                    <select id="js-clock-hour" class="time-select" style="text-align: center; font-size: 15px; padding: 4px 6px; width: 55px;">
                                                        <option value="1">01</option>
                                                        <option value="2">02</option>
                                                        <option value="3">03</option>
                                                        <option value="4">04</option>
                                                        <option value="5">05</option>
                                                        <option value="6">06</option>
                                                        <option value="7">07</option>
                                                        <option value="8">08</option>
                                                        <option value="9">09</option>
                                                        <option value="10" selected>10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                    </select>
                                                    <span class="time-separator" style="font-size: 18px; margin: 0 4px;">:</span>
                                                    <select id="js-clock-minute" class="time-select" style="text-align: center; font-size: 15px; padding: 4px 6px; width: 55px;">
                                                        <option value="0" selected>00</option>
                                                        <option value="5">05</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option>
                                                        <option value="25">25</option>
                                                        <option value="30">30</option>
                                                        <option value="35">35</option>
                                                        <option value="40">40</option>
                                                        <option value="45">45</option>
                                                        <option value="50">50</option>
                                                        <option value="55">55</option>
                                                    </select>

                                                    <div class="ampm-btn-group" style="margin-left: 6px; display: flex; flex-direction: column; gap: 2px;">
                                                        <button type="button" class="ampm-btn active" id="js-clock-ampm-am" style="padding: 2px 6px; font-size: 10px;">AM</button>
                                                        <button type="button" class="ampm-btn" id="js-clock-ampm-pm" style="padding: 2px 6px; font-size: 10px;">PM</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Duración de la sesión -->
                                            <div>
                                                <label style="display: block; font-weight: 600; font-size: 13px; margin-bottom: 4px; color: #023047;" data-translate="booking_session_duration">
                                                    Duración de la sesión
                                                </label>
                                                <div class="duration-grid" style="margin-top: 0; gap: 4px; grid-template-columns: repeat(3, 1fr);">
                                                    <div class="duration-chip active" data-mins="20" style="padding: 6px 4px; font-size: 11px;">20 min</div>
                                                    <div class="duration-chip" data-mins="40" style="padding: 6px 4px; font-size: 11px;">40 min</div>
                                                    <div class="duration-chip" data-mins="60" style="padding: 6px 4px; font-size: 11px;" data-translate="booking_duration_1_hour">1 hora</div>
                                                    <div class="duration-chip" data-mins="80" style="padding: 6px 4px; font-size: 11px;">1h 20m</div>
                                                    <div class="duration-chip" data-mins="100" style="padding: 6px 4px; font-size: 11px;">1h 40m</div>
                                                    <div class="duration-chip" data-mins="120" style="padding: 6px 4px; font-size: 11px;" data-translate="booking_duration_2_hours">2 horas</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Vista Previa de Propuesta y Notas -->
                                        <div style="display: grid; grid-template-columns: 1fr; gap: 12px; margin-top: 12px;">
                                            <div class="proposal-preview" style="margin: 0; padding: 6px 12px; font-size: 13px; border-radius: 8px;">
                                                <span data-translate="booking_proposed_schedule">Horario propuesto:</span>
                                                <span id="js-proposal-time-range">10:00 AM - 10:20 AM</span>
                                            </div>

                                            <!-- Detalles adicionales -->
                                            <div class="float-field" style="margin: 0;">
                                                <span class="float-label" style="font-size: 11px;" data-translate="booking_additional_details">Detalles adicionales / Notas</span>
                                                <textarea id="js-req-note" placeholder="¿Qué temas específicos necesitas repasar?..." data-translate-placeholder="booking_additional_details_placeholder" style="width: 100%; border: none; resize: none; outline: none; font-size: 14px; padding-top: 2px; min-height: 48px; background: transparent;" maxlength="300"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div id="js-req-message" class="form-msg" style="display: none; margin-top: 8px; padding: 6px 10px; font-size: 12px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <div id="js-loader"
                        style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: white; align-items: center; justify-content: center; flex-direction: column;">
                        <div
                            style="width: 64px; height: 64px; border: 4px solid #219EBC; border-top-color: transparent; border-radius: 50%; animation: spin 1s linear infinite;">
                        </div>
                        <p style="margin-top: 16px; " data-translate="booking_processing">Procesando...</p>
                    </div>


                    <div id="js-confirmation"
                        style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: white; align-items: center; justify-content: center; flex-direction: column; text-align: center;">
                        <div style="font-size: 64px; color: #28a745; margin-bottom: 16px;">✓</div>
                        <h3 style="color:black;font-size: 24px; font-weight: bold; margin-bottom: 8px;" data-translate="booking_success">¡Reserva exitosa!</h3>

                    </div>
                </div>



                <div id="js-navigation-buttons">


                    <button id="js-back-btn" type="button" class="btn btn-secondary" data-translate="booking_cancel">Cancelar</button>
                    <button id="js-next-btn" type="button" class="btn btn-primary" data-translate="booking_next">Siguiente</button>
                </div>


            </div>
        </div>
 
        
<link rel="stylesheet" href="{{ asset('css/estilos/variables.css') }}">

<style>
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .step-panel {
        display: none;
        opacity: 0;
        transform: translateY(10px);
        pointer-events: none;
        transition: opacity 0.18s ease, transform 0.18s ease;
        will-change: opacity, transform;
    }

    .step-panel.is-active {
        display: block;
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
        transition: opacity 0.18s ease, transform 0.18s ease;
    }

    .sr-only {
        position: absolute !important;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    .dd {
        position: relative;
        width: 100%;
    }

    .dd-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 8px;
        border-radius: 12px;
        border: 1px solid rgba(2, 48, 71, 0.18);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        cursor: pointer;
        transition: box-shadow 0.18s ease, border-color 0.18s ease,
            transform 0.12s ease;
    }

    .dd-btn:hover {
        border-color: #8ecae6;
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.1);
    }

    .dd-btn:active {
        transform: scale(0.99);
    }

    .dd-label {
        font-size: 14px;
        color: #0f172a;
    }

    .dd-chev {
        width: 10px;
        height: 10px;
        border-right: 2px solid rgb(255, 255, 255);
        border-bottom: 2px solid rgb(255, 255, 255);
        transform: rotate(45deg);
        transition: transform 0.18s ease;
    }

    .dd-menu {
        position: absolute;
        left: 0;
        right: 0;
        top: calc(100% + 8px);
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid #219EBC;
        border-radius: 4px;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.16);
        display: none;
        z-index: 200;
    }

    .dd.is-open .dd-menu {
        display: block;
    }

    .dd.is-open .dd-chev {
        transform: rotate(-135deg);
    }

    .dd.has-value.is-open .dd-btn {
        background: #023047 !important;
    }

    .dd-item {
        width: 100%;
        text-align: left;
        border: 0;
        background: #219ebc;
        padding: 12px 12px;

        margin: 1px;
        cursor: pointer;
        font-size: 14px;
        color: white;
        transition: background 0.14s ease, transform 0.08s ease;
    }

    .dd-item:hover {
        background: #023047;
    }

    .dd-item:active {
        transform: scale(0.99);
    }

    .dd-item.is-selected {
        background: #023047;
        color: white;
    }

    .dd.has-value .dd-btn {
        background: #023047;
        border-color: white;
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.14);
    }

    .dd.has-value .dd-label {
        color: white;
    }

    #js-tutor-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 14px;
    }

    .tutor-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px;
        display: flex;
        gap: 10px;
        cursor: pointer;
        color: #334155;
        transition: background 0.15s ease, border-color 0.15s ease,
            box-shadow 0.15s ease, transform 0.15s ease;
    }

    .tutor-card div>* {
        color: inherit;
    }

    .tutor-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transform: translateY(-1px);
    }

    .tutor-card:active {
        transform: translateY(0px) scale(0.99);
    }

    .tutor-card.is-selected {
        background: linear-gradient(180deg, rgba(7, 59, 76, 1) 64%, rgba(24, 77, 94, 1) 89%, rgba(33, 158, 188, 1) 108%);
        border-color: #219ebc;
        color: #fff;
    }

    .tutor-card .tutor-avatar {
        width: 58px;
        height: 58px;
        border-radius: 999px;
        flex: 0 0 58px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
    }

    .tutor-card .tutor-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .tutor-card .tutor-info {
        flex: 1;
        min-width: 0;
    }


    .tutor-card .tutor-name {
        font-weight: 800;
        font-size: 14px;
        margin: 0 0 6px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }


    .tutor-card .tutor-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }

    .tutor-card .tutor-badge {
        font-size: 12px;
        line-height: 1;
        padding: 7px 10px;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
        white-space: nowrap;
    }


    .tutor-card .tutor-badge.price {
        border-color: rgba(13, 110, 253, 0.22);
        background: rgba(13, 110, 253, 0.08);
        color: #439c33;
        font-weight: 700;
    }


    .tutor-card.is-selected .tutor-badge.price {
        color: #fff;
        border-color: rgba(255, 255, 255, 0.35);
        background: rgba(255, 255, 255, 0.12);
    }


    .tutor-card.is-selected .tutor-badge {
        border-color: rgba(255, 255, 255, 0.28);
        background: rgba(255, 255, 255, 0.1);
    }


    .tutor-card .tutor-check {
        width: 26px;
        height: 26px;
        border: 1px solid #e5e7eb;
        display: grid;
        place-items: center;
        background: #fff;
        transition: background 0.14s ease, border-color 0.14s ease, color 0.14s ease;
    }


    .tutor-card.is-selected .tutor-check {
        border-color: #023047;
        background: #023047;
        color: #fff;
    }

    .tutor-card.is-selected:hover {
        border-color: #023047;
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .tutor-card.is-selected div h4,
    .tutor-card.is-selected div p {
        color: #fff;
    }

    .mini-cal {
        background: #219ebc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px;
        max-width: 320px;
    }

    .mini-cal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
        gap: 10px;
        background: #023047;
        padding: 0 10px;
        border-radius: 7px;
        height: 3rem;
    }

    .mini-cal-title {
        font-weight: 800;
        font-size: 28px;
        color: #CDD6DA;
        text-transform: uppercase;
    }

    .mini-cal-nav {
        display: flex;
        gap: 8px;
    }

    .btn-scroll-calendar {
        display: none;
        position: sticky;
        bottom: 12px;
        margin-left: auto;

        width: 46px;
        height: 46px;
        border-radius: 999px;

        border: 1px solid rgba(0, 0, 0, 0.12);
        outline: none;
        padding: 0;
        appearance: none;

        border: 1px solid rgba(0, 0, 0, 0.12);
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        box-shadow: 0 12px 26px rgba(0, 0, 0, 0.12);
        cursor: pointer;

        font-size: 18px;
        font-weight: 900;
        line-height: 1;

        opacity: 0;
        transform: translateY(8px) scale(0.98);
        pointer-events: none;
        transition: opacity 0.16s ease, transform 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 60;
    }

    .btn-scroll-calendar .chev-up {
        width: 14px;
        height: 14px;
        display: inline-block;
        border-right: 2.5px solid currentColor;
        border-bottom: 2.5px solid currentColor;
        transform: rotate(-135deg);
    }

    .btn-scroll-calendar.is-visible {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    .btn-scroll-calendar:active {
        transform: translateY(0) scale(0.94);
    }

    .mini-btn {
        color: white;
        font-size: 50px;
        cursor: pointer;

        transform: translateY(-6px);
    }

    .mini-cal-week {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        font-size: 11px;
        color: white;
        margin-bottom: 8px;
        text-align: center;
    }

    .mini-cal-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        justify-items: center;
        align-items: center;

        min-height: 200px;
    }

    .day-btn {
        position: relative;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: 1px solid #cdd6daa1;
        cursor: pointer;
        font-size: 12px;
        color: #111827;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .day-btn.muted {
        opacity: 0.25;
        pointer-events: none;
        border-color: transparent;
        background: transparent;
    }

    .day-btn.today {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
    }

    .day-btn.selected {
        background: #023047;
        border-color: #0d6efd;
        color: #fff;
    }

    .day-btn.has-slots::after {
        content: "";
        position: absolute;
        top: 5px;
        right: 6px;
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #22c55e;
    }

    .day-btn.selected.has-slots::after {
        background: #fff;
    }


    .day-btn.no-slots {
        background: transparent;
        border-color: transparent;
        box-shadow: none;

    }

    .slots-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 10px;
    }

    .slots-title {
        font-weight: 800;
        font-size: 14px;
    }

    .slots-sub {
        font-size: 12px;
        color: #6b7280;
    }

    .btn-today {
        border: 1px solid #e5e7eb;
        background: #fff;
        border-radius: 10px;
        padding: 8px 10px;
        font-size: 12px;
        cursor: pointer;
    }

    .slots-legend {
        display: flex;
        gap: 14px;
        align-items: center;
        margin: 6px 0 12px;
        font-size: 12px;
        color: #6b7280;
    }

    .slots-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 20px;
        align-items: start;
    }

    .req-details-grid {
        display: grid;
        grid-template-columns: 1.1fr 1.2fr;
        gap: 16px;
        margin-top: 12px;
    }

    @media (max-width: 768px) {
        .slots-layout {
            grid-template-columns: 1fr;
            gap: 16px;
            justify-items: center;
        }
        .slots-layout > div {
            width: 100%;
        }
        .req-details-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
    }

    #js-req-custom-schedule-btn:hover {
        background: #219EBC !important;
        color: #fff !important;
    }

    /* Estilos del Reloj Digital */
    .digital-time-picker {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 14px;
        padding: 16px;
        border: 1px solid #e5e7eb;
        margin-top: 16px;
        width: 100%;
        max-width: 280px;
        margin-left: auto;
        margin-right: auto;
    }

    .time-select {
        border: 2px solid #cbd5e1;
        background: #ffffff;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 18px;
        font-weight: 700;
        color: #023047;
        outline: none;
        cursor: pointer;
        transition: border-color 0.15s ease;
        text-align: center;
        width: 75px;
    }

    .time-select:focus {
        border-color: #219ebc;
    }

    .time-separator {
        font-size: 24px;
        font-weight: 800;
        color: #023047;
        margin: 0 8px;
    }

    .ampm-btn-group {
        display: flex;
        gap: 6px;
    }

    .ampm-btn {
        border: 1px solid #cbd5e1;
        background: #ffffff;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .ampm-btn.active {
        background: #023047;
        color: #ffffff;
        border-color: #023047;
    }

    /* Estilos del selector de duración */
    .duration-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-top: 10px;
    }

    .duration-chip {
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        border-radius: 10px;
        padding: 8px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
    }

    .duration-chip:hover {
        border-color: #219ebc;
        color: #219ebc;
    }

    .duration-chip.active {
        background: #219ebc;
        color: #ffffff;
        border-color: #219ebc;
    }

    .proposal-preview {
        background: #ecfdf5;
        border: 1px dashed #10b981;
        color: #065f46;
        border-radius: 12px;
        padding: 12px;
        margin-top: 16px;
        text-align: center;
        font-size: 14px;
        font-weight: 700;
    }

    /* Clase dinámica para el botón de solicitud */
    #js-next-btn.btn-request {
        background: #f97316; /* Naranja (Tailwind orange-500) */
        box-shadow: 0 10px 22px rgba(249, 115, 22, 0.25);
    }
    
    #js-next-btn.btn-request:hover {
        box-shadow: 0 12px 26px rgba(249, 115, 22, 0.35);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 10px;
        border: 1px solid #e5e7eb;
        border-radius: 999px;
        background: #fff;
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

    .dot-available {
        background: #22c55e;
    }

    .dot-unavailable {
        background: #9ca3af;
    }


    .slots-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: clamp(8px, 1.2vw, 14px);
        align-items: start;
    }

    .slot-chip {
        width: 100%;
        justify-content: space-between;

        display: inline-flex;
        align-items: center;
        gap: 10px;

        border: 1px solid #cbd5e1;
        background: #219ebc;
        color: #fff;
        border-radius: 999px;
        padding: 10px 12px;

        font-size: 12px;
        cursor: pointer;
        user-select: none;
        line-height: 1;

        transition: transform 0.08s ease, box-shadow 0.12s ease,
            border-color 0.12s ease;
    }

    .slot-chip {
        will-change: transform, opacity;
    }

    .slot-chip:hover {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.12);
        background: #fff;
        color: #000000;
    }

    .slot-chip:active {
        transform: scale(0.98);
    }

    .slot-chip.active {
        background: #023047;
        border-color: #0d6efd;
        color: #fff;
    }

    .slot-chip .chip-time {
        font-weight: 600;
    }

    .slot-chip .chip-dot {
        margin-left: auto;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #22c55e;
    }

    .slot-chip.disabled {
        opacity: 0.45;
        cursor: not-allowed;
    }

    .slot-chip.disabled:hover {
        border-color: #cbd5e1;
        box-shadow: none;
    }

    .slot-chip.disabled .chip-dot {
        background: #9ca3af;
    }

    .form-msg {
        margin-top: 10px;
        padding: 10px 12px;
        border-radius: 12px;
        font-size: 13px;
        border: 1px solid #e5e7eb;
        background: #fff;
    }

    .form-msg.error {
        border-color: rgba(220, 53, 69, 0.35);
        background: rgba(220, 53, 69, 0.08);
        color: #b02a37;
    }

    .form-msg.success {
        border-color: rgba(34, 197, 94, 0.35);
        background: rgba(34, 197, 94, 0.08);
        color: #166534;
    }


    .input-error {
        outline: 3px solid rgba(220, 53, 69, 0.15);
        border-color: rgba(220, 53, 69, 0.55) !important;
        border-radius: 10px;
    }

    .modal-qr {
        width: 15rem;
        height: 15rem;
        margin: 0 auto;

    }

    .qr-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }

    #js-booking-modal {
        background: rgba(2, 6, 23, 0.55) !important;
        backdrop-filter: blur(12px) saturate(130%);
        -webkit-backdrop-filter: blur(12px) saturate(130%);

        opacity: 0;
        pointer-events: none;
        transition: opacity 420ms cubic-bezier(0.16, 1, 0.3, 1);
    }

    #js-modal-box {
        opacity: 0;
        transform: translateY(22px) scale(0.985);
        transition: opacity 320ms cubic-bezier(0.16, 1, 0.3, 1),
            transform 700ms cubic-bezier(0.16, 1, 0.3, 1);
    }


    #js-booking-modal.is-open {
        opacity: 1;
        pointer-events: auto;
    }

    #js-booking-modal.is-open #js-modal-box {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    @keyframes bookingOverlayIn {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    #js-modal-body {
        flex: 1 1 auto;
        overflow-y: auto;
        padding: 4px;
        -webkit-overflow-scrolling: touch;
    }


    .encabezado-modal {
        position: sticky;
        top: 0;
        z-index: 60;
        background: #fff;
        padding: 4px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    }


    #stepper-track {
        position: relative;
    }


    #step-indicator {
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 40px;
        border-radius: 999px;
        background: rgba(33, 158, 188, 0.14);
        border: 2px solid rgba(33, 158, 188, 0.55);
        transform: translateX(0);
        transition: transform 420ms cubic-bezier(0.22, 1, 0.36, 1),
            background-color 220ms ease, border-color 220ms ease;
        pointer-events: none;
        z-index: 0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }


    .step-icon {
        position: relative;
        z-index: 1;
        transition: transform 250ms ease, background-color 250ms ease,
            color 250ms ease;
    }


    .step-line {
        transition: background-color 280ms ease;
    }


    .step-label {
        transition: color 250ms ease;
    }

    .tutor-card:focus-visible,
    .slot-chip:focus-visible,
    .mini-btn:focus-visible,
    .day-btn:focus-visible {
        outline: 3px solid rgba(13, 110, 253, 0.25);
        outline-offset: 2px;
    }


    #js-modal-box {
        height: 90vh;
        max-height: 90vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .float-field {
        position: relative;
        border: 2px solid #d1d5db;
        border-radius: 14px;
        padding: 16px 14px 12px;
        background: #fff;
        margin-bottom: 12px;
    }

    .float-label {
        position: absolute;
        top: -10px;
        left: 12px;
        background: #fff;
        padding: 0 8px;
        font-size: 12px;
        font-weight: 600;
        color: #219ebc;
    }

    .float-value {
        display: block;
        font-size: 16px;
        color: #111827;
        line-height: 1.2;
        word-break: break-word;
    }

    .slots-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 16px;
        align-items: start;
    }

    #js-mini-calendar {
        position: sticky;
        top: 12px;
        align-self: start;
    }


    .slots-layout>div:last-child {
        min-height: 0;
    }


    #js-slots-container {
        max-height: 52vh;
        overflow-y: auto;
        padding-right: 6px;
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
        border-radius: 14px;

        background: #fff;
    }

    .slot-chip {
        min-height: 44px;
    }


    #js-apply-coupon-btn {
        border: 1px solid rgba(15, 23, 42, 0.1) !important;
        background: #eef2f7 !important;
        color: #0f172a !important;

        border-radius: 12px !important;
        padding: 8px 16px !important;


        font-size: 14px;
        letter-spacing: 0.2px;

        cursor: pointer;
        user-select: none;


        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1), 0 2px 0 rgba(15, 23, 42, 0.12);


        transform: translateY(0);
        transition: transform 0.08s ease, box-shadow 0.12s ease, filter 0.12s ease;
    }


    #js-apply-coupon-btn:hover {
        filter: brightness(0.98);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.12), 0 2px 0 rgba(15, 23, 42, 0.14);
    }


    #js-apply-coupon-btn:active {
        transform: translateY(2px);

        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12), 0 0px 0 rgba(15, 23, 42, 0);

    }


    #js-apply-coupon-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    #js-apply-coupon-btn:focus-visible {
        outline: 3px solid rgba(13, 110, 253, 0.25);
        outline-offset: 2px;
    }


    #js-summary-free-note {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 420ms cubic-bezier(0.16, 1, 0.3, 1),
            transform 520ms cubic-bezier(0.16, 1, 0.3, 1), display 520ms;
        transition-behavior: allow-discrete;
    }


    #js-summary-free-note[style*="display:none"],
    #js-summary-free-note[style*="display: none"] {
        opacity: 0;
        transform: translateY(10px);
        display: none;
    }


    @starting-style {
        #js-summary-free-note {
            opacity: 0;
            transform: translateY(10px);
        }
    }


    #js-coupon-bar {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 420ms cubic-bezier(0.16, 1, 0.3, 1),
            transform 520ms cubic-bezier(0.16, 1, 0.3, 1), display 520ms;
        transition-behavior: allow-discrete;
    }

    #js-coupon-bar[style*="display:none"],
    #js-coupon-bar[style*="display: none"] {
        opacity: 0;
        transform: translateY(10px);
        display: none;
    }

    @starting-style {
        #js-coupon-bar {
            opacity: 0;
            transform: translateY(10px);
        }
    }


    #js-navigation-buttons {
        position: sticky;
        bottom: 0;
        left: 0;
        right: 0;

        display: flex;
        gap: 12px;
        padding: 12px 14px;
        padding-bottom: calc(12px + env(safe-area-inset-bottom));

        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        border-top: 1px solid rgba(15, 23, 42, 0.1);
        box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.08);

        z-index: 999;
    }


    #js-navigation-buttons .btn {
        flex: 1 1 0;
        min-height: 48px;

        padding: 0 16px;
        border-radius: 14px;
        line-height: 1;
        white-space: nowrap;

    }


    #js-back-btn,
    #js-next-btn {
        flex: 1 1 0;
    }


    #js-back-btn {
        background: #eef2f7;
        color: #0f172a;
        border: 1px solid rgba(15, 23, 42, 0.1);
    }


    #js-next-btn {
        background: #219ebc;
        color: #fff;
        box-shadow: 0 10px 22px rgba(33, 158, 188, 0.25);
    }


    #js-navigation-buttons .btn:hover {
        filter: brightness(0.98);
        box-shadow: 0 12px 26px rgba(0, 0, 0, 0.1);
    }

    #js-navigation-buttons .btn:active {
        transform: scale(0.98);
    }

    #js-navigation-buttons .btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }


    #js-navigation-buttons .btn:focus-visible {
        outline: 3px solid rgba(13, 110, 253, 0.25);
        outline-offset: 2px;
    }

    #js-next-btn::after {
        content: " →";
        font-weight: 900;
        opacity: 0.9;
    }

    #js-back-btn::before {
        content: "←";
        font-weight: 900;
        opacity: 0.75;
    }

    @media (prefers-reduced-motion: reduce) {
        * {
            scroll-behavior: auto !important;
        }
    }

    @media (max-width: 900px) {

        .tutor-card {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 12px;
            padding: 14px;
        }

        #js-tutor-list {
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }

        .tutor-card .tutor-avatar {
            width: 78px;
            height: 78px;
            flex: 0 0 78px;
        }

        .tutor-card .tutor-info {
            width: 100%;
        }

        .tutor-card .tutor-meta {
            justify-content: center;
        }



        #js-pay-grid {
            grid-template-columns: 1fr !important;
        }

        .pay-layout {
            grid-template-columns: 1fr !important;
            gap: 16px !important;
        }

        .slots-layout {
            grid-template-columns: 1fr;
        }

        #js-mini-calendar {
            position: relative;
            top: 0;
        }

        .btn-scroll-calendar {
            display: grid;
            place-items: center;
        }

        #js-slots-container {
            max-height: none;
            overflow: visible;
            padding-right: 0;
        }

        .mini-cal {
            max-width: 100%;
        }
    }

    @media (max-width: 640px) {
        #js-modal-box {

            max-height: 100vh;
            border-radius: 0;
        }

        #js-modal-body {

            height: 100%;
        }

        #js-navigation-buttons {
            padding: 12px;
        }

        #js-navigation-buttons .btn {
            height: 50px;
            font-size: 15px;
            border-radius: 16px;
        }

        .step1-grid {
            grid-template-columns: 1fr !important;
        }

        #js-subjects-list {
            max-height: 240px !important;
        }

        input,
        select {
            font-size: 16px !important;
        }
    }

    @media (max-width: 600px) {
        #js-tutor-list {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)) !important;
        }

        .slots-grid {
            gap: 8px;
        }

        .slot-chip {
            padding: 9px 10px;
            gap: 8px;
        }
    }

    @media (max-width: 480px) {

        .tutor-card {
            padding: 12px;
        }
    }
</style>


<script>
    (function() {
        console.log('🚀 WIZARD CARGADO - 3 instituciones');



        let currentStep = 1;
        let hasNoTutors = false;


        let selectedInstitution = null;
        let allSubjects = [];
        let selectedSubject = null;
        let selectedSubjectName = null;


        let selectedTutor = null;
        let selectedTutorName = null;
        let targetTutorId = null;
        let targetTutorName = null;
        let tutorRequestToken = null;
        let selectedTutorPrice = 0;


        let selectedSlots = [];
        let selectedCoupon = null;
        let comprobanteFile = null;
        let basePrice = 0;
        let currentPrice = 0;

        let appliedDiscountDecimal = 0;
        let appliedDiscountPct = 0;
        let isFreeBooking = false;
        let appliedCouponCode = null;


        let slotsByDate = {};
        let calendarYear = null;
        let calendarMonth = null;
        let selectedDate = null;

        let reqCalendarYear = null;
        let reqCalendarMonth = null;
        let reqSelectedDate = null;

        let clockHour = 10;
        let clockMinute = 0;
        let clockAmPm = 'AM';
        let clockMode = 'hour';
        let selectedDurationMins = 20;
        let reqSelectedTimeRange = '';





        const modal = document.getElementById('js-booking-modal');
        const closeBtn = document.getElementById('js-close-modal-btn');
        const backBtn = document.getElementById('js-back-btn');
        const nextBtn = document.getElementById('js-next-btn');
        const loader = document.getElementById('js-loader');
        const confirmation = document.getElementById('js-confirmation');
        const navigationButtons = document.getElementById('js-navigation-buttons');

        const modalBox = document.getElementById('js-modal-body');

    function bookingText(key, fallback = '') {
    const lang = localStorage.getItem('selectedLanguage') || 'es';

    if (typeof translations === 'undefined') {
        return fallback;
    }

    const t = translations[lang] || translations.es;

    return t[key] || fallback;
    }

    function bookingArray(key, fallback = []) {
    const lang = localStorage.getItem('selectedLanguage') || 'es';

    if (typeof translations === 'undefined') {
        return fallback;
    }

    const t = translations[lang] || translations.es;

    return Array.isArray(t[key]) ? t[key] : fallback;
}

    function translateBookingModal() {
    if (typeof translations === 'undefined') {
        console.warn('translations.js no está cargado en esta página.');
        return;
    }

    const lang = localStorage.getItem('selectedLanguage') || 'es';
    const t = translations[lang] || translations.es;

    document.querySelectorAll('#js-booking-modal [data-translate]').forEach((element) => {
        const key = element.getAttribute('data-translate');

        if (t[key]) {
            element.innerHTML = t[key];
        }
    });

    document.querySelectorAll('#js-booking-modal [data-translate-placeholder]').forEach((element) => {
        const key = element.getAttribute('data-translate-placeholder');

        if (t[key]) {
            element.setAttribute('placeholder', t[key]);
        }
    });

    if (subjectSearch && t.booking_search_subject) {
        subjectSearch.placeholder = t.booking_search_subject;
    }

    if (couponInput && t.booking_coupon_placeholder) {
        couponInput.placeholder = t.booking_coupon_placeholder;
    }

    const scrollCalendarBtn = document.getElementById('js-scroll-calendar');
    if (scrollCalendarBtn && t.booking_scroll_calendar) {
        scrollCalendarBtn.setAttribute('aria-label', t.booking_scroll_calendar);
    }

    const qrImage = document.getElementById('js-qr-img');
    if (qrImage && t.booking_qr_alt) {
        qrImage.setAttribute('alt', t.booking_qr_alt);
    }

    updateNavButtons();
}

        function scrollTopStep() {
            if (!modalBox) return;
            modalBox.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function scrollToTutors() {
            if (!tutorContainer || !modalBox) return;


            tutorContainer.style.display = 'block';


            const top = tutorContainer.offsetTop - 12;
            modalBox.scrollTo({
                top,
                behavior: 'smooth'
            });
        }

        function lockBody(lock) {
            document.body.style.overflow = lock ? 'hidden' : '';
        }



        if (window._bookingWizardEscapeListener) {
            document.removeEventListener('keydown', window._bookingWizardEscapeListener);
        }
        window._bookingWizardEscapeListener = (e) => {
            if (e.key !== 'Escape') return;
            if (!modal || modal.style.display !== 'block') return;
            if (loader && loader.style.display === 'flex') return;
            closeModal();
        };
        document.addEventListener('keydown', window._bookingWizardEscapeListener);


        const institutionSelect = document.getElementById('js-institution-select');
        const subjectSearch = document.getElementById('js-subject-search');
        const subjectsList = document.getElementById('js-subjects-list');


        const tutorContainer = document.getElementById('js-tutor-container');
        const tutorHelper = document.getElementById('js-tutor-helper');
        const tutorList = document.getElementById('js-tutor-list');




        const slotsContainer = document.getElementById('js-slots-container');


        const couponInput = document.getElementById('js-coupon-input');
        const applyCouponBtn = document.getElementById('js-apply-coupon-btn');
        const couponMessage = document.getElementById('js-coupon-message');

        const fileUpload = document.getElementById('js-file-upload');
        const fileName = document.getElementById('js-file-name');
        const receiptBlock = document.getElementById('js-receipt-block');

        const couponBar = document.getElementById('js-coupon-bar');
        const couponCodeEl = document.getElementById('js-coupon-code');
        const removeCouponBtn = document.getElementById('js-remove-coupon');
        const freeMsg = document.getElementById('js-free-msg');


        const summaryDiscountRow = document.getElementById('js-summary-discount-row');
        const summaryDiscountPct = document.getElementById('js-summary-discount-pct');
        const summaryDiscountAmount = document.getElementById('js-summary-discount-amount');
        const summaryFreeNote = document.getElementById('js-summary-free-note');




        const formMsg = document.createElement('div');

        const payGrid = document.getElementById('js-pay-grid');
        const payHint = document.getElementById('js-pay-hint');

        // const cardBank = document.getElementById('js-card-bank');
        // const bankInfo = document.getElementById('js-bank-info');
        // const copyBank = document.getElementById('js-copy-bank');

        const cardQR = document.getElementById('js-card-qr');
        const qrImg = document.getElementById('js-qr-img');
        const qrEmpty = document.getElementById('js-qr-empty');
        const openQR = document.getElementById('js-open-qr');

        const receiptLabel = document.querySelector('label[for="js-file-upload"]');
        const fileUploadInput = document.getElementById(
            'js-file-upload');




        async function loadTutorPaymentInfo() {
            if (!payGrid) return;
            const lang = localStorage.getItem('selectedLanguage') || 'es';
            const t = translations[lang] || translations.es;
            payGrid.style.display = 'grid';
            payHint.style.display = 'block';
            payHint.textContent = t.booking_pay_hint;

            cardQR.style.display = 'block';
            const qrSrc = `/storage/qr/Qr-pagos.png`;

            qrImg.src = qrSrc;
            qrImg.style.display = 'block';
            qrEmpty.style.display = 'none';

            openQR.href = qrSrc;
            openQR.style.display = 'inline-block';
        }

        formMsg.className = 'form-msg';
        formMsg.style.display = 'none';


        fileUpload.parentElement.appendChild(formMsg);

        function showFormMsg(text, type = 'error') {
            formMsg.className = `form-msg ${type}`;
            formMsg.textContent = text;
            formMsg.style.display = 'block';
        }

        function hideFormMsg() {
            formMsg.style.display = 'none';
            formMsg.textContent = '';
        }

        function openModal() {
            console.log('📖 Abriendo modal');
            modal.style.display = 'block';
            lockBody(true);
            resetModalState();

             translateBookingModal();

            requestAnimationFrame(() => modal.classList.add('is-open'));

            scrollTopStep();
        }


        function closeModal() {
            if (modal.style.display !== 'block') return;


            modal.classList.remove('is-open');

            const box = document.getElementById('js-modal-box');

            const done = () => {
                modal.style.display = 'none';
                lockBody(false);
                resetModalState();
            };


            const onEnd = (e) => {
                if (e.target !== box) return;
                if (e.propertyName !== 'transform') return;
                box.removeEventListener('transitionend', onEnd);
                done();
            };

            box.addEventListener('transitionend', onEnd);


            setTimeout(done, 850);
        }


        const dd = document.getElementById('js-inst-dd');
        const ddBtn = document.getElementById('js-inst-btn');
        const ddMenu = document.getElementById('js-inst-menu');
        const ddLabel = document.getElementById('js-inst-label');

        function closeDD() {
            dd?.classList.remove('is-open');
            ddBtn?.setAttribute('aria-expanded', 'false');
        }

        function openDD() {
            dd?.classList.add('is-open');
            ddBtn?.setAttribute('aria-expanded', 'true');
        }

        ddBtn?.addEventListener('click', () => {
            if (!dd) return;
            dd.classList.contains('is-open') ? closeDD() : openDD();
        });


        ddMenu?.addEventListener('click', (e) => {
            const item = e.target.closest('.dd-item');
            if (!item || !institutionSelect) return;

            const value = item.dataset.value || '';
            const text = item.textContent.trim();


            ddMenu.querySelectorAll('.dd-item').forEach(x => x.classList.remove('is-selected'));
            item.classList.add('is-selected');


            ddLabel.textContent = text;
            dd?.classList.add('has-value');


            institutionSelect.value = value;
            institutionSelect.dispatchEvent(new Event('change', {
                bubbles: true
            }));

            closeDD();
        });


        if (window._bookingWizardCloseDDClickListener) {
            document.removeEventListener('click', window._bookingWizardCloseDDClickListener);
        }
        window._bookingWizardCloseDDClickListener = (e) => {
            if (!dd) return;
            if (!dd.contains(e.target)) closeDD();
        };
        document.addEventListener('click', window._bookingWizardCloseDDClickListener);


        if (window._bookingWizardCloseDDEscapeListener) {
            document.removeEventListener('keydown', window._bookingWizardCloseDDEscapeListener);
        }
        window._bookingWizardCloseDDEscapeListener = (e) => {
            if (e.key === 'Escape') closeDD();
        };
        document.addEventListener('keydown', window._bookingWizardCloseDDEscapeListener);


        function resetModalState() {
            currentStep = 1;
            hasNoTutors = false;
            targetTutorId = null;
            targetTutorName = null;
            tutorRequestToken = null;


            selectedInstitution = null;

            const instDD = document.getElementById('js-inst-dd');
            const instLabel = document.getElementById('js-inst-label');
            const instBtn = document.getElementById('js-inst-btn');
            const instMenu = document.getElementById('js-inst-menu');

            if (institutionSelect) institutionSelect.value = ''; // select real (oculto)


            if (instLabel) instLabel.textContent = bookingText('booking_select_institution', 'Selecciona tipo de institución');
            if (instDD) {
                instDD.classList.remove('has-value', 'is-open');
            }
            if (instBtn) instBtn.setAttribute('aria-expanded', 'false');


            instMenu?.querySelectorAll('.dd-item').forEach(x => x.classList.remove('is-selected'));

            allSubjects = [];
            selectedSubject = null;
            selectedSubjectName = null;


            selectedTutor = null;
            selectedTutorName = null;
            selectedTutorPrice = 0;

            selectedSlots = [];
            selectedCoupon = null;
            comprobanteFile = null;
            basePrice = 0;
            currentPrice = 0;


            slotsByDate = {};
            calendarYear = null;
            calendarMonth = null;
            selectedDate = null;

            reqCalendarYear = null;
            reqCalendarMonth = null;
            reqSelectedDate = null;
            const reqLabel = document.getElementById('js-req-selected-date-label');
            if (reqLabel) reqLabel.textContent = bookingText('booking_none', 'Ninguna');
            const reqCalendarEl = document.getElementById('js-req-mini-calendar');
            if (reqCalendarEl) reqCalendarEl.innerHTML = '';

            clockHour = 10;
            clockMinute = 0;
            clockAmPm = 'AM';
            clockMode = 'hour';
            selectedDurationMins = 20;
            reqSelectedTimeRange = '';

            appliedDiscountDecimal = 0;
            appliedDiscountPct = 0;
            isFreeBooking = false;
            appliedCouponCode = null;


            hideCouponBar();
            if (freeMsg) freeMsg.style.display = 'none';
            if (summaryFreeNote) summaryFreeNote.style.display = 'none';
            if (summaryDiscountRow) summaryDiscountRow.style.display = 'none';


            if (receiptLabel) receiptLabel.style.display = 'block';
            comprobanteFile = null;
            fileUpload.value = '';
            fileName.textContent = '';
            hideFormMsg();


            institutionSelect.value = '';
            subjectSearch.value = '';
            subjectSearch.disabled = true;

            const t = typeof translations !== 'undefined'
                ? (translations[localStorage.getItem('selectedLanguage') || 'es'] || translations.es)
                : null;

            subjectsList.innerHTML = 
            `<p style="padding: 16px; text-align: center; color: #666; margin: 0; font-size: 14px;"
            data-translate="booking_select_institution_first">
            ${t?.booking_select_institution_first || 'Selecciona un tipo de institución.'}
            </p>`;


            tutorContainer.style.display = 'none';
            tutorHelper.textContent = bookingText('booking_choose_subject', 'Elige una materia para ver los tutores disponibles.');
            tutorList.innerHTML = '';


            slotsContainer.innerHTML = '';
            if (miniCalendarEl) miniCalendarEl.innerHTML = '';
            if (selectedDateLabel) selectedDateLabel.textContent = bookingText('booking_today', 'Hoy');


            couponInput.value = '';
            couponMessage.textContent = '';
            fileName.textContent = '';

            updateStepUI();
            updateContent();
            updateNavButtons();

            requestAnimationFrame(() => {
                requestAnimationFrame(scrollTopStep);
            });

            loader.style.display = 'none';
            confirmation.style.display = 'none';
            navigationButtons.style.display = 'flex';
        }


        const miniCalendarEl = document.getElementById('js-mini-calendar');
        const selectedDateLabel = document.getElementById('js-selected-date-label');
        const scrollCalBtn = document.getElementById('js-scroll-calendar');
        const modalBody = document.getElementById('js-modal-body');

        function toggleScrollCalendarBtn() {
            if (!scrollCalBtn || !modalBody) return;

            const isMobile = window.matchMedia('(max-width: 900px)').matches;
            const show = isMobile && modalBody.scrollTop > 220;

            scrollCalBtn.classList.toggle('is-visible', show);
        }

        function smoothScrollTo(el, to, duration = 650) {
            if (!el) return;

            const start = el.scrollTop;
            const change = to - start;
            const startTime = performance.now();


            const easeInOutCubic = (t) =>
                t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

            function animateScroll(now) {
                const elapsed = now - startTime;
                const t = Math.min(1, elapsed / duration);
                el.scrollTop = start + change * easeInOutCubic(t);

                if (t < 1) requestAnimationFrame(animateScroll);
            }

            requestAnimationFrame(animateScroll);
        }

        scrollCalBtn?.addEventListener('click', () => {
            if (!miniCalendarEl || !modalBody) return;

            const target = miniCalendarEl.offsetTop - 10;


            smoothScrollTo(modalBody, target, 800);
        });

        modalBody?.addEventListener('scroll', toggleScrollCalendarBtn, {
            passive: true
        });


        if (window._bookingWizardResizeListener) {
            window.removeEventListener('resize', window._bookingWizardResizeListener);
        }
        window._bookingWizardResizeListener = toggleScrollCalendarBtn;
        window.addEventListener('resize', window._bookingWizardResizeListener);


        toggleScrollCalendarBtn();
        requestAnimationFrame(toggleScrollCalendarBtn);


        function todayStr() {
            const d = new Date();
            const yyyy = d.getFullYear();
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        }

        function monthName(m) {
            const names = bookingArray('booking_months', [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ]);

            return names[m];
        }

        function renderMiniCalendar(y, m) {
            calendarYear = y;
            calendarMonth = m;

            const first = new Date(y, m, 1);
            const startDay = first.getDay();
            const daysInMonth = new Date(y, m + 1, 0).getDate();

            const week = bookingArray('booking_week_days_short', ['D', 'L', 'M', 'M', 'J', 'V', 'S']);

            miniCalendarEl.innerHTML = `
    <div class="mini-cal">
      <div class="mini-cal-header">
        <div class="mini-cal-title">${monthName(m)}</div>
        <div class="mini-cal-nav">
          <button class="mini-btn" type="button" id="cal-prev">‹</button>
          <button class="mini-btn" type="button" id="cal-next">›</button>
        </div>
      </div>

      <div class="mini-cal-week">
        ${week.map(w => `<div>${w}</div>`).join('')}
      </div>

      <div class="mini-cal-grid" id="cal-grid"></div>
    </div>
  `;

            const grid = miniCalendarEl.querySelector('#cal-grid');


            const blanks = startDay;
            for (let i = 0; i < blanks; i++) {
                const b = document.createElement('button');
                b.type = 'button';
                b.className = 'day-btn muted';
                b.textContent = '';
                grid.appendChild(b);
            }

            const today = todayStr();

            for (let day = 1; day <= daysInMonth; day++) {
                const dd = String(day).padStart(2, '0');
                const mm = String(m + 1).padStart(2, '0');
                const dateStr = `${y}-${mm}-${dd}`;

                const hasSlots = Array.isArray(slotsByDate[dateStr]) && slotsByDate[dateStr].length > 0;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'day-btn';
                if (dateStr === today) btn.classList.add('today');
                if (hasSlots) btn.classList.add('has-slots');
                else btn.classList.add('no-slots');
                if (dateStr === selectedDate) btn.classList.add('selected');

                btn.textContent = day;
                btn.addEventListener('click', () => selectDate(dateStr));

                grid.appendChild(btn);
            }

            miniCalendarEl.querySelector('#cal-prev').addEventListener('click', () => {
                const prev = new Date(y, m - 1, 1);
                renderMiniCalendar(prev.getFullYear(), prev.getMonth());
            });

            miniCalendarEl.querySelector('#cal-next').addEventListener('click', () => {
                const next = new Date(y, m + 1, 1);
                renderMiniCalendar(next.getFullYear(), next.getMonth());
            });
        }

        function selectDate(dateStr) {
            selectedDate = dateStr;


            miniCalendarEl.querySelectorAll('.day-btn').forEach(b => b.classList.remove('selected'));

            renderMiniCalendar(calendarYear, calendarMonth);


            const isToday = dateStr === todayStr();
            selectedDateLabel.textContent = isToday
                ? bookingText('booking_today', 'Hoy')
                : dateStr;


            renderSlotsForDate(dateStr);
        }


        function renderSlotsForDate(dateStr) {
            const slots = slotsByDate[dateStr] || [];
            selectedSlots = [];

            if (!slots.length) {
             const emptySlotsMessage = dateStr === todayStr()
                ? bookingText('booking_no_slots_today', 'Sin horarios disponibles hoy.')
                : bookingText('booking_no_slots_that_day', 'Sin horarios disponibles ese día.');

            slotsContainer.innerHTML = 
            `<p style="margin:0; padding:14px; color:#6b7280;">
            ${emptySlotsMessage}
            </p>`;
            return;
        }


            slots.sort((a, b) => {
                const as = String(a.id).split('|')[1] || '';
                const bs = String(b.id).split('|')[1] || '';
                return as.localeCompare(bs);
            });


            let grid = slotsContainer.querySelector('.slots-grid');
            if (!grid) {
                slotsContainer.innerHTML = '';
                grid = document.createElement('div');
                grid.className = 'slots-grid';
                slotsContainer.appendChild(grid);
            }


            const firstRects = new Map();
            const existing = new Map();

            grid.querySelectorAll('.slot-chip').forEach(el => {
                firstRects.set(el.dataset.slotId, el.getBoundingClientRect());
                existing.set(el.dataset.slotId, el);
            });


            const nextIds = new Set(slots.map(s => String(s.id)));


            existing.forEach((el, id) => {
                if (!nextIds.has(id)) {
                    el.animate(
                        [{
                            opacity: 1,
                            transform: 'translateY(0)'
                        }, {
                            opacity: 0,
                            transform: 'translateY(6px)'
                        }], {
                            duration: 500,
                            easing: 'ease-out',
                            fill: 'forwards'
                        }
                    );
                    setTimeout(() => el.remove(), 140);
                    existing.delete(id);
                }
            });


            const frag = document.createDocumentFragment();

            slots.forEach((slot) => {
                const id = String(slot.id);
                const [, start, end] = id.split('|');

                const available = slot.available !== false;

                let chip = existing.get(id);

                if (!chip) {

                    chip = document.createElement('button');
                    chip.type = 'button';
                    chip.className = 'slot-chip';
                    chip.dataset.slotId = id;


                    chip.style.opacity = '0';
                    chip.style.transform = 'translateY(10px) scale(.98)';
                }


                chip.innerHTML = `
      <span class="chip-time">${start} - ${end}</span>
      <span class="chip-dot"></span>
    `;

                chip.classList.toggle('disabled', !available);


                chip.onclick = () => {
                    if (!available) return;

                    const idStr = String(slot.id);
                    const idx = selectedSlots.findIndex(s => s.id === idStr);

                    if (idx !== -1) {
                        // Deseleccionar y limpiar siguientes si existe (por simplicidad, vaciar selección y volver a empezar si se hace clic en uno ya seleccionado)
                        selectedSlots = [];
                        grid.querySelectorAll('.slot-chip').forEach(c => c.classList.remove(
                            'active'));
                    } else {
                        // Intentar agregar
                        const newSlot = {
                            id: slot.id,
                            date: slot.date,
                            time: `${start} - ${end}`,
                            start,
                            end,
                        };

                        if (selectedSlots.length === 0) {
                            selectedSlots.push(newSlot);
                            chip.classList.add('active');
                        } else if (selectedSlots.length < 6) {
                            // Validar contigüidad
                            // Aseguramos que estén ordenados
                            selectedSlots.sort((a, b) => a.start.localeCompare(b.start));
                            const first = selectedSlots[0];
                            const last = selectedSlots[selectedSlots.length - 1];

                            if (slot.date === first.date && (end === first.start || start === last
                                    .end)) {
                                selectedSlots.push(newSlot);
                                chip.classList.add('active');
                            } else {
                                // Reiniciar selección si hacen clic en un slot no contiguo
                                selectedSlots = [newSlot];
                                grid.querySelectorAll('.slot-chip').forEach(c => c.classList.remove(
                                    'active'));
                                chip.classList.add('active');
                            }
                        } else {
                            alert(bookingText('booking_max_slots_alert', 'Solo puedes seleccionar un máximo de 6 bloques (2 horas).'));
                        }
                    }

                    console.log('✅ Slots seleccionados:', selectedSlots);
                };

                frag.appendChild(chip);
            });


            grid.innerHTML = '';
            grid.appendChild(frag);


            const lastRects = new Map();
            grid.querySelectorAll('.slot-chip').forEach(el => {
                lastRects.set(el.dataset.slotId, el.getBoundingClientRect());
            });

            grid.querySelectorAll('.slot-chip').forEach((el, idx) => {
                const id = el.dataset.slotId;
                const first = firstRects.get(id);
                const last = lastRects.get(id);


                if (first && last) {
                    const dx = first.left - last.left;
                    const dy = first.top - last.top;


                    el.style.transition = 'transform 0s';
                    el.style.transform = `translate(${dx}px, ${dy}px)`;


                    requestAnimationFrame(() => {
                        el.style.transition = 'transform 520s cubic-bezier(.16, 1, .3, 1)';
                        el.style.transform = '';
                    });
                } else {

                    const delay = Math.min(idx * 85, 1100);

                    el.animate(
                        [{
                                opacity: 0,
                                transform: 'translateY(12px) scale(.985)'
                            },
                            {
                                opacity: 1,
                                transform: 'translateY(0) scale(1)'
                            }
                        ], {
                            duration: 620,
                            delay,
                            easing: 'cubic-bezier(.16, 1, .3, 1)',
                            fill: 'forwards'
                        }
                    );



                    el.style.opacity = '';
                    el.style.transform = '';
                }
            });
        }

        function hidePayUIOnSubmit() {

            if (payGrid) payGrid.style.display = 'none';
            if (payHint) payHint.style.display = 'none';
            // if (cardBank) cardBank.style.display = 'none';
            if (cardQR) cardQR.style.display = 'none';


            if (receiptLabel) receiptLabel.style.display = 'none';
            if (fileName) fileName.textContent = '';


        }

        function showPayUIAfterError() {

            if (payGrid) payGrid.style.display = 'grid';
            if (payHint) payHint.style.display = 'block';


            if (receiptLabel) receiptLabel.style.display = isFreeBooking ? 'none' : 'block';
        }


        if (window._bookingWizardOpenClickListener) {
            document.removeEventListener('click', window._bookingWizardOpenClickListener);
        }
        window._bookingWizardOpenClickListener = function(e) {
            if (e.target.closest('.js-open-booking')) {
                e.preventDefault();
                openModal();
            }
        };
        document.addEventListener('click', window._bookingWizardOpenClickListener);
        closeBtn.addEventListener('click', closeModal);

        let antiCloseArmed = false;

        modal.addEventListener('click', (e) => {
            if (e.target !== modal) return;

            const hasProgress = !!selectedTutor || selectedSlots.length > 0 || !!comprobanteFile || !!
                appliedCouponCode;

            if (!hasProgress) {
                if (selectedSlots.length > 0) releaseHolds();
                closeModal();
                return;
            }

            if (!antiCloseArmed) {
                antiCloseArmed = true;


                if (typeof showFormMsg === 'function') {
                    showFormMsg(bookingText('booking_click_outside_alert', 'Toca afuera otra vez para cerrar (así no pierdes tu progreso).'), 'error');
                }

                setTimeout(() => (antiCloseArmed = false), 2000);
                return;
            }

            if (selectedSlots.length > 0 && currentStep > 2) {
                releaseHolds();
            }
            closeModal();
        });

        console.log('nextBtn encontrado?', !!document.getElementById('js-next-btn'));

        nextBtn.addEventListener('click', async () => {
            if (currentStep === 1) {
                if (hasNoTutors) {
                    currentStep = 'request_tutor';
                    document.getElementById('js-req-subject-name').textContent = selectedSubjectName;
                    
                    reqSelectedDate = todayStr();
                    const reqLabel = document.getElementById('js-req-selected-date-label');
                    if (reqLabel) reqLabel.textContent = bookingText('booking_today', 'Hoy');
                    
                    const now = new Date();
                    renderReqMiniCalendar(now.getFullYear(), now.getMonth());

                    clockHour = 10;
                    clockMinute = 0;
                    clockAmPm = 'AM';
                    selectedDurationMins = 20;

                    const hourSel = document.getElementById('js-clock-hour');
                    if (hourSel) hourSel.value = '10';
                    const minSel = document.getElementById('js-clock-minute');
                    if (minSel) minSel.value = '0';

                    document.getElementById('js-clock-ampm-am')?.classList.add('active');
                    document.getElementById('js-clock-ampm-pm')?.classList.remove('active');

                    document.querySelectorAll('.duration-chip').forEach(c => {
                        if (parseInt(c.dataset.mins) === 20) c.classList.add('active');
                        else c.classList.remove('active');
                    });

                    updateProposalTime();

                    document.getElementById('js-req-note').value = '';
                    document.getElementById('js-req-message').style.display = 'none';

                    updateStepUI();
                    updateContent();
                    updateNavButtons();
                    scrollTopStep();
                    return;
                }
                if (!selectedSubject || !selectedTutor) {
                    alert(bookingText('booking_select_subject_tutor_alert', 'Por favor selecciona una materia y un tutor'));
                    return;
                }
                await loadSlots();
            } else if (currentStep === 2) {
                if (selectedSlots.length === 0) {
                    alert(bookingText('booking_select_schedule_alert', 'Por favor selecciona al menos un horario continuo.'));
                    return;
                }

                // Intento de hold
                nextBtn.disabled = true;
                const held = await holdSlots();
                nextBtn.disabled = false;

                if (!held) {
                    await loadSlots();
                    return; // nos quedamos en el paso 2
                }

                recalcTotals();
                updateSummary();
                await loadTutorPaymentInfo();
            } else if (currentStep === 3) {
                await submitBooking();
                return;
            } else if (currentStep === 'request_tutor') {
                await submitTutorRequest();
                return;
            }

            if (currentStep < 3) {
                currentStep++;
                updateStepUI();
                updateContent();
                updateNavButtons();


                requestAnimationFrame(() => requestAnimationFrame(scrollTopStep));
            }
        });



        backBtn.addEventListener('click', () => {
            if (currentStep === 1) {
                closeModal();
                return;
            }
            if (currentStep === 'request_tutor') {
                currentStep = targetTutorId ? 2 : 1;
                updateStepUI();
                updateContent();
                updateNavButtons();
                scrollTopStep();
                return;
            }
            if (currentStep === 3) {
                releaseHolds(); // Libera al retroceder
            }
            currentStep--;
            updateStepUI();
            updateContent();
            updateNavButtons();

            requestAnimationFrame(() => {
                requestAnimationFrame(scrollTopStep);
            });


        });

        const reqCustomScheduleBtn = document.getElementById('js-req-custom-schedule-btn');
        reqCustomScheduleBtn?.addEventListener('click', () => {
            targetTutorId = selectedTutor;
            targetTutorName = selectedTutorName;
            
            currentStep = 'request_tutor';
            document.getElementById('js-req-subject-name').textContent = selectedSubjectName;
            
            const descText = document.getElementById('js-req-desc-text');
            if (descText) {
                descText.textContent = bookingText(
                'booking_tutor_request_direct_description',
                'Envía una propuesta de horario directamente a :name completando lo siguiente:'
            ).replace(':name', targetTutorName);
            }

            reqSelectedDate = todayStr();
            const reqLabel = document.getElementById('js-req-selected-date-label');
            if (reqLabel) reqLabel.textContent = bookingText('booking_today', 'Hoy');
            
            const now = new Date();
            renderReqMiniCalendar(now.getFullYear(), now.getMonth());

            clockHour = 10;
            clockMinute = 0;
            clockAmPm = 'AM';
            selectedDurationMins = 20;

            const hourSel = document.getElementById('js-clock-hour');
            if (hourSel) hourSel.value = '10';
            const minSel = document.getElementById('js-clock-minute');
            if (minSel) minSel.value = '0';

            document.getElementById('js-clock-ampm-am')?.classList.add('active');
            document.getElementById('js-clock-ampm-pm')?.classList.remove('active');

            document.querySelectorAll('.duration-chip').forEach(c => {
                if (parseInt(c.dataset.mins) === 20) c.classList.add('active');
                else c.classList.remove('active');
            });

            updateProposalTime();

            document.getElementById('js-req-note').value = '';
            document.getElementById('js-req-message').style.display = 'none';

            updateStepUI();
            updateContent();
            updateNavButtons();
            scrollTopStep();
        });

        // ====== EVENTOS PASO 1 ======


        institutionSelect.addEventListener('change', async (e) => {
            selectedInstitution = e.target.value;


            console.log("Institución seleccionada:", selectedInstitution);


            selectedSubject = null;
            selectedTutor = null;
            basePrice = 0;
            currentPrice = 0;
            hasNoTutors = false;
            updateNavButtons();


            subjectSearch.value = '';
            subjectsList.innerHTML =
            `<p style="padding: 16px; text-align: center; color: #666;">${bookingText('booking_loading_subjects', 'Cargando materias...')}</p>`;



            if (!selectedInstitution) {
                subjectSearch.disabled = true;
                subjectsList.innerHTML =
                    `<p style="padding: 16px; text-align: center; color: #666;">${bookingText('booking_select_institution_first', 'Selecciona un tipo de institución.')}</p>`;
                return;
            }

            await loadSubjectsByInstitution(selectedInstitution);
        });

        subjectSearch.addEventListener('input', (e) => {
            filterSubjects(e.target.value);
        });

        applyCouponBtn.addEventListener('click', async () => {
            const codigo = couponInput.value.trim();
            if (!codigo) return;

            try {
                const response = await fetch('/student/booking/validar-cupon', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content
                    },
                    body: JSON.stringify({
                        codigo
                    })
                });

                const data = await response.json();

                if (data.success) {
                    selectedCoupon = data.coupon_id;
                    appliedCouponCode = codigo;

                    appliedDiscountDecimal = Number(data.descuento || 0); // 0..1
                    appliedDiscountPct = Math.round(appliedDiscountDecimal * 100); // 0..100

                    showCouponBar(codigo);

                    couponMessage.textContent = data.message || bookingText('booking_coupon_valid', 'Cupón aplicado correctamente.');
                    couponMessage.style.color = '#28a745';

                    recalcTotals();
                } else {
                    couponMessage.textContent = data.message || bookingText('booking_coupon_invalid', 'Cupón inválido o vencido.');
                    couponMessage.style.color = '#dc3545';
                }
            } catch (error) {
                console.error('Error:', error);
                couponMessage.textContent = bookingText('booking_coupon_error', 'Error al validar cupón');
                couponMessage.style.color = '#dc3545';
            }
        });
        removeCouponBtn?.addEventListener('click', () => {
            selectedCoupon = null;
            appliedCouponCode = null;
            appliedDiscountDecimal = 0;
            appliedDiscountPct = 0;

            couponInput.value = '';
            couponMessage.textContent = '';
            hideCouponBar();

            recalcTotals();
        });

        fileUpload.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                comprobanteFile = e.target.files[0];
                fileName.textContent = comprobanteFile.name;
                fileUpload.classList.remove('input-error');
                hideFormMsg();
            }
        });

        // Reloj digital y Duración
        document.querySelectorAll('.duration-chip').forEach(chip => {
            chip.addEventListener('click', () => {
                document.querySelectorAll('.duration-chip').forEach(c => c.classList.remove('active'));
                chip.classList.add('active');
                selectedDurationMins = parseInt(chip.dataset.mins || '20');
                updateProposalTime();
            });
        });

        document.getElementById('js-clock-hour')?.addEventListener('change', (e) => {
            clockHour = parseInt(e.target.value);
            updateProposalTime();
        });

        document.getElementById('js-clock-minute')?.addEventListener('change', (e) => {
            clockMinute = parseInt(e.target.value);
            updateProposalTime();
        });

        document.getElementById('js-clock-ampm-am')?.addEventListener('click', () => {
            clockAmPm = 'AM';
            document.getElementById('js-clock-ampm-am').classList.add('active');
            document.getElementById('js-clock-ampm-pm').classList.remove('active');
            updateProposalTime();
        });

        document.getElementById('js-clock-ampm-pm')?.addEventListener('click', () => {
            clockAmPm = 'PM';
            document.getElementById('js-clock-ampm-pm').classList.add('active');
            document.getElementById('js-clock-ampm-am').classList.remove('active');
            updateProposalTime();
        });


        function updateStepUI() {
            const ACTIVE_BG = '#219EBC';
            const ACTIVE_TEXT = '#ffffff';
            const IDLE_BG = '#ddd';
            const IDLE_TEXT = '#999';


            for (let i = 1; i <= 3; i++) {
                const icon = document.getElementById(`step-icon-${i}`);
                if (!icon) continue;

                const label = icon.parentElement?.querySelector('.step-label');

                const isActive = i === currentStep;
                const isDone = i < currentStep;

                if (isActive) {
                    icon.style.backgroundColor = ACTIVE_BG;
                    icon.style.color = ACTIVE_TEXT;
                    icon.style.transform = 'scale(1.10)';
                    if (label) label.style.color = '#333';
                } else if (isDone) {
                    icon.style.backgroundColor = ACTIVE_BG;
                    icon.style.color = ACTIVE_TEXT;
                    icon.style.transform = 'scale(1)';
                    if (label) label.style.color = '#666';
                } else {
                    icon.style.backgroundColor = IDLE_BG;
                    icon.style.color = IDLE_TEXT;
                    icon.style.transform = 'scale(1)';
                    if (label) label.style.color = '#999';
                }
            }


            for (let i = 1; i <= 2; i++) {
                const line = document.getElementById(`line-${i}`);
                if (!line) continue;
                line.style.backgroundColor = i < currentStep ? ACTIVE_BG : '#ddd';
            }


            const track = document.getElementById('stepper-track');
            const indicator = document.getElementById('step-indicator');
            const targetIcon = document.getElementById(`step-icon-${currentStep}`);

            if (track && indicator && targetIcon) {
                const trackRect = track.getBoundingClientRect();
                const iconRect = targetIcon.getBoundingClientRect();
                const x = iconRect.left - trackRect.left;

                requestAnimationFrame(() => {
                    indicator.style.transform = `translateX(${x}px)`;
                });
            }
        }

        function updateContent() {
            [1, 2, 3, 'request_tutor'].forEach(i => {
                const el = document.getElementById(`content-step-${i}`);
                if (!el) return;

                if (i === currentStep) {
                    el.classList.add('is-active');
                } else {
                    el.classList.remove('is-active');
                }
            });
        }




        function updateNavButtons() {
            const lang = localStorage.getItem('selectedLanguage') || 'es';
            const t = typeof translations !== 'undefined'
                ? (translations[lang] || translations.es)
                : null;

            backBtn.disabled = false;

            if (currentStep === 1) {
                backBtn.textContent = t?.booking_cancel || 'Cancelar';
                if (hasNoTutors) {
                    nextBtn.textContent = t?.booking_request_tutors || 'Solicitar Tutores';
                    nextBtn.classList.add('btn-request'); // Cambia a naranja
                } else {
                    nextBtn.textContent = t?.booking_next || 'Siguiente';
                    nextBtn.classList.remove('btn-request');
                }
            } else if (currentStep === 'request_tutor') {
                backBtn.textContent = t?.booking_back || 'Atrás';
                nextBtn.textContent = t?.booking_send_request || 'Enviar Solicitud';
                nextBtn.classList.add('btn-request'); // Mantiene el naranja
            } else {
                backBtn.textContent = t?.booking_back || 'Atrás';
                nextBtn.textContent = currentStep === 3
                    ? (t?.booking_finish || 'Finalizar Reserva')
                    : (t?.booking_next || 'Siguiente');
                nextBtn.classList.remove('btn-request');
            }
        }

        // ====== CARGA DE MATERIAS SEGÚN INSTITUCIÓN ======
        async function loadSubjectsByInstitution(institution) {
            subjectSearch.disabled = true;
            try {
                const response = await fetch(`/student/booking/materias?institution=${institution}`);
                const data = await response.json();
                console.log('Materias recibidas', data);

                if (!data.success) {
                    subjectsList.innerHTML =
                        `<p style="padding: 16px; text-align: center; color: red;">${bookingText('booking_error_loading_subjects', 'Error al cargar materias')}</p>`;
                    return;
                }

                allSubjects = data.subjects || [];

               if (allSubjects.length === 0) {
                   subjectsList.innerHTML =
                        `<p style="padding: 16px; text-align: center; color: white; margin: 0;"> ${bookingText('booking_no_subjects', '⚠️ No hay materias registradas para esta institución.')}</p>`;
                return;
                }

                renderSubjects(allSubjects);
                subjectSearch.disabled = false;
            } catch (error) {
                console.error('Error al cargar materias:', error);
                subjectsList.innerHTML =
                    `<p style="padding: 16px; text-align: center; color: red;"> ${bookingText('booking_error_loading_subjects', 'Error al cargar materias')}</p>`;
            }
        }

        function renderSubjects(subjects) {
            subjectsList.innerHTML = '';

            subjects.forEach(subject => {
                const item = document.createElement('div');


                item.style.cssText =
                    'padding:12px; margin:1px; background:#219EBC;  cursor:pointer; border:2px solid transparent; transition:all .2s;';

                item.innerHTML = `
      <strong style="font-size:14px; color:white;">${subject.name}</strong>
    `;

                item.dataset.subjectId = subject.id;
                item.dataset.subjectName = subject.name;

                item.addEventListener('click', async () => {

                    subjectsList.querySelectorAll('div').forEach(d => {
                        d.style.border = '2px solid transparent';
                        d.style.backgroundColor = '#219EBC';
                        const strong = d.querySelector('strong');
                        if (strong) strong.style.color = '#fff';
                    });


                    item.style.border = '2px solid #023047';
                    item.style.backgroundColor = '#023047';
                    const myStrong = item.querySelector('strong');
                    if (myStrong) myStrong.style.color = 'white';

                    selectedSubject = subject.id;
                    selectedSubjectName = subject.name;

                    await loadTutors(subject.id);
                });

                subjectsList.appendChild(item);
            });
        }



        function filterSubjects(searchTerm) {
            const term = searchTerm.toLowerCase();
            const filtered = allSubjects.filter(subj =>
                subj.name.toLowerCase().includes(term)
            );
            renderSubjects(filtered);
        }

        // ====== CARGA DE TUTORES ======
        async function loadTutors(subjectId) {

            tutorContainer.style.display = 'block';
            tutorHelper.textContent = bookingText('booking_loading_tutors', 'Cargando tutores...');
            tutorList.innerHTML = '';


            selectedTutor = null;
            selectedTutorName = null;
            selectedTutorPrice = 0;
            basePrice = 0;
            currentPrice = 0;
            hasNoTutors = false;
            updateNavButtons();


            scrollToTutors();

            try {
                const response = await fetch(`/student/booking/tutores?subject_id=${subjectId}`);
                const data = await response.json();

                console.log('Respuesta tutores', data);

                if (!data.success) {
                    tutorHelper.textContent = data.message || bookingText('booking_error_loading_tutors', 'Error al cargar tutores.');
                    return;
                }

                if (!Array.isArray(data.tutors) || data.tutors.length === 0) {
                    tutorHelper.textContent = bookingText('booking_no_tutors', 'No hay tutores disponibles para esta materia.');
                    tutorList.innerHTML = '';
                    hasNoTutors = true;
                    updateNavButtons();
                    return;
                }

                tutorHelper.textContent = bookingText('booking_choose_tutor_continue', 'Elige un tutor para continuar.');
                tutorList.innerHTML = '';

                data.tutors.forEach((tutor, i) => {
                    const fullName = tutor.full_name || tutor.name || 'Tutor';
                    const price = parseFloat(tutor.price || 0);
                    const tutorId = tutor.user_id;

                    const card = document.createElement('div');
                    card.className = 'tutor-card';
                    card.dataset.tutorId = tutorId;

                    const imgSrc = tutor.image_url ?
                        tutor.image_url :
                        (tutor.image ? `/storage/${tutor.image}` : '/images/tutors/default.png');


                    card.innerHTML = `
  <div class="tutor-avatar">
    <img src="${imgSrc}" alt="Foto de ${fullName}">
  </div>

  <div class="tutor-info">
    <h4 class="tutor-name">${fullName}</h4>

    <div class="tutor-meta">
      <span class="tutor-badge price">$ Bs. ${price.toFixed(2)}</span>
    </div>
  </div>

`;

                    card.addEventListener('click', () => {
                        tutorList.querySelectorAll('.tutor-card').forEach(c => c.classList
                            .remove('is-selected'));
                        card.classList.add('is-selected'); 

                        selectedTutor = tutorId;
                        selectedTutorName = fullName;
                        selectedTutorPrice = price;
                        basePrice = price;
                        currentPrice = basePrice;
                    });


                    card.style.opacity = '0';
                    card.style.transform = 'translateY(14px) scale(.98)';

                    tutorList.appendChild(card);

                    requestAnimationFrame(() => {
                        if (typeof card.animate !== 'function') {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0) scale(1)';
                            return;
                        }

                        card.animate(
                            [{
                                    opacity: 0,
                                    transform: 'translateY(14px) scale(.98)'
                                },
                                {
                                    opacity: 1,
                                    transform: 'translateY(0) scale(1)'
                                }
                            ], {
                                duration: 520,
                                delay: i * 60,
                                easing: 'cubic-bezier(.16, 1, .3, 1)',
                                fill: 'forwards'
                            }
                        );
                    });
                });


                requestAnimationFrame(() => scrollToTutors());

            } catch (error) {
                console.error('Error al cargar tutores', error);
                tutorHelper.textContent = bookingText('booking_error_loading_tutors', 'Error al cargar tutores.');
                tutorList.innerHTML = '';
            }
        }




        // ====== CARGA DE HORARIOS ======
        async function loadSlots() {
            slotsContainer.innerHTML =
                 `<p style="text-align:center; padding: 24px;">${bookingText('booking_loading_slots', 'Cargando horarios...')}</p>`;

            selectedSlots = [];
            slotsByDate = {};
            selectedDate = null;

            try {
                const response = await fetch(`/student/booking/horarios-multi/${selectedTutor}`);
                const data = await response.json();
                console.log("HORARIOS RAW:", data);
                console.log("SLOT EJEMPLO:", data?.slots?.[0]);


                if (!data.success) {
                    slotsContainer.innerHTML =
                        `<p style="text-align:center; padding: 24px;">${bookingText('booking_error_loading_slots', 'Error al cargar horarios')}</p>`;
                    return;
                }

                if (!Array.isArray(data.slots) || data.slots.length === 0) {
                    slotsContainer.innerHTML =
                        `<p style="text-align:center; padding: 24px;">${bookingText('booking_no_slots', 'No hay horarios disponibles')}</p>`;


                    const now = new Date();
                    renderMiniCalendar(now.getFullYear(), now.getMonth());
                    selectDate(todayStr());
                    return;
                }


                slotsByDate = data.slots.reduce((acc, s) => {
                    if (!acc[s.date]) acc[s.date] = [];
                    acc[s.date].push(s);
                    return acc;
                }, {});


                const now = new Date();
                renderMiniCalendar(now.getFullYear(), now.getMonth());
                selectDate(todayStr());



            } catch (error) {
                console.error('Error al cargar horarios:', error);
                slotsContainer.innerHTML =
                    `<p style="text-align:center; padding: 24px;">${bookingText('booking_error_loading_slots', 'Error al cargar horarios')}</p>`;
            }
        }



        // ====== RESUMEN + SUBMIT ======
        function updateSummary() {
            const subjectName = selectedSubjectName || 'N/A';
            const tutorName = selectedTutorName || 'N/A';

            selectedSlots.sort((a, b) => a.start.localeCompare(b.start));
            const first = selectedSlots[0];
            const last = selectedSlots[selectedSlots.length - 1];

            const durationMins = selectedSlots.length * 20;
            const durationTxt = durationMins >= 60 ?
                (durationMins % 60 === 0
                ? `${durationMins / 60} ${bookingText('booking_duration_hour', 'hora(s)')}`
                : `${Math.floor(durationMins / 60)} ${bookingText('booking_duration_hour_short', 'h')} ${durationMins % 60} ${bookingText('booking_duration_min_short', 'min')}`)
                : `${durationMins} ${bookingText('booking_duration_minutes', 'minutos')}`;

            document.getElementById('js-summary-subject').textContent = subjectName;
            document.getElementById('js-summary-tutor').textContent = tutorName;
            document.getElementById('js-summary-date').textContent = first.date;
            document.getElementById('js-summary-time').textContent =
                `${first.start} - ${last.end} (${durationTxt})`;
            document.getElementById('js-summary-total').textContent = `Bs. ${currentPrice.toFixed(2)}`;
        }

        function toggleReceiptUI() {

            if (receiptLabel) receiptLabel.style.display = isFreeBooking ? 'none' : 'block';


            if (payHint) payHint.style.display = isFreeBooking ? 'none' : 'block';

            if (freeMsg) freeMsg.style.display = isFreeBooking ? 'block' : 'none';


            if (summaryFreeNote) summaryFreeNote.style.display = isFreeBooking ? 'block' : 'none';
        }

        function showCouponBar(code) {
             if (couponBar) couponBar.style.display = 'flex';
             if (couponCodeEl) couponCodeEl.textContent = code || '-';
        }

        function hideCouponBar() {
            if (couponBar) couponBar.style.display = 'none';
            if (couponCodeEl) couponCodeEl.textContent = '-';
        }



        function recalcTotals() {

            currentPrice = (basePrice * selectedSlots.length) * (1 - appliedDiscountDecimal);


            isFreeBooking = currentPrice <= 0.00001;


            const totalEl = document.getElementById('js-summary-total');
            if (totalEl) totalEl.textContent = `Bs. ${currentPrice.toFixed(2)}`;


            const discountAmount = (basePrice * selectedSlots.length) - currentPrice;
            if (summaryDiscountRow && appliedDiscountPct > 0) {
                summaryDiscountRow.style.display = 'block';
                summaryDiscountPct.textContent = String(appliedDiscountPct);
                summaryDiscountAmount.textContent = `-${discountAmount.toFixed(2)}`;
            } else if (summaryDiscountRow) {
                summaryDiscountRow.style.display = 'none';
            }

            toggleReceiptUI();
        }

        function renderReqMiniCalendar(y, m) {
            reqCalendarYear = y;
            reqCalendarMonth = m;

            const first = new Date(y, m, 1);
            const startDay = first.getDay();
            const daysInMonth = new Date(y, m + 1, 0).getDate();

            const week = bookingArray('booking_week_days_short', ['D', 'L', 'M', 'M', 'J', 'V', 'S']);

            const calendarEl = document.getElementById('js-req-mini-calendar');
            if (!calendarEl) return;

            calendarEl.innerHTML = `
    <div class="mini-cal">
      <div class="mini-cal-header">
        <div class="mini-cal-title">${monthName(m)}</div>
        <div class="mini-cal-nav">
          <button class="mini-btn" type="button" id="req-cal-prev">‹</button>
          <button class="mini-btn" type="button" id="req-cal-next">›</button>
        </div>
      </div>

      <div class="mini-cal-week">
        ${week.map(w => `<div>${w}</div>`).join('')}
      </div>

      <div class="mini-cal-grid" id="req-cal-grid"></div>
    </div>
  `;

            const grid = calendarEl.querySelector('#req-cal-grid');

            const blanks = startDay;
            for (let i = 0; i < blanks; i++) {
                const b = document.createElement('button');
                b.type = 'button';
                b.className = 'day-btn muted';
                b.textContent = '';
                grid.appendChild(b);
            }

            const today = todayStr();

            for (let day = 1; day <= daysInMonth; day++) {
                const dd = String(day).padStart(2, '0');
                const mm = String(m + 1).padStart(2, '0');
                const dateStr = `${y}-${mm}-${dd}`;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'day-btn';
                if (dateStr === today) btn.classList.add('today');
                if (dateStr === reqSelectedDate) btn.classList.add('selected');

                const isPast = dateStr < today;
                if (isPast) {
                    btn.classList.add('muted');
                    btn.style.pointerEvents = 'none';
                    btn.style.opacity = '0.25';
                }

                btn.textContent = day;
                if (!isPast) {
                    btn.addEventListener('click', () => selectReqDate(dateStr));
                }

                grid.appendChild(btn);
            }

            calendarEl.querySelector('#req-cal-prev').addEventListener('click', () => {
                const prev = new Date(y, m - 1, 1);
                renderReqMiniCalendar(prev.getFullYear(), prev.getMonth());
            });

            calendarEl.querySelector('#req-cal-next').addEventListener('click', () => {
                const next = new Date(y, m + 1, 1);
                renderReqMiniCalendar(next.getFullYear(), next.getMonth());
            });
        }

        function selectReqDate(dateStr) {
            reqSelectedDate = dateStr;
            const label = document.getElementById('js-req-selected-date-label');
            if (label) {
                label.textContent = dateStr === todayStr()
                    ? bookingText('booking_today', 'Hoy')
                    : dateStr;
            }

            renderReqMiniCalendar(reqCalendarYear, reqCalendarMonth);
        }



        function updateProposalTime() {
            let startHour24 = clockHour;
            if (clockAmPm === 'PM' && clockHour !== 12) {
                startHour24 += 12;
            } else if (clockAmPm === 'AM' && clockHour === 12) {
                startHour24 = 0;
            }

            const startTimeStr = `${String(clockHour).padStart(2, '0')}:${String(clockMinute).padStart(2, '0')} ${clockAmPm}`;

            const totalMins = startHour24 * 60 + clockMinute + selectedDurationMins;
            const endHour24 = Math.floor(totalMins / 60) % 24;
            const endMinute = totalMins % 60;

            const endAmPm = endHour24 >= 12 ? 'PM' : 'AM';
            let endHour12 = endHour24 % 12;
            if (endHour12 === 0) endHour12 = 12;

            const endTimeStr = `${String(endHour12).padStart(2, '0')}:${String(endMinute).padStart(2, '0')} ${endAmPm}`;

            reqSelectedTimeRange = `${startTimeStr} - ${endTimeStr}`;

            const previewEl = document.getElementById('js-proposal-time-range');
            if (previewEl) {
                previewEl.textContent = reqSelectedTimeRange;
            }
        }

        async function submitTutorRequest() {
            const reqDate = reqSelectedDate;
            const reqTime = reqSelectedTimeRange;
            const reqNote = document.getElementById('js-req-note').value.trim();
            const reqMsg = document.getElementById('js-req-message');

            if (!reqDate || !reqTime) {
                reqMsg.className = 'form-msg error';
                reqMsg.textContent = bookingText(
                'booking_request_required_fields',
                'Por favor selecciona la fecha sugerida e introduce el horario sugerido.'
            );
                reqMsg.style.display = 'block';
                return;
            }

            nextBtn.disabled = true;
            backBtn.disabled = true;
            loader.style.display = 'flex';
            navigationButtons.style.display = 'none';
            document.getElementById('content-step-request_tutor').style.display = 'none';

            try {
                const payload = {
                    subject_id: selectedSubject,
                    preferred_date: reqDate,
                    preferred_time: reqTime,
                    note: reqNote
                };
                if (targetTutorId) {
                    payload.tutor_id = targetTutorId;
                }

                const response = await fetch('/student/booking/solicitar-tutor', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        // ESTA LÍNEA ES VITAL: Obliga a Laravel a devolver JSON incluso si hay errores
                        'Accept': 'application/json' 
                    },
                    body: JSON.stringify(payload)
                });

                // Si la respuesta HTTP indica un error (ej. 422 de validación o 500 del servidor)
                if (!response.ok) {
                    const errorData = await response.json(); // Ahora sí podremos leer el JSON
                    let errorText = errorData.message || bookingText(
                    'booking_request_server_error',
                    'Error del servidor al procesar la solicitud.'
                );
                    
                    // Si es un error de validación de Laravel (422)
                    if (response.status === 422 && errorData.errors) {
                        errorText = bookingText('booking_request_check_fields', 'Revisa los campos:') + '\n';
                        for (const field in errorData.errors) {
                            errorText += `- ${errorData.errors[field][0]}\n`;
                        }
                    }
                    // Forzamos el catch de abajo pasándole el mensaje
                    throw new Error(errorText); 
                }

                const data = await response.json();

                loader.style.display = 'none';

                if (data.success) {
                    const originalTitle = confirmation.querySelector('h3').textContent;
                    confirmation.querySelector('h3').textContent = bookingText(
                        'booking_request_success',
                        '¡Solicitud enviada con éxito!'
                    );
                    confirmation.style.display = 'flex';
                    navigationButtons.style.display = 'none';
                    setTimeout(() => {
                        closeModal();
                        setTimeout(() => {
                            confirmation.querySelector('h3').textContent = originalTitle;
                        }, 1000);
                    }, 2000);
                } else {
                    document.getElementById('content-step-request_tutor').style.display = 'block';
                    navigationButtons.style.display = 'flex';
                    nextBtn.disabled = false;
                    backBtn.disabled = false;
                    reqMsg.className = 'form-msg error';
                    reqMsg.textContent = data.message || bookingText(
                        'booking_request_send_error',
                        'Error al enviar la solicitud.'
                    );
                    reqMsg.style.display = 'block';
                }
            } catch (error) {
                console.error('Error al solicitar tutor:', error);
                document.getElementById('content-step-request_tutor').style.display = 'block';
                loader.style.display = 'none';
                navigationButtons.style.display = 'flex';
                nextBtn.disabled = false;
                backBtn.disabled = false;
                reqMsg.className = 'form-msg error';
                // Mostramos el error real en pantalla
                reqMsg.innerText = error.message || bookingText(
                    'booking_request_process_error',
                    'Ocurrió un error al procesar tu solicitud.'
                );
                reqMsg.style.display = 'block';
            }
        }

        async function submitBooking() {
            //  Si NO es gratis, exige comprobante
            if (!isFreeBooking && !comprobanteFile) {
                fileUpload.classList.add('input-error');
                showFormMsg(bookingText('booking_missing_receipt','🚫 Falta tu comprobante de pago. Súbelo para finalizar la reserva.'),'error');

                if (receiptLabel) {
                    receiptLabel.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
                return;
            }


            nextBtn.disabled = true;
            navigationButtons.style.display = 'none';
            hidePayUIOnSubmit();
            loader.style.display = 'flex';

            try {
                const slotsIds = selectedSlots.map(s => s.id);
                const first = selectedSlots[0];

                const formData = new FormData();
                formData.append('subject_id', selectedSubject);
                formData.append('tutor_id', selectedTutor);

                slotsIds.forEach(id => formData.append('slots[]', id));

                formData.append('slot_date', first.date);

                if (selectedCoupon) formData.append('coupon_id', selectedCoupon);
                formData.append('is_free', isFreeBooking ? '1' : '0');

                // Solo adjuntar comprobante si NO es gratis
                if (!isFreeBooking && comprobanteFile) {
                    formData.append('comprobante', comprobanteFile);
                }

                if (tutorRequestToken) {
                    formData.append('tutor_request_token', tutorRequestToken);
                }

                const response = await fetch('/student/booking/reservar-multi', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                const raw = await response.text();
                let data;
                try {
                    data = JSON.parse(raw);
                } catch {
                    console.error('❌ Respuesta NO JSON del servidor:', raw);
                    throw new Error(bookingText('booking_server_not_json', 'El servidor devolvió HTML/no JSON. Revisa logs de Laravel.'));
                }

                if (data.success) {
                    loader.style.display = 'none';
                    confirmation.style.display = 'flex';
                    // setTimeout(() => window.location.href = '{{ route('student.bookings') }}', 2500);
                    setTimeout(() => closeModal(), 800);
                    nextBtn.disabled = false;
                    return;
                }


                loader.style.display = 'none';
                navigationButtons.style.display = 'flex';
                showPayUIAfterError();
                alert(data.message || bookingText('booking_process_error', 'Error al procesar la reserva'));

            } catch (error) {
                console.error('Error al procesar la reserva:', error);
                loader.style.display = 'none';
                navigationButtons.style.display = 'flex';
                showPayUIAfterError();
                alert(error.message || bookingText('booking_process_error', 'Error al procesar la reserva'));
            }
        }

        async function releaseHolds() {
            if (selectedSlots.length === 0) return;
            const tutorId = selectedTutor;
            const dateStr = selectedSlots[0].date;

            try {
                const slotsIds = selectedSlots.map(s => s.id);
                const formData = new FormData();
                formData.append('tutor_id', tutorId);
                formData.append('date', dateStr);
                slotsIds.forEach(id => formData.append('slots[]', id));

                await fetch('/student/booking/release-slots', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData,
                    keepalive: true
                });
            } catch (e) {
                console.error("Error releasing holds", e);
            }
        }

        async function holdSlots() {
            if (selectedSlots.length === 0) return false;

            loader.style.display = 'flex';
            const tutorId = selectedTutor;
            const dateStr = selectedSlots[0].date;
            const slotsIds = selectedSlots.map(s => s.id);

            const formData = new FormData();
            formData.append('tutor_id', tutorId);
            formData.append('date', dateStr);
            slotsIds.forEach(id => formData.append('slots[]', id));

            try {
                const response = await fetch('/student/booking/hold-slots', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });
                const data = await response.json();

                loader.style.display = 'none';
                if (!data.success) {
                    alert(data.message || bookingText('booking_slot_unavailable', 'Alguno de los horarios seleccionados ya no está disponible.'));
                    selectedSlots = [];
                    return false;
                }
                return true;
            } catch (e) {
                loader.style.display = 'none';
                console.error("Error holding slots", e);
                alert(bookingText('booking_hold_connection_error', 'Error de conexión al intentar bloquear los horarios.'));
                return false;
            }
        }
                if (window._bookingWizardLanguageChangedListener) {
                    document.removeEventListener('languageChanged', window._bookingWizardLanguageChangedListener);
                }
                window._bookingWizardLanguageChangedListener = () => {
                    translateBookingModal();

                    if (calendarYear !== null && calendarMonth !== null && miniCalendarEl) {
                        renderMiniCalendar(calendarYear, calendarMonth);
                    }

                    if (selectedDateLabel && selectedDate) {
                        selectedDateLabel.textContent = selectedDate === todayStr()
                            ? bookingText('booking_today', 'Hoy')
                            : selectedDate;
                    }
                };
                document.addEventListener('languageChanged', window._bookingWizardLanguageChangedListener);

               if (typeof selectLanguage === 'function') {
                const savedLang = localStorage.getItem('selectedLanguage') || 'es';
                selectLanguage(savedLang, false);
            }

        async function checkUrlForCounterOffer() {
            const urlParams = new URLSearchParams(window.location.search);
            const acceptCounterToken = urlParams.get('accept_counter');
            if (!acceptCounterToken) return;

            // Mostrar cargando
            loader.style.display = 'flex';
            openModal();

            try {
                const response = await fetch(`/student/booking/get-counter/${acceptCounterToken}`);
                const data = await response.json();
                
                if (!data.success) {
                    alert(data.message || bookingText(
                    'booking_counter_not_found',
                    'La contrapropuesta ya no está activa o no fue encontrada.'
                ));
                    closeModal();
                    loader.style.display = 'none';
                    return;
                }

                // Cargar datos
                tutorRequestToken = acceptCounterToken;
                selectedSubject = data.subject_id;
                selectedSubjectName = data.subject_name;
                selectedTutor = data.tutor_id;
                selectedTutorName = data.tutor_name;
                selectedTutorPrice = data.price;
                selectedDate = data.counter_date;

                // Crear los slots de 20 minutos correspondientes basándonos en la duración
                // data.counter_time ej: "10:30 AM" o "02:30 PM"
                
                let timeStr = data.counter_time.trim();
                if (timeStr.includes(' - ')) {
                    timeStr = timeStr.split(' - ')[0].trim();
                }
                const match = timeStr.match(/^(\d+):(\d+)(?:\s*(AM|PM))?$/i);
                if (match) {
                    let hours = parseInt(match[1]);
                    const minutes = parseInt(match[2]);
                    const ampm = match[3] ? match[3].toUpperCase() : null;
                    if (ampm) {
                        if (ampm === 'PM' && hours !== 12) hours += 12;
                        if (ampm === 'AM' && hours === 12) hours = 0;
                    }

                    let startMins = hours * 60 + minutes;

                    // Mapeo de duración a minutos totales
                    let totalDurationMins = 20;
                    const dur = data.counter_duration.toLowerCase();
                    if (dur.includes('20')) totalDurationMins = 20;
                    else if (dur.includes('40')) totalDurationMins = 40;
                    else if (dur.includes('1 hora') || dur === '1h') totalDurationMins = 60;
                    else if (dur.includes('1h 20') || dur.includes('1h 20m')) totalDurationMins = 80;
                    else if (dur.includes('1h 40') || dur.includes('1h 40m')) totalDurationMins = 100;
                    else if (dur.includes('2 hora') || dur === '2h') totalDurationMins = 120;

                    const blocksCount = totalDurationMins / 20;
                    selectedSlots = [];

                    for (let i = 0; i < blocksCount; i++) {
                        const blockStart = startMins + i * 20;
                        const blockEnd = startMins + (i + 1) * 20;

                        const sh = Math.floor(blockStart / 60);
                        const sm = blockStart % 60;
                        const startFormatted = String(sh).padStart(2, '0') + ':' + String(sm).padStart(2, '0');

                        const eh = Math.floor(blockEnd / 60);
                        const em = blockEnd % 60;
                        const endFormatted = String(eh).padStart(2, '0') + ':' + String(em).padStart(2, '0');

                        // Mismo formato: "slot_id|start_time|end_time"
                        const slotId = `0|${startFormatted}|${endFormatted}`;
                        const displayTime = `${startFormatted} - ${endFormatted}`;

                        selectedSlots.push({
                            id: slotId,
                            date: data.counter_date,
                            time: displayTime,
                            start: startFormatted,
                            end: endFormatted
                        });
                    }
                } else {
                    console.error('No se pudo parsear el formato de hora de la contrapropuesta:', data.counter_time);
                }

                // Cargar UI
                const pMateria = document.getElementById('js-summary-materia');
                if (pMateria) pMateria.textContent = selectedSubjectName;
                const pTutor = document.getElementById('js-summary-tutor');
                if (pTutor) pTutor.textContent = selectedTutorName;

                // Renderizar resumen del paso 3
                updateSummary();

                // Cambiar a Paso 3
                currentStep = 3;
                updateStepUI();
                updateContent();
                updateNavButtons();
                scrollTopStep();

                // Calcular totales
                recalcTotals();

            } catch (error) {
                console.error('Error pre-cargando contrapropuesta:', error);
                alert(bookingText(
                    'booking_counter_load_error',
                    'Ocurrió un error al cargar la contrapropuesta.'
                ));
                closeModal();
            } finally {
                loader.style.display = 'none';
            }
        }

        // Ejecutar chequeo de URL
        checkUrlForCounterOffer();

    })();
</script>

</div>