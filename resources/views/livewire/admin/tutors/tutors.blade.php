<main class="tb-main am-dispute-system am-user-system">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="tb-dhb-mainheading">
                <h4>{{ __('general.all_tutors') . ' (' . $tutors->total() . ')' }}</h4>

                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:void(0)" id="add_tutor_click" class="tb-btn add-new"
                                       data-bs-toggle="modal" data-bs-target="#tb-add-tutor">
                                        {{ __('general.add_new_tutor') }} <i class="icon-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            
            <!-- Filtros debajo del botón -->
            <div class="tb-sortby" style="margin-top: 20px;">
                <form class="tb-themeform tb-displistform">
                    <fieldset>
                        <div class="tb-themeform__wrap">
                            <div class="tb-actionselect" wire:ignore>
                                <label class="tb-label">{{ __('general.email_verification') }}</label>
                                <div class="tb-select">
                                    <select data-componentid="@this" class="filter-select2 form-control"
                                            data-searchable="false" data-hide_search_opt="true" data-live='true' id="verification"
                                            data-wiremodel="verification">
                                        <option value="">{{ __('All') }}</option>
                                        <option value="verified" {{ $verification=='verified' ? 'selected' : '' }}>{{ __('Verified') }}</option>
                                        <option value="unverified" {{ $verification=='unverified' ? 'selected' : '' }}>{{ __('Unverified') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tb-actionselect" wire:ignore>
                                <label class="tb-label">{{ __('general.status') }}</label>
                                <div class="tb-select">
                                    <select data-componentid="@this" class="filter-select2 form-control"
                                            data-searchable="false" data-hide_search_opt="true" data-live='true' id="filter_user"
                                            data-wiremodel="filterUser">
                                        <option value="">{{ __('All') }}</option>
                                        <option value="active" {{ $filterUser=='active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                        <option value="inactive" {{ $filterUser=='inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tb-actionselect" wire:ignore>
                                <label class="tb-label">{{ __('general.sort_order') }}</label>
                                <div class="tb-select">
                                    <select data-componentid="@this" class="filter-select2 form-control"
                                            data-searchable="false" data-hide_search_opt="true" data-live='true' id="sort_by"
                                            data-wiremodel="sortby">
                                        <option value="asc" {{ $sortby=='asc' ? 'selected' : '' }}>{{ __('general.asc') }}</option>
                                        <option value="desc" {{ $sortby=='desc' ? 'selected' : '' }}>{{ __('general.desc') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group tb-inputicon tb-inputheight">
                                <i class="icon-search"></i>
                                <input type="text" class="form-control"
                                       wire:model.live.debounce.500ms="search"
                                       autocomplete="off"
                                       placeholder="{{ __('general.search_tutor') }}">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>

            <div class="am-disputelist_wrap" style="position: relative;">
                <div wire:loading wire:target="search,verification,filterUser,sortby" 
                     style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 999;">
                    <x-loader />
                </div>
                <div class="am-disputelist am-custom-scrollbar-y" 
                     wire:loading.class="tb-blur-loading" 
                     wire:target="search,verification,filterUser,sortby">
                    @if(!$tutors->isEmpty())
                        <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Created') }}</th>
                                    <th>{{ __('Verified') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tutors as $tutor)
                                    <tr>
                                        <td>{{ $tutor->id }}</td>
                                        <td>
                                            <div class="tb-varification_userinfo">
                                                <strong class="tb-adminhead__img">
                                                    @if (!empty($tutor->profile->image) && file_exists(public_path('storage/' . $tutor->profile->image)))
                                                        <img src="{{ asset('storage/' . $tutor->profile->image) }}" alt="{{ $tutor->profile->full_name }}" />
                                                    @else
                                                        <img src="{{ asset('images/default.png') }}" alt="avatar" />
                                                    @endif
                                                </strong>
                                                <span>{{ $tutor->profile->full_name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $tutor->email }}</td>
                                        <td>{{ $tutor->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge {{ $tutor->email_verified_at ? 'bg-success' : 'bg-warning' }}">
                                                {{ $tutor->email_verified_at ? 'Verificado' : 'No verificado' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $tutor->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($tutor->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.tutors.show', $tutor->id) }}" class="btn btn-sm btn-info">
                                                Ver
                                            </a>
                                            {{-- Puedes agregar más acciones aquí --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- {{ $tutors->links('pagination.custom') }} --}}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')"/>
                    @endif
                </div>
            </div>
        </div>
        
        {{ $tutors->links('pagination.custom') }}
        
        <!-- Modal Agregar Tutor -->
        <div wire:ignore.self class="modal fade tb-addonpopup" id="tb-add-tutor" aria-labelledby="tb_tutor_info_label"
            role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg tb-modaldialog" role="document">
                <div class="modal-content">
                    <div class="tb-popuptitle">
                        <h5 id="tb_tutor_info_label">{{ __('general.tutor_information') }}</h5>
                        <a href="javascript:void(0);" class="close"><i class="icon-x" data-bs-dismiss="modal"></i></a>
                    </div>
                    <div class="modal-body">
                        <form class="tb-themeform" wire:submit.prevent="addTutor" id="add_tutor_form">
                            <fieldset>
                                <div class="form-group-wrap">
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.first_name') }}</label>
                                        <input type="text"
                                            class="form-control @error('first_name') tk-invalid @enderror"
                                            wire:model="first_name" 
                                            placeholder="{{ __('general.name_placeholder') }}">
                                        @error('first_name')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.last_name') }}</label>
                                        <input type="text"
                                            class="form-control @error('last_name') tk-invalid @enderror"
                                            wire:model="last_name"
                                            placeholder="{{ __('general.lastname_placeholder') }}">
                                        @error('last_name')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.email') }}</label>
                                        <input type="email" 
                                            class="form-control @error('email') tk-invalid @enderror"
                                            wire:model="email" 
                                            placeholder="{{ __('general.email_placeholder') }}">
                                        @error('email')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.password') }}</label>
                                        <input type="password" 
                                            wire:model="password"
                                            class="form-control @error('password') tk-invalid @enderror"
                                            placeholder="{{ __('general.password_placeholder') }}">
                                        @error('password')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="tb-label">{{ __('general.confirm_password') }}</label>
                                        <input type="password" 
                                            wire:model="confirm_password"
                                            class="form-control @error('confirm_password') tk-invalid @enderror"
                                            placeholder="{{ __('general.password_placeholder') }}">
                                        @error('confirm_password')
                                        <div class="tk-errormsg">
                                            <span>{{ $message }}</span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group tb-formbtn">
                                        <button class="tb-btn" type="submit" wire:target="addTutor"
                                            wire:loading.class="am-btn_disable">{{ __('general.save_tutor') }}</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function initFilterSelects() {
            $('.filter-select2').each(function() {
                const $select = $(this);
                
                // Evitar reinstalar si ya tiene select2 (los elementos tienen wire:ignore)
                if ($select.hasClass("select2-hidden-accessible")) {
                    return;
                }
                
                $select.select2({
                    minimumResultsForSearch: -1,
                    width: '100%'
                });
                
                // Escuchar eventos de Select2 al seleccionar o limpiar una opción
                $select.off('select2:select select2:clear').on('select2:select select2:clear', function(e) {
                    const wireModel = $(this).data('wiremodel');
                    const value = $(this).val();
                    @this.set(wireModel, value);
                });
            });
        }
        
        initFilterSelects();
    });
</script>
@endpush

@push('styles')
<style>
.tb-blur-loading {
    filter: blur(3px);
    pointer-events: none;
    transition: filter 0.3s ease;
}
</style>
@endpush
