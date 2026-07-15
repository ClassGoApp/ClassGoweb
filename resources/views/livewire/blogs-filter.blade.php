<div class="contendor-livewire-blogs">
    <header class="blog-section">
        <h2 class="todos-blogs" data-translate="blog_all_blogs">Todos los blogs</h2>
        <div class="blog-filters">
            <select wire:model.live="category">
                <option value="" data-translate="blog_select_category">Seleccionar categoría</option>

                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ ucfirst($cat->name) }}</option>
                @endforeach
            </select>

            <select wire:model.live="order">
                <option value="" data-translate="blog_order_by">Ordenar por</option>
                <option value="recientes" data-translate="blog_most_recent">Más recientes</option>
                <option value="populares" data-translate="blog_most_popular">Más populares</option>
            </select>
        </div>
    </header>

    <div class="content-cards transition-all duration-300" wire:target="category,order" wire:loading.class="fade-out"
        wire:loading.remove.class="fade-in">

        @forelse ($blogs as $blog)

            <a href="{{ $blog->url }}" class="cards" wire:key="blog-{{ $blog->id }}"
                style="text-decoration:none; color:inherit;">
                {{-- <div class="img" loading="lazy">
                    @if ($blog->image)
                        @php
                            $imagePath = storage_path('app/public/' . $blog->image);
                            $imageExists = file_exists($imagePath);
                        @endphp

                        @if ($imageExists)
                            @php
                                $imageData = base64_encode(file_get_contents($imagePath));
                                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                            @endphp

                            <img src="{{ $imageSrc }}" alt="{{ $blog->title }}" />
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
                </div> --}}
                <div class="img">
                    @if ($blog->image)
                        @php
                            $imagePath = storage_path('app/public/' . $blog->image);
                            $imageExists = file_exists($imagePath);
                        @endphp

                        @if ($imageExists)
                            @php
                                $imageData = base64_encode(file_get_contents($imagePath));
                                $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                                $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                            @endphp

                            <div class="img-wrapper">
                                <img class="img-blur" src="{{ $imageSrc }}" alt="">
                                <img class="img-main" src="{{ $imageSrc }}" alt="{{ $blog->title }}">
                            </div>
                        @else
                            <div class="tb-no-image">…</div>
                        @endif
                    @else
                        <div class="tb-no-image">…</div>
                    @endif
                </div>


                <h4 class="categoria">
                    @if ($blog->main_category)
                        {{ $blog->main_category }}
                    @else
                        <span data-translate="blog_category_general">General</span>
                    @endif
                    /
                    {{ $blog->created_at ? $blog->created_at->format('d \d\e F \d\e Y') : '' }}
                </h4>

                <div class="title-cards">
                    <h3 class="titulo">{{ $blog->title }}</h3>
                </div>

                <p class="descripcion">{{ $blog->short_description }}</p>

                @if ($blog->tags && $blog->tags->count())
                    <div class="tags">
                        <div class="tags-track">
                            @foreach ($blog->tags as $tag)
                                <span class="tag">{{ $tag->name }}</span>
                            @endforeach
                            @foreach ($blog->tags as $tag)
                                <span class="tag">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </a>

        @empty
            <p style="font-weight: 500; height: 477px;" data-translate="blog_no_available">
                No hay blogs disponibles.
            </p>
        @endforelse
    </div>
</div>
