@extends('vistas.view.layouts.app')

@section('title', 'Class Go! | ¿Quiénes somos?')

@section('body-class', 'nosotros')

@section('content')
    <div class="content-blog-padre">
        <div class="header-blog-menu"></div>
        <div class="content-bread">
            <nav class="bread-list">
                <a class="bread" href="{{ url('/') }}" class="bread-link">Inicio</a>
                <span class="bread-separator">/</span>
                <a class="bread" href="{{ route('blogs.index') }}" class="bread-link">Blog</a>
                <span class="bread-separator">/</span>
                <span class="bread">{{ $categories->first()->name ?? 'Lorem' }}</span>
            </nav>
        </div>
        <div class="content-blog-individual">
            <nav class="meta-info">
                <h6 class="meta-desc">{{ $categories->first()->name }}</h6>
                <span class="meta-separator"> - </span>
                <h6 class="meta-desc">
                    {{ $created_at }}
                </h6>
                <span class="meta-separator"> - </span>
                <h6 class="meta-desc">
                    {{ $reading_time }} min de lectura
                </h6>
            </nav>
            <h1 class="titulo-blog">
                {{ $meta_title }}
            </h1>
            <h3 class="meta-descripcion">
                {{ $meta_description }}
            </h3>

            <div class="img-blog">
                @if ($image_url)
                    @php
                        $imagePath = storage_path('app/public/' . $image_url);
                        $imageExists = file_exists($imagePath);
                    @endphp

                    @if ($imageExists)
                        @php
                            $imageData = base64_encode(file_get_contents($imagePath));
                            $imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
                            $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                        @endphp

                        <div class="img-blog-frame">
                            <img class="img-blog-bg" src="{{ $imageSrc }}" alt="">
                            <img class="img-blog-front" src="{{ $imageSrc }}" alt="{{ $title }}" onclick="openImageModal(this)">
                        </div>
                    @else
                        <div class="tb-no-image">
                            <i class="icon-image"></i>
                            <small>File not found</small>
                        </div>
                    @endif
                @else
                    <div class="tb-no-image">
                        <i class="icon-image"></i>
                    </div>
                @endif
            </div>

            <h3 class="meta-titulo">
                {{ $title }}
            </h3>
            <div class="padre-descripcion" style="color: var(--secundary-color2)">
                <p class="descripcion">
                    {!! $content !!}
                </p>
            </div>
            <div class="footer-blog">
                <div class="social-bar">
                    <a href="https://www.linkedin.com/company/classgoapp/about/?viewAsMember=true" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=61578383078347" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.tiktok.com/@classgoapp" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.instagram.com/classgo_app/" class="social-icon"><i class="fab fa-instagram"></i></a>


                    <a href="#" class="social-icon"><i class="fa-solid fa-link"></i></a>
                </div>
                <div class="stats-bar">
                    <div class="left-stats">
                        <i class="fa-solid fa-eye"></i>
                        <span>{{ $views_count }} visitas</span>
                    </div>

                </div>

            </div>

        </div>
        <div id="image-modal" class="image-modal" onclick="closeImageModal()">
    <img id="image-modal-content" />
</div>
        <div class="card-populares">Blogs Populares</div>
        <div class="content-cards" id="content-cards">


            @forelse ($topBlogs as $blog)
                <a href="{{ $blog->url }}" class="cards" style="text-decoration:none; color:inherit;">
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
                        {{ $blog->main_category ?? 'General' }} /
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
                <p style="font-weight: 500;">No hay blogs disponibles.</p>
            @endforelse
        </div>

    </div>
    <script>
function openImageModal(img) {
    const modal = document.getElementById('image-modal');
    const modalImg = document.getElementById('image-modal-content');

    modalImg.src = img.src;
    modal.style.display = 'flex';
}

// cerrar al hacer click fuera
function closeImageModal() {
    const modal = document.getElementById('image-modal');
    modal.style.display = 'none';
}

// evitar que click en la imagen cierre el modal
document.getElementById('image-modal-content').onclick = function(e) {
    e.stopPropagation();
};
</script>

@endsection
