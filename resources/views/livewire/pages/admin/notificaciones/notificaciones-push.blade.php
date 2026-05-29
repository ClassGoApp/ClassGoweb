<div class="tb-db-dashboard_box_wrap">
    <div class="tb-db-dashboard_box_wrap_inner" style="padding: 20px;">
        <div class="tb-menumanagement_wrap">
            <div class="tb-dbholder">
                <div class="tb-dbholder__title" style="margin-bottom: 25px; border-bottom: 1px solid #eef2f5; padding-bottom: 15px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="background: linear-gradient(135deg, #023047 0%, #219ebc 100%); color: white; padding: 12px; border-radius: 12px; box-shadow: 0 4px 15px rgba(33, 158, 188, 0.25);">
                            <i class="icon-bell" style="font-size: 1.5rem; display: block;"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-weight: 800; color: #023047;">Centro de Notificaciones Push</h3>
                            <p style="margin: 3px 0 0 0; color: #6c757d; font-size: 0.85rem;">Prueba y envía alertas móviles en tiempo real a tus usuarios usando Firebase Cloud Messaging</p>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                @if (session()->has('success'))
                    <div class="alert alert-success d-flex align-items-center" role="alert" style="border-radius: 12px; padding: 15px 20px; border: none; background-color: #e8f5e9; color: #2e7d32; box-shadow: 0 4px 12px rgba(46, 125, 50, 0.08); margin-bottom: 25px;">
                        <i class="fas fa-check-circle" style="font-size: 1.25rem; margin-right: 12px;"></i>
                        <div>
                            <strong>¡Éxito!</strong> {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if ($errorMessage)
                    <div class="alert alert-danger d-flex align-items-center" role="alert" style="border-radius: 12px; padding: 15px 20px; border: none; background-color: #ffebee; color: #c62828; box-shadow: 0 4px 12px rgba(198, 40, 40, 0.08); margin-bottom: 25px;">
                        <i class="fas fa-exclamation-circle" style="font-size: 1.25rem; margin-right: 12px;"></i>
                        <div>
                            <strong>Error de Envío:</strong> {{ $errorMessage }}
                        </div>
                    </div>
                @endif

                <!-- User Statistics -->
                <div class="row g-4" style="margin-bottom: 30px; display: flex; gap: 15px; flex-wrap: wrap;">
                    <div class="col" style="flex: 1; min-width: 200px;">
                        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #eef2f5; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 15px;">
                            <div style="background: rgba(33, 158, 188, 0.1); color: #219ebc; padding: 10px; border-radius: 10px;">
                                <i class="icon-users" style="font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #023047;">{{ $totalUsersWithToken }}</h4>
                                <span style="font-size: 0.8rem; color: #8d99ae; font-weight: 600;">Usuarios con Token FCM</span>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="flex: 1; min-width: 200px;">
                        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #eef2f5; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 15px;">
                            <div style="background: rgba(2, 48, 71, 0.1); color: #023047; padding: 10px; border-radius: 10px;">
                                <i class="icon-user" style="font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #023047;">{{ $tutorsWithToken }}</h4>
                                <span style="font-size: 0.8rem; color: #8d99ae; font-weight: 600;">Tutores con Token FCM</span>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="flex: 1; min-width: 200px;">
                        <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #eef2f5; box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; align-items: center; gap: 15px;">
                            <div style="background: rgba(251, 133, 0, 0.1); color: #fb8500; padding: 10px; border-radius: 10px;">
                                <i class="icon-user-check" style="font-size: 1.25rem;"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #023047;">{{ $studentsWithToken }}</h4>
                                <span style="font-size: 0.8rem; color: #8d99ae; font-weight: 600;">Estudiantes con Token FCM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 25px; align-items: start;">
                    
                    <!-- Left Column: Notification Form -->
                    <div style="background: #ffffff; border-radius: 20px; border: 1px solid #eef2f5; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.01);">
                        <h4 style="margin-top: 0; margin-bottom: 20px; font-weight: 700; color: #023047; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                            <i class="icon-edit" style="color: #219ebc;"></i> Redactar Notificación
                        </h4>

                        <div class="row" style="margin-bottom: 18px;">
                            <div class="col-12" style="margin-bottom: 15px;">
                                <label style="font-weight: 700; color: #023047; font-size: 0.85rem; margin-bottom: 6px; display: block;">Título de la Notificación <span class="text-danger">*</span></label>
                                <input type="text" wire:model.blur="title" class="form-control" placeholder="Ej. ¡Nueva lección programada!" style="border-radius: 10px; padding: 12px; font-size: 0.9rem;">
                                @error('title') <span class="text-danger" style="font-size: 0.8rem; font-weight: 600; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12" style="margin-bottom: 15px;">
                                <label style="font-weight: 700; color: #023047; font-size: 0.85rem; margin-bottom: 6px; display: block;">Cuerpo / Mensaje <span class="text-danger">*</span></label>
                                <textarea wire:model.blur="body" class="form-control" rows="3" placeholder="Ej. Tu clase de hoy empezará en 15 minutos. No faltes." style="border-radius: 10px; padding: 12px; font-size: 0.9rem; resize: none;"></textarea>
                                @error('body') <span class="text-danger" style="font-size: 0.8rem; font-weight: 600; display: block; margin-top: 4px;">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Massive Target Options with beautiful Square Selection Badges -->
                        <div style="border-top: 1px solid #eef2f5; padding-top: 25px; margin-top: 15px;">
                            <label style="font-weight: 700; color: #023047; font-size: 0.85rem; margin-bottom: 12px; display: block;">Grupo de Destinatarios Masivo</label>
                            
                            <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                                <!-- Todos los Usuarios -->
                                <label style="flex: 1; text-align: center; border-radius: 16px; padding: 20px; border: 2px solid {{ $targetType === 'all' ? '#023047' : '#eef2f5' }}; background: {{ $targetType === 'all' ? 'linear-gradient(135deg, #023047 0%, #1a4f6e 100%)' : '#ffffff' }}; color: {{ $targetType === 'all' ? '#ffffff' : '#495057' }}; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <input type="radio" wire:model.live="targetType" value="all" style="display: none;">
                                    <i class="icon-users" style="font-size: 1.75rem; display: block; margin-bottom: 8px; color: {{ $targetType === 'all' ? '#219ebc' : '#8d99ae' }};"></i>
                                    <span style="font-weight: 700; font-size: 0.85rem; display: block;">Todos los Usuarios</span>
                                </label>

                                <!-- Solo Tutores -->
                                <label style="flex: 1; text-align: center; border-radius: 16px; padding: 20px; border: 2px solid {{ $targetType === 'tutor' ? '#023047' : '#eef2f5' }}; background: {{ $targetType === 'tutor' ? 'linear-gradient(135deg, #023047 0%, #1a4f6e 100%)' : '#ffffff' }}; color: {{ $targetType === 'tutor' ? '#ffffff' : '#495057' }}; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <input type="radio" wire:model.live="targetType" value="tutor" style="display: none;">
                                    <i class="icon-user" style="font-size: 1.75rem; display: block; margin-bottom: 8px; color: {{ $targetType === 'tutor' ? '#219ebc' : '#8d99ae' }};"></i>
                                    <span style="font-weight: 700; font-size: 0.85rem; display: block;">Solo Tutores</span>
                                </label>

                                <!-- Solo Estudiantes -->
                                <label style="flex: 1; text-align: center; border-radius: 16px; padding: 20px; border: 2px solid {{ $targetType === 'estudiante' ? '#023047' : '#eef2f5' }}; background: {{ $targetType === 'estudiante' ? 'linear-gradient(135deg, #023047 0%, #1a4f6e 100%)' : '#ffffff' }}; color: {{ $targetType === 'estudiante' ? '#ffffff' : '#495057' }}; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0,0,0,0.02); display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <input type="radio" wire:model.live="targetType" value="estudiante" style="display: none;">
                                    <i class="icon-user-check" style="font-size: 1.75rem; display: block; margin-bottom: 8px; color: {{ $targetType === 'estudiante' ? '#219ebc' : '#8d99ae' }};"></i>
                                    <span style="font-weight: 700; font-size: 0.85rem; display: block;">Solo Estudiantes</span>
                                </label>
                            </div>

                            <p style="margin: -10px 0 20px 0; color: #6c757d; font-size: 0.8rem; line-height: 1.4;">
                                Se enviará de forma masiva a través del endpoint <code>api/notify-massive</code> a todos los usuarios del rol seleccionado que posean un token FCM registrado en la base de datos.
                            </p>

                            <button type="button" wire:click="sendMassive" wire:loading.attr="disabled" class="btn" style="background: linear-gradient(135deg, #023047 0%, #219ebc 100%); color: white; border: none; padding: 15px; border-radius: 12px; width: 100%; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; box-shadow: 0 6px 15px rgba(2, 48, 71, 0.3); cursor: pointer; transition: all 0.3s ease;">
                                <span wire:loading.remove wire:target="sendMassive">
                                    <i class="icon-navigation" style="margin-right: 5px;"></i> ENVIAR NOTIFICACIÓN MASIVA
                                </span>
                                <span wire:loading wire:target="sendMassive">
                                    <i class="fas fa-spinner fa-spin"></i> PROCESANDO ENVÍO...
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Right Column: API Response & Logs -->
                    <div style="background: #ffffff; border-radius: 20px; border: 1px solid #eef2f5; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.01); height: 100%; display: flex; flex-direction: column;">
                        <h4 style="margin-top: 0; margin-bottom: 20px; font-weight: 700; color: #023047; font-size: 1.1rem; display: flex; align-items: center; gap: 8px;">
                            <i class="icon-terminal" style="color: #fb8500;"></i> Respuesta de Firebase / Logs
                        </h4>

                        @if ($apiResponse)
                            <div style="background: #e8f5e9; border-radius: 12px; padding: 15px; margin-bottom: 20px; border: 1px solid #c8e6c9;">
                                <h5 style="margin: 0 0 5px 0; color: #2e7d32; font-weight: 700; font-size: 0.9rem;">Resultado del Proceso:</h5>
                                <ul style="margin: 0; padding-left: 20px; color: #388e3c; font-size: 0.85rem; font-weight: 600;">
                                    <li>Enviados con éxito: {{ $apiResponse['success_count'] ?? 1 }}</li>
                                    <li>Errores: {{ $apiResponse['failure_count'] ?? 0 }}</li>
                                </ul>
                            </div>

                            <div style="flex-grow: 1;">
                                <label style="font-weight: 700; color: #023047; font-size: 0.8rem; margin-bottom: 6px; display: block;">Respuesta Completa de Firebase:</label>
                                <pre style="background: #2b2d42; color: #a5f3fc; border-radius: 12px; padding: 15px; font-size: 0.8rem; overflow-x: auto; max-height: 400px; font-family: monospace;">{{ json_encode($apiResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        @else
                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 50px 20px; text-align: center; background: #f8f9fa; border-radius: 16px; border: 1px dashed #ced4da; height: 350px;">
                                <i class="icon-database" style="font-size: 3rem; color: #ced4da; margin-bottom: 15px;"></i>
                                <h5 style="margin: 0; font-weight: 700; color: #6c757d; font-size: 0.95rem;">Esperando envíos...</h5>
                                <p style="margin: 5px 0 0 0; color: #a8dadc; font-size: 0.8rem; max-width: 250px;">Completa el formulario de la izquierda y haz tu prueba de notificaciones móviles.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
