<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSearch extends Component
{
    public $search = '';
    public $suggestions = [];

    public function updatedSearch()
    {
        if (strlen($this->search) > 1) {
            $this->suggestions = Blog::where('status', 1)
                ->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                })
                
                ->get(['id', 'slug', 'title']);
        } else {
            $this->suggestions = [];
        }
    }

    public function selectSuggestion($slug)
    {
        return redirect()->route('blogs.show', $slug);
    }

    public function searchBlogs()
    {

        if (trim($this->search) === '') {
            return;
        }

        $first = Blog::where('status', 1)
            ->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderByDesc('created_at')
            ->first(['slug']);

        if ($first) {
            return redirect()->route('blogs.show', $first->slug);
        }


        $this->dispatch('no-results-found');
    }


    public function render()
    {
        return view('livewire.blog-search');
    }
    protected $listeners = [
        'clearSuggestions' => 'clearSuggestions',
        'restoreSuggestions' => 'restoreSuggestions',
    ];

    public function clearSuggestions()
    {
        $this->suggestions = [];
    }

    public function restoreSuggestions($search = '')
    {
        $search = trim($this->search);
        if (!empty($search)) {
            $this->suggestions = Blog::where('status', 1)
                ->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                })
                ->take(5)
                ->get(['id', 'slug', 'title']);
        } else {
            $this->suggestions = [];
        }
    }
}
