<div class="tb-db-dashboard_box_wrap">
    <style>
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
    <div class="tb-db-dashboard_box_wrap_inner">
        <div class="tb-menumanagement_wrap">
            <div class="tb-dbholder">
                <div class="tb-dbholder__title" style="margin-bottom: 25px; border-bottom: 1px solid #eef2f5; padding-bottom: 15px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="background: linear-gradient(135deg, #ff6b35 0%, #ffa500 100%); color: white; padding: 12px; border-radius: 12px; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.25);">
                            <i class="icon-mail" style="font-size: 1.5rem; display: block;"></i>
                        </div>
                        <div>
                            <h3 style="margin: 0; font-weight: 800; color: #023047;">Centro de Notificaciones por Email</h3>
                            <p style="margin: 3px 0 0 0; color: #6c757d; font-size: 0.85rem;">Envía comunicaciones por correo electrónico</p>
                        </div>
                    </div>
                </div>

                <!-- Alertas -->
                @if (session()->has('success'))
                    <div class="alert alert-success" style="border-radius: 12px; padding: 15px 20px; border: none; background-color: #e8f5e9; color: #2e7d32; margin-bottom: 25px;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                @if ($errorMessage)
                    <div class="alert alert-danger" style="border-radius: 12px; padding: 15px 20px; border: none; background-color: #ffebee; color: #c62828; margin-bottom: 25px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $errorMessage }}
                    </div>
                @endif
                @if ($successMessage)
                    <div class="alert alert-success" style="border-radius: 12px; padding: 15px 20px; border: none; background-color: #e8f5e9; color: #2e7d32; margin-bottom: 25px;">
                        <i class="fas fa-check-circle"></i> {{ $successMessage }}
                    </div>
                @endif

                <!-- Estadísticas -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px; margin-bottom: 30px;">
                    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid #eef2f5; text-align: center;">
                        <h4 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #023047;">{{ $totalUsers }}</h4>
                        <span style="font-size: 0.8rem; color: #8d99ae;">Total con Email</span>
                    </div>
                    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid #eef2f5; text-align: center;">
                        <h4 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #023047;">{{ $tutorsWithEmail }}</h4>
                        <span style="font-size: 0.8rem; color: #8d99ae;">Tutores</span>
                    </div>
                    <div style="background: white; border-radius: 12px; padding: 20px; border: 1px solid #eef2f5; text-align: center;">
                        <h4 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #023047;">{{ $studentsWithEmail }}</h4>
                        <span style="font-size: 0.8rem; color: #8d99ae;">Estudiantes</span>
                    </div>
                </div>

                <!-- TABS -->
                <div style="background: white; border-radius: 12px; border: 1px solid #eef2f5; overflow: hidden;">
                    <div style="display: flex; border-bottom: 2px solid #eef2f5; background: #f9f9f9;">
                        <button wire:click="$set('activeTab', 'massive')" style="flex: 1; padding: 15px; border: none; background: none; cursor: pointer; font-weight: 700; color: {{ $activeTab === 'massive' ? '#ff6b35' : '#8d99ae' }}; border-bottom: {{ $activeTab === 'massive' ? '3px solid #ff6b35' : 'none' }}; transition: all 0.3s;">
                            <i class="icon-send"></i> 📤 Envío Masivo
                        </button>
                        <button wire:click="$set('activeTab', 'specific')" style="flex: 1; padding: 15px; border: none; background: none; cursor: pointer; font-weight: 700; color: {{ $activeTab === 'specific' ? '#ff6b35' : '#8d99ae' }}; border-bottom: {{ $activeTab === 'specific' ? '3px solid #ff6b35' : 'none' }}; transition: all 0.3s;">
                            <i class="icon-mail"></i> ✉️ Emails Específicos
                        </button>
                    </div>

                    <div style="padding: 30px; animation: fadeIn 0.3s;">
                        <!-- TAB 1: MASIVO -->
                        @if($activeTab === 'massive')
                        <div>
                            <h4 style="margin-top: 0; margin-bottom: 20px; font-weight: 700; color: #023047;">Enviar Email Masivo</h4>

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 700; color: #023047; display: block; margin-bottom: 6px;">Asunto <span style="color: red;">*</span></label>
                                <input type="text" wire:model="subject" class="form-control" placeholder="Ej. ¡Bienvenido a ClassGo!" style="border-radius: 10px; padding: 12px;">
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 700; color: #023047; display: block; margin-bottom: 6px;">Contenido <span style="color: red;">*</span></label>
                                <textarea wire:model="emailBody" class="form-control" rows="4" placeholder="Mensaje..." style="border-radius: 10px; padding: 12px;"></textarea>
                                
                                <!-- Botones adjuntos -->
                                <div style="display: flex; gap: 10px; margin-top: 10px;">
                                    <input type="file" wire:model="attachments" style="display: none;" id="fileInput" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar" multiple>
                                    <button type="button" onclick="document.getElementById('fileInput').click()" style="background: #f0f0f0; border: 1px solid #ddd; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: 600; color: #666;">
                                        📎 Adjuntar
                                    </button>
                                    
                                    <input type="file" wire:model="images" style="display: none;" id="imageInput" accept=".jpg,.jpeg,.png,.gif,.webp" multiple>
                                    <button type="button" onclick="document.getElementById('imageInput').click()" style="background: #f0f0f0; border: 1px solid #ddd; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: 600; color: #666;">
                                        🖼️ Imagen
                                    </button>
                                </div>

                                <!-- Adjuntos listados - SAFE VERSION -->
                                <div style="background: #f9f9f9; border: 1px solid #e8e8e8; border-radius: 6px; padding: 10px; margin-top: 10px;">
                                    @forelse($attachments as $idx => $att)
                                        @if(is_array($att))
                                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px; background: white; border: 1px solid #e8e8e8; border-radius: 3px; margin-bottom: 5px;">
                                            <span>📄 {{ $att['name'] ?? 'archivo' }} ({{ $att['size'] ?? 0 }} KB)</span>
                                            <button wire:click="removeAttachment({{ $idx }})" type="button" style="background: none; border: none; color: #999; cursor: pointer; font-size: 18px;">✕</button>
                                        </div>
                                        @endif
                                    @empty
                                    @endforelse
                                    
                                    @forelse($images as $idx => $img)
                                        @if(is_array($img))
                                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px; background: white; border: 1px solid #e8e8e8; border-radius: 3px; margin-bottom: 5px;">
                                            <span>🖼️ {{ $img['name'] ?? 'imagen' }} ({{ $img['size'] ?? 0 }} KB)</span>
                                            <button wire:click="removeImage({{ $idx }})" type="button" style="background: none; border: none; color: #999; cursor: pointer; font-size: 18px;">✕</button>
                                        </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 700; color: #023047; display: block; margin-bottom: 10px;">Destinatarios</label>
                                <div style="display: flex; gap: 12px;">
                                    <label style="flex: 1; text-align: center; padding: 12px; border: 2px solid {{ $targetType === 'all' ? '#ff6b35' : '#eef2f5' }}; background: {{ $targetType === 'all' ? 'linear-gradient(135deg, #ff6b35, #ffa500)' : 'white' }}; color: {{ $targetType === 'all' ? 'white' : '#333' }}; border-radius: 8px; cursor: pointer;">
                                        <input type="radio" wire:model.live="targetType" value="all" style="display: none;">
                                        <span style="font-weight: 700;">👥 Todos</span>
                                    </label>
                                    <label style="flex: 1; text-align: center; padding: 12px; border: 2px solid {{ $targetType === 'tutor' ? '#ff6b35' : '#eef2f5' }}; background: {{ $targetType === 'tutor' ? 'linear-gradient(135deg, #ff6b35, #ffa500)' : 'white' }}; color: {{ $targetType === 'tutor' ? 'white' : '#333' }}; border-radius: 8px; cursor: pointer;">
                                        <input type="radio" wire:model.live="targetType" value="tutor" style="display: none;">
                                        <span style="font-weight: 700;">👨‍🏫 Tutores</span>
                                    </label>
                                    <label style="flex: 1; text-align: center; padding: 12px; border: 2px solid {{ $targetType === 'student' ? '#ff6b35' : '#eef2f5' }}; background: {{ $targetType === 'student' ? 'linear-gradient(135deg, #ff6b35, #ffa500)' : 'white' }}; color: {{ $targetType === 'student' ? 'white' : '#333' }}; border-radius: 8px; cursor: pointer;">
                                        <input type="radio" wire:model.live="targetType" value="student" style="display: none;">
                                        <span style="font-weight: 700;">👨‍🎓 Estudiantes</span>
                                    </label>
                                </div>
                            </div>

                            <button wire:click="sendMassiveEmail" wire:loading.attr="disabled" style="background: linear-gradient(135deg, #ff6b35, #ffa500); color: white; border: none; padding: 12px 25px; border-radius: 8px; width: 100%; font-weight: 800; cursor: pointer;">
                                <span wire:loading.remove>📤 Enviar Email Masivo</span>
                                <span wire:loading><i class="fas fa-spinner fa-spin"></i> Procesando...</span>
                            </button>
                        </div>
                        @endif

                        <!-- TAB 2: ESPECÍFICO -->
                        @if($activeTab === 'specific')
                        <div>
                            <h4 style="margin-top: 0; margin-bottom: 20px; font-weight: 700; color: #023047;">Enviar a Emails Específicos</h4>

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 700; color: #023047; display: block; margin-bottom: 6px;">Asunto <span style="color: red;">*</span></label>
                                <input type="text" wire:model="subject" class="form-control" placeholder="Ej. ¡Bienvenido a ClassGo!" style="border-radius: 10px; padding: 12px;">
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 700; color: #023047; display: block; margin-bottom: 6px;">Contenido <span style="color: red;">*</span></label>
                                <textarea wire:model="emailBody" class="form-control" rows="4" placeholder="Mensaje..." style="border-radius: 10px; padding: 12px;"></textarea>
                                
                                <!-- Botones adjuntos -->
                                <div style="display: flex; gap: 10px; margin-top: 10px;">
                                    <input type="file" wire:model="attachments" style="display: none;" id="fileInput2" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.zip,.rar">
                                    <button type="button" onclick="document.getElementById('fileInput2').click()" style="background: #f0f0f0; border: 1px solid #ddd; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: 600; color: #666;">
                                        📎 Adjuntar
                                    </button>
                                    
                                    <input type="file" wire:model="images" style="display: none;" id="imageInput2" accept=".jpg,.jpeg,.png,.gif,.webp">
                                    <button type="button" onclick="document.getElementById('imageInput2').click()" style="background: #f0f0f0; border: 1px solid #ddd; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-weight: 600; color: #666;">
                                        🖼️ Imagen
                                    </button>
                                </div>

                                <!-- Adjuntos listados - SAFE VERSION -->
                                <div style="background: #f9f9f9; border: 1px solid #e8e8e8; border-radius: 6px; padding: 10px; margin-top: 10px;">
                                    @forelse($attachments as $idx => $att)
                                        @if(is_array($att))
                                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px; background: white; border: 1px solid #e8e8e8; border-radius: 3px; margin-bottom: 5px;">
                                            <span>📄 {{ $att['name'] ?? 'archivo' }} ({{ $att['size'] ?? 0 }} KB)</span>
                                            <button wire:click="removeAttachment({{ $idx }})" type="button" style="background: none; border: none; color: #999; cursor: pointer; font-size: 18px;">✕</button>
                                        </div>
                                        @endif
                                    @empty
                                    @endforelse
                                    
                                    @forelse($images as $idx => $img)
                                        @if(is_array($img))
                                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px; background: white; border: 1px solid #e8e8e8; border-radius: 3px; margin-bottom: 5px;">
                                            <span>🖼️ {{ $img['name'] ?? 'imagen' }} ({{ $img['size'] ?? 0 }} KB)</span>
                                            <button wire:click="removeImage({{ $idx }})" type="button" style="background: none; border: none; color: #999; cursor: pointer; font-size: 18px;">✕</button>
                                        </div>
                                        @endif
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="font-weight: 700; color: #023047; display: block; margin-bottom: 6px;">Seleccionar Usuarios <span style="color: red;">*</span></label>
                                
                                <!-- Buscador -->
                                <div style="position: relative; margin-bottom: 10px;">
                                    <input type="text" wire:model.live="searchQuery" class="form-control" placeholder="🔍 Buscar por nombre o email..." style="border-radius: 10px; padding: 12px;">
                                    
                                    <!-- Resultados de búsqueda -->
                                    @if($showSearchResults && count($searchResults) > 0)
                                    <div style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 8px; max-height: 250px; overflow-y: auto; z-index: 100; margin-top: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                                        @foreach($searchResults as $user)
                                        <button type="button" wire:click="selectUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}')" style="width: 100%; text-align: left; padding: 12px 15px; border: none; background: none; cursor: pointer; border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">
                                            <div style="font-weight: 600; color: #023047;">{{ $user->name }}</div>
                                            <div style="font-size: 0.85rem; color: #666;">{{ $user->email }}</div>
                                        </button>
                                        @endforeach
                                    </div>
                                    @elseif($searchQuery && $showSearchResults)
                                    <div style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-radius: 8px; padding: 15px; z-index: 100; margin-top: 5px;">
                                        <p style="margin: 0; color: #999; text-align: center;">No se encontraron usuarios</p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Usuarios seleccionados -->
                                @if(count($selectedUsers) > 0)
                                <div style="background: #f9f9f9; border: 1px solid #e8e8e8; border-radius: 8px; padding: 15px; margin-bottom: 10px;">
                                    <div style="font-weight: 700; color: #023047; margin-bottom: 10px;">
                                        ✅ {{ count($selectedUsers) }} usuario{{ count($selectedUsers) > 1 ? 's' : '' }} seleccionado{{ count($selectedUsers) > 1 ? 's' : '' }}
                                    </div>
                                    <div style="display: grid; gap: 8px;">
                                        @foreach($selectedUsers as $user)
                                        <div style="display: flex; justify-content: space-between; align-items: center; background: white; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 6px;">
                                            <div>
                                                <div style="font-weight: 600; color: #023047;">{{ $user['name'] }}</div>
                                                <div style="font-size: 0.85rem; color: #666;">{{ $user['email'] }}</div>
                                            </div>
                                            <button wire:click="removeSelectedUser({{ $user['id'] }})" type="button" style="background: none; border: none; color: #ff6b35; cursor: pointer; font-size: 20px; padding: 0; display: flex; align-items: center;">
                                                ✕
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <div style="background: #f0f7ff; border: 1px dashed #219ebc; border-radius: 8px; padding: 15px; text-align: center; color: #666;">
                                    <p style="margin: 0;">🔍 Busca y selecciona usuarios para enviar el email</p>
                                </div>
                                @endif
                            </div>

                            <button wire:click="sendSpecificEmail" wire:loading.attr="disabled" style="background: linear-gradient(135deg, #ff6b35, #ffa500); color: white; border: none; padding: 12px 25px; border-radius: 8px; width: 100%; font-weight: 800; cursor: pointer;">
                                <span wire:loading.remove>✉️ Enviar a Emails Específicos</span>
                                <span wire:loading><i class="fas fa-spinner fa-spin"></i> Procesando...</span>
                            </button>

                            @if ($apiResponse)
                            <div style="background: #e8f5e9; border: 1px solid #c8e6c9; border-radius: 8px; padding: 15px; margin-top: 15px;">
                                <h5 style="margin: 0 0 10px 0; color: #2e7d32;">Resultado:</h5>
                                <ul style="margin: 0; padding-left: 20px; color: #388e3c;">
                                    <li>✅ Enviados: {{ $apiResponse['success_count'] ?? 0 }}</li>
                                    <li>❌ Errores: {{ $apiResponse['failure_count'] ?? 0 }}</li>
                                </ul>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
