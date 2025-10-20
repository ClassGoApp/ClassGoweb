<main class="tb-main am-dispute-system am-blogs-system">
    <div class="row">
        <div class="col-lg-12 col-md-12 tb-md-12">
            <div class="tb-dhb-mainheading">
                <h4> {{ __('blogs.blogs') }}</h4>
                <div class="tb-sortby">
                    <form class="tb-themeform tb-displistform">
                        <fieldset>
                            <div class="tb-themeform__wrap">
                                <div class="tb-actionselect">
                                    <a href="javascript:;" class="tb-btn btnred {{ $selectedBlogs ? '' : 'd-none' }}" @click="$wire.dispatch('showConfirm', { action : 'delete-blog' })">{{ __('general.delete_selected') }}</a>
                                </div>
                                <a href="{{route('admin.create-blog')}}" class="tb-btn tb-menubtn">
                                    {{ __('blogs.add_blog') }} <i class="icon-plus"></i>
                                </a>
                                
                                <div class="tb-actionselect">
                                    <div class="tb-select" wire:ignore>
                                        <select id="filter_sort" class="form-control tk-select2">
                                            <option value="asc" {{ $sortby == 'asc' ? 'selected' : '' }}>{{ __('general.asc') }}</option>
                                            <option value="desc" {{ $sortby == 'desc' ? 'selected' : '' }}>{{ __('general.desc') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tb-actionselect" wire:ignore>
                                    <div class="tb-select">
                                        <select id="filter_per_page" class="form-control tk-select2">
                                            @foreach($perPageOptions as $opt)
                                                <option value="{{$opt}}">{{$opt}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group tb-inputicon tb-inputheight">
                                    <i class="icon-search"></i>
                                    <input type="text" class="form-control" wire:model.live.debounce.500ms="search" autocomplete="off" placeholder="{{ __('taxonomy.search_here') }}">
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="am-disputelist_wrap">
                <div class="am-disputelist am-custom-scrollbar-y">
                    @if(!empty($blogs) && $blogs->count() > 0)
                        <table class="tb-table @if(setting('_general.table_responsive') == 'yes') tb-table-responsive @endif">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">
                                        <div class="tb-checkbox">
                                            <input id="checkAll" wire:model.lazy="selectAll" type="checkbox">
                                            <label for="checkAll">{{ __('general.select') }}</label>
                                        </div>
                                    </th>
                                    <th style="width: 100px;">{{ __('blogs.blog_image') }}</th>
                                    <th style="width: 180px;">{{ __('general.title') }}</th>
                                    <th style="width: 200px;">{{ __('general.description') }}</th>
                                    <th style="width: 150px;">{{ __('blogs.categories') }}</th>
                                    <th style="width: 120px;">{{ __('blogs.tags') }}</th>
                                    <th style="width: 130px;">{{ __('blogs.author') }}</th>
                                    <th style="width: 100px;">{{ __('general.status') }}</th>
                                    <th style="width: 100px;">{{ __('general.created_at') }}</th>
                                    <th style="width: 150px;">{{ __('general.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $single)
                                    <tr>
                                        <td data-label="{{ __('general.select') }}">
                                            <div class="tb-checkbox">
                                                <input id="blog_id{{ $single->id }}" wire:model.lazy="selectedBlogs" value="{{ $single->id }}" type="checkbox">
                                                <label for="blog_id{{ $single->id }}"></label>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('blogs.blog_image') }}">
                                            @if($single->image)
                                                @php
                                                    $imagePath = storage_path('app/public/' . $single->image);
                                                    $imageExists = file_exists($imagePath);
                                                @endphp

                                                @if($imageExists)
                                                    @php
                                                        $imageData = base64_encode(file_get_contents($imagePath));
                                                        $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                                        $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                                                    @endphp
                                                    <div class="tb-blog-image">
                                                        <img src="{{ $imageSrc }}" alt="{{ $single->title }}" width="80" height="60" style="object-fit: cover; border-radius: 4px;">
                                                    </div>
                                                @else
                                                    <div class="tb-no-image">
                                                        <i class="icon-image" style="font-size: 24px; color: #ccc;"></i>
                                                        <small>File not found</small>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="tb-no-image">
                                                    <i class="icon-image" style="font-size: 24px; color: #ccc;"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('general.title') }}">
                                            <div class="tb-blog-title">
                                                <h6 class="tb-title">{{ $single->title }}</h6>
                                                {{-- @if($single->slug)
                                                    <small class="text-muted">{{ $single->slug }}</small>
                                                @endif --}}
                                            </div>
                                        </td>
                                        <td data-label="{{ __('general.description') }}">
                                            <span class="fw-form-description">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($single->description), 100) }}
                                            </span>
                                        </td>
                                        <td data-label="{{ __('blogs.categories') }}">
                                            @if(!empty($single->categories) && $single->categories->count() > 0)
                                                <div class="tb-categories-list">
                                                    @foreach ($single->categories as $key => $category)
                                                        <span class="tb-category-tag">{{ $category->name }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">{{ __('blogs.no_categories') }}</span>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('blogs.tags') }}">
                                            @if(!empty($single->tags) && $single->tags->count() > 0)
                                                <div class="tb-tags-list">
                                                    @foreach ($single->tags->take(3) as $tag)
                                                        <span class="tb-tag-item">{{ $tag->name }}</span>
                                                    @endforeach
                                                    @if($single->tags->count() > 3)
                                                        <span class="tb-tag-more">+{{ $single->tags->count() - 3 }}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">{{ __('blogs.no_tags') }}</span>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('blogs.author') }}">
                                            @if($single->author)
                                                <div class="tb-author-info">
                                                    <span class="tb-author-name">{{ $single->author->first_name }} {{ $single->author->last_name }}</span>
                                                    <small class="text-muted">{{ $single->author->email }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">{{ __('general.unknown') }}</span>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('general.status') }}">
                                            <div class="am-status-tag">
                                                <em class="tk-project-tag tk-{{ $single->status == 'published' ? 'active' : 'disabled' }}" style="padding-left: 20px">
                                                    {{ ucfirst($single->status) }}
                                                </em>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('general.created_at') }}">
                                            <div class="tb-date-info">
                                                <span class="tb-date">{{ $single->created_at->format('M d, Y') }}</span>
                                                <small class="text-muted">{{ $single->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('general.actions') }}">
                                            <ul class="tb-action-icon">
                                                <li> 
                                                    <a href="{{ route('admin.update-blog', $single->id) }}" title="{{ __('general.edit') }}">
                                                        <i class="icon-edit-3"></i>
                                                    </a> 
                                                </li>
                                                <li> 
                                                    <a href="{{ route('blog-details', ['slug' => $single->slug, 'source' => 'admin']) }}" target="_blank" title="{{ __('general.view') }}">
                                                        <i class="icon-eye"></i>
                                                    </a> 
                                                </li>
                                                <li>    
                                                    <a href="javascript:void(0);" 
                                                    @click="$wire.dispatch('showConfirm', { id: {{ $single->id }}, action: 'delete-blog' })" 
                                                    class="tb-delete"
                                                    title="{{ __('general.delete') }}">
                                                    <i class="icon-trash-2"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $blogs->links('pagination.custom') }}
                    @else
                        <x-no-record :image="asset('images/empty.png')" :title="__('general.no_record_title')"/>
                    @endif
                </div>
            </div>
        </div>    
    </div>
