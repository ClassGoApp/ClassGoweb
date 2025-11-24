<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\View;




class BeforeBlogsController extends Controller
{
    /**
     * Mostrar las miniaturas de los blogs publicados.
     */
    public function index()
    {
        

        return view('vistas.view.pages.blog');
        // , compact('blogs'));
    }
    public function showBySlug(string $slug)
    {
        // 1) Blog por slug (solo publicados status=1)
        $blog = DB::table('blogs')
            ->select(
                'id',
                'title',
                'description',
                'slug',
                'image',
                'status',
                'meta_title',
                'meta_description',
                'views_count',
                'created_at',
                'updated_at'
            )
            ->where('slug', $slug)
            ->where('status', 1)             // publicado
            ->first();

        if (!$blog) abort(404);


        $cookieKey = 'viewed_blog_' . $blog->id;

        if (!request()->cookie($cookieKey)) {
            // Incrementar vistas
            DB::table('blogs')->where('id', $blog->id)->increment('views_count');
            // Crear cookie que dura 1 hora

            cookie()->queue(cookie($cookieKey, true, 60));
        }

        // 2) Categorías del blog (pivot: blog_category_id)
        $categories = DB::table('blog_categories as c')
            ->join('blog_category_link as bcl', 'bcl.blog_category_id', '=', 'c.id')
            ->where('bcl.blog_id', $blog->id)
            ->select('c.id', 'c.name', 'c.slug')
            ->orderBy('c.name')
            ->get();

        // 3) Tags del blog (no hay slug en tags)
        $tags = DB::table('blog_tags as t')
            ->join('blog_tag_links as btl', 'btl.tag_id', '=', 't.id')
            ->where('btl.blog_id', $blog->id)
            ->select('t.id', 't.name')
            ->orderBy('t.name')
            ->get();

        // 4) Normalizaciones para la vista
        $imageUrl = $blog->image;
        $content  = $blog->description; // tu columna de contenido es 'description'


        // Combinar los textos que deseas considerar
        $textoCompleto = implode(' ', [
            $blog->meta_title ?? '',
            $blog->meta_description ?? '',
            $blog->title ?? '',
            $blog->description ?? ''
        ]);

        // Quitar etiquetas HTML y contar las palabras
        $wordCount = str_word_count(strip_tags($textoCompleto));
        // Calcular tiempo de lectura promedio (200 palabras/minuto)
        $readingTime = ceil($wordCount / 40);
        $formattedDate = Carbon::parse($blog->created_at)
            ->locale('es')        // español
            ->translatedFormat('j \d\e F'); // ejemplo: 25 de Abril
        $topBlogs = Blog::with(['categories', 'tags', 'author'])
            ->where('status', 1)
            ->orderByDesc('views_count')
            ->take(3)
            ->get()
            ->map(function ($blog) {
                $blog->short_description = Str::words(strip_tags($blog->description), 35, '...');
                $blog->main_category = $blog->categories->first()?->name ?? 'General';
                $blog->image_url = Storage::url($blog->image);
                $blog->url = route('blogs.show', $blog->slug ?? $blog->id);
                return $blog;
            });

        $data = [
            'title'            => $blog->title,
            'status'           => (int)$blog->status,
            'meta_title'       => $blog->meta_title ?: $blog->title,
            'meta_description' => $blog->meta_description ?? 'sin meta descripción',
            'content'          => $content,
            'image_url'        => $imageUrl,
            'categories'       => $categories,   // colección con id, name, slug
            'tags'             => $tags,         // colección con id, name
            'updated_at'       => $blog->updated_at,
            'created_at' => $formattedDate, // ya formateada
            'reading_time' => $readingTime, // minutos
            'views_count'      => $blog->views_count,
            'topBlogs'=>$topBlogs,
        ];


        return view('vistas.view.pages.BlogShow', $data);
    }

    // Si en 'image' guardas ruta relativa de storage, genera URL pública.
    // Si ya es URL absoluta (http/https), la devuelve tal cual.
    private function imageUrl(?string $path): string
    {
        if (!$path) return asset('img/placeholder.jpg');
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) return $path;
        return asset('storage/' . $path);
    }
}
