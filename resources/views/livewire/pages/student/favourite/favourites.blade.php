<div class="am-resumebox_content am-favourites" wire:init="loadData">
    @slot('title')
        {{ __('sidebar.favourites') }}
    @endslot
    <div class="am-title_wrap">
        <div class="am-title">
            <h2>{{ __('profile.favourite_title') }}</h2>
            <p>{{ __('profile.description_text') }}</p>
        </div>
    </div>
    <div class="am-resumewrap">
        @if($isLoading)
            @include('skeletons.favourites')
        @else
             @if(!$favourites->isEmpty())
            <div class="am-resume">
                @foreach($favourites as $favourite)
                    <div class="am-resume_item am-resume_wrap">
                            @if (!empty($favourite->profile->image) && Storage::disk(getStorageDisk())->exists($favourite->profile->image))
                                <img src="{{ resizedImage($favourite->profile->image,50,50) }}" alt="Foto de perfil"
                                    data-translate-alt="tutor_profile_photo_alt" />
                            @else
                                <img src="{{ setting('_general.default_avatar_for_user') ? url(Storage::url(setting('_general.default_avatar_for_user')[0]['path'])) : resizedImage('placeholder.png', 50, 50) }}" alt="Foto de perfil"
                                    data-translate-alt="tutor_profile_photo_alt" />
                            @endif
                        <div class="am-resume_content">
                                <div class="am-resume_item_title">
                                    <h3>{{$favourite->profile->full_name}}</h3>
                                    <div class="am-favourite-actions">
                                        <a href="{{ url('/tutores/' . $favourite->profile->slug) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Ver perfil"
                                            data-translate-title="favourites_view_profile_title">
                                            <i class="am-icon-eye-open-01"></i>
                                            <span data-translate="favourites_view_profile">Ver perfil</span>
                                        </a>

                                        <button type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            @click="$wire.dispatch('showConfirm', { id : {{ $favourite->id }}, action : 'remove-favourite-user' })"
                                            title="Eliminar de favoritos"
                                            data-translate-title="favourites_remove_title">
                                            <i class="am-icon-trash-02"></i>
                                            <span data-translate="general_delete">Eliminar</span>
                                        </button>
                                    </div>
                                </div>
                            <ul class="am-resume_item_info">
                                <li>
                                    <span>
                                        <i class="am-icon-book-1"></i>
                                        <span data-translate="language_{{ strtolower($favourite->profile->native_language) }}">
                                            {{ $favourite->profile->native_language }}
                                        </span>
                                    </span>
                                </li>
                                @if ($favourite?->address?->country?->short_code)
                                <li>
                                    <span>
                                        <span class="flag flag-{{ strtolower($favourite?->address?->country?->short_code) }}"></span>
                                        {{ $favourite?->address?->country?->name}}
                                    </span>
                                </li>
                                @endif
                                <li>
                                    <span class="am-favrating">
                                        <i class="am-icon-star-filled"></i>
                                        <span class="am-uniqespace"><em>{{ number_format($favourite?->reviews_avg_rating, 1) }}</em>/5.0</span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            <div class="am-page-error-wrap">
                <x-no-record :image="asset('images/fvt.png')" :title="__('general.no_record_title')" :description="__('general.no_record_desc')"/>
            </div>
            @endif
        @endif
    </div>
</div>

@push('styles')
@vite([
'public/css/flags.css'
])
<style>
.am-favourite-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.am-favourite-actions .btn {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    white-space: nowrap;
}

.am-favourite-actions .btn i {
    font-size: 1rem;
}

@media (max-width: 768px) {
    .am-favourite-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .am-favourite-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush
