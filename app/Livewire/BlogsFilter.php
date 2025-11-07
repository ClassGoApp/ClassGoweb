<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogsFilter extends Component
{
    public $category = '';  // id de la categoría seleccionada
    public $order = '';     // orden seleccionado
    public $search = '';
    public $suggestions = [];
    public function updatedSearch()
    {
        // Mostrar sugerencias rápidas debajo del input
        $this->suggestions = Blog::where('status', 1)
            ->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->take(5)
            ->get(['id', 'slug', 'title']);
    }
    public function selectSuggestion($slug)
    {
        return redirect()->route('blogs.show', $slug);
    }

    public function searchBlogs()
    {
        // 🔹 Al presionar el botón “Buscar”:
        // vaciamos sugerencias y aplicamos búsqueda general
        $this->suggestions = [];
    }
    public function render()
    {
        // 🔹 1. Traer todas las categorías activas
        $categories = BlogCategory::where('status', 'active')->get();

        // 🔹 2. Query base: todos los blogs activos con relaciones
        $query = Blog::with(['categories', 'tags', 'author'])
            ->where('status', 1);

        // 🔹 3. Filtro por categoría (usa relación belongsToMany correctamente)
        if (!empty($this->category)) {
            $query->whereHas('categories', function ($q) {
                $q->where('blog_categories.id', $this->category);
            });
        }
        //else {
        //     $blogs = $query->get()->map(function ($blog) {
        //         $blog->short_description = Str::words(strip_tags($blog->description), 35, '...');
        //         $blog->main_category = $blog->categories->first()?->name ?? 'General';
        //         $blog->image_url = Storage::url($blog->image);
        //         $blog->url = route('blogs.show', $blog->slug ?? $blog->id);
        //         return $blog;
        //     });
        // }
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }
        // 🔹 4. Ordenamiento
        if ($this->order === 'recientes') {
            $query->orderByDesc('created_at');
        } elseif ($this->order === 'populares') {
            // ⚠️ Requiere columna 'views' en la tabla blogs
            $query->orderByDesc('views_count');
        } else {
            $query->orderBy('created_at', 'asc');
        }

        // 🔹 5. Obtener y formatear los blogs
        $blogs = $query->get()->map(function ($blog) {
            $blog->short_description = Str::words(strip_tags($blog->description), 35, '...');
            $blog->main_category = $blog->categories->first()?->name ?? 'General';
            $blog->image_url = Storage::url($blog->image);
            $blog->url = route('blogs.show', $blog->slug ?? $blog->id);
            return $blog;
        });

        // 🔹 6. Devolver la vista con datos
        return view('livewire.blogs-filter', [
            'blogs' => $blogs,
            'categories' => $categories,
        ]);
    }
}