</main>
@push('styles')
    @vite([
        'public/summernote/summernote-lite.min.css',
    ])

    <style>
        /* Optimización general de la tabla */
        .tb-table {
            table-layout: fixed;
            width: 100%;
        }
        
        .tb-table th,
        .tb-table td {
            padding: 8px 6px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow: hidden;
        }
        
        /* Checkbox más compacto */
        .tb-checkbox {
            margin: 0;
            padding: 0;
        }
        
        .tb-checkbox label {
            margin: 0;
            padding: 0;
            font-size: 0;
        }
        
        /* Imagen más compacta */
        .tb-blog-image img {
            border-radius: 4px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
        }
        
        .tb-no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 45px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin: 0 auto;
        }
        
        .tb-no-image i {
            font-size: 18px;
            color: #ccc;
        }
        
        /* Título más compacto */
        .tb-blog-title .tb-title {
            margin: 0 0 2px 0;
            font-size: 13px;
            font-weight: 600;
            color: #333;
            line-height: 1.2;
        }
        
        .tb-blog-title small {
            font-size: 10px;
            line-height: 1.1;
        }
        
        /* Categorías más compactas */
        .tb-categories-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .tb-category-tag {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 500;
            text-align: center;
            display: inline-block;
            margin-bottom: 2px;
        }
        
        .tb-category-more {
            background-color: #e0e0e0;
            color: #666;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 10px;
            text-align: center;
        }
        
        /* Tags más compactos */
        .tb-tags-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        
        .tb-tag-item {
            background-color: #f3e5f5;
            color: #7b1fa2;
            padding: 2px 4px;
            border-radius: 6px;
            font-size: 9px;
            text-align: center;
            display: inline-block;
            margin-bottom: 2px;
        }
        
        .tb-tag-more {
            background-color: #e0e0e0;
            color: #666;
            padding: 2px 4px;
            border-radius: 6px;
            font-size: 9px;
            text-align: center;
        }
        
        /* Autor más compacto */
        .tb-author-info .tb-author-name {
            display: block;
            font-weight: 500;
            color: #333;
            font-size: 12px;
            line-height: 1.2;
        }
        
        /* Fecha más compacta */
        .tb-date-info .tb-date {
            display: block;
            font-weight: 500;
            color: #333;
            font-size: 11px;
            line-height: 1.2;
        }
        
        /* Descripción más compacta */
        .fw-form-description {
            font-size: 11px;
            line-height: 1.3;
            color: #666;
        }
        
        /* Status más compacto */
        .am-status-tag .tk-project-tag {
            font-size: 10px;
            padding: 3px 8px;
        }
        
        /* Acciones más compactas */
        .tb-action-icon {
            margin: 0;
            padding: 0;
        }
        
        .tb-action-icon li {
            display: inline-block;
            margin: 0 2px;
        }
        
        .tb-action-icon li a {
            padding: 4px;
            font-size: 14px;
        }
        
        /* Responsivo */
        @media (max-width: 768px) {
            .tb-table th,
            .tb-table td {
                padding: 6px 4px;
            }
            
            .tb-blog-image img {
                width: 50px;
                height: 38px;
            }
            
            .tb-no-image {
                width: 50px;
                height: 38px;
            }
            
            .tb-blog-title .tb-title {
                font-size: 12px;
            }
            
            .tb-category-tag,
            .tb-tag-item {
                font-size: 9px;
                padding: 1px 4px;
            }
        }
        
        /* Ajustes adicionales para una tabla más compacta */
        .am-disputelist {
            overflow-x: auto;
        }
        
        .tb-table thead th {
            font-size: 12px;
            font-weight: 600;
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        
        .tb-table tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('scripts')
    <script defer src="{{ asset('summernote/summernote-lite.min.js')}}"></script>

    <script type="text/javascript" data-navigate-once>
        document.addEventListener('livewire:navigated', function() {
            component = @this;
        });

        document.addEventListener('livewire:initialized', function() {
            jQuery('#filter_sort').on('change', function (e) {
                var selectedSort = $(this).val();
                component.set('sortby', selectedSort);
            });

            jQuery('#filter_per_page').on('change', function (e) {
                var selectedSort = $(this).val();
                component.set('perPage', selectedSort);
            });
        });
        
        
    </script>
@endpush
