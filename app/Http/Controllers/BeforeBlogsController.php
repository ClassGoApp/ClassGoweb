<?php

namespace App\Http\Controllers;


use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class BeforeBlogsController extends Controller
{
    /**
     * Mostrar las miniaturas de los blogs publicados.
     */
    public function index()
    {
        // Cargamos los blogs con sus relaciones necesarias
        $blogs = Blog::with(['categories', 'tags', 'author'])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($blog) {
                // Descripción corta (30–40 palabras)
                $blog->short_description = Str::words(strip_tags($blog->description), 35, '...');

                // Primera categoría (por ejemplo: Negocio)
                $blog->main_category = $blog->categories->first()?->name ?? 'General';

                // Generar URL (usa slug si existe)
                $blog->url = route('blogs.show', $blog->slug ?? $blog->id);

                return $blog;
            });

        return view('vistas.view.pages.blog', compact('blogs'));
    }
}
