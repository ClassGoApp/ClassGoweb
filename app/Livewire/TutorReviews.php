<?php

namespace App\Livewire;

use App\Models\User;
use App\Repositories\TutorRepository;
use Livewire\Component;
use Livewire\WithPagination;

class TutorReviews extends Component
{
    use WithPagination;

    public $tutor;
    public $rating = '';
    public $comment = '';
    public $canReview = false;
    public $reviews = [];
    public $ratingDistribution = [];
    public $averageRating = 0;
    public $totalReviews = 0;
    
    // Nueva propiedad para manejar alertas
    public $showSuccessAlert = false;
    public $alertMessage = '';

    protected $rules = [
        'rating' => 'required|numeric|min:1|max:5',
        'comment' => 'nullable|string|max:1000'
    ];

    protected $messages = [
        'rating.required' => 'Por favor selecciona una calificación',
        'rating.min' => 'La calificación mínima es 1 estrella',
        'rating.max' => 'La calificación máxima es 5 estrellas',
        'comment.max' => 'El comentario no puede tener más de 1000 caracteres'
    ];

    public function mount($tutor, $reviews = [], $avgRating = 0, $totalReviews = 0, $ratingDistribution = [])
    {
        $this->tutor = $tutor;
        
        if (!empty($reviews)) {
            $this->reviews = $reviews;
            $this->averageRating = $avgRating;
            $this->totalReviews = $totalReviews;
            $this->ratingDistribution = $ratingDistribution;
        } else {
            $this->loadReviewData();
        }
        
        $this->checkCanReview();
    }

    public function selectRating($value)
    {
        $this->rating = $value;
    }

    public function submitReview()
    {
        if (!$this->canReview) {
            $this->showAlert('error', 'No puedes reseñar a este tutor.');
            return;
        }

        $this->validate();

        try {
            $tutorRepository = new TutorRepository();
            
            $result = $tutorRepository->createReview([
                'rating' => $this->rating,
                'comment' => $this->comment,
                'tutor_id' => $this->tutor->id,
                'reviewer_id' => auth()->id()
            ]);

            if ($result['success']) {
                // ✨ CLAVE: Recargar TODOS los datos después de crear la reseña
                $this->loadReviewData();
                $this->checkCanReview();
                
                // Limpiar formulario
                $this->reset(['rating', 'comment']);
                
                // Mostrar alerta de éxito
                $this->showAlert('success', $result['message']);
                
            } else {
                $this->showAlert('error', $result['message']);
            }
        } catch (\Exception $e) {
            \Log::error('Error submitting review: ' . $e->getMessage());
            $this->showAlert('error', 'Error al enviar la reseña. Inténtalo de nuevo.');
        }
    }

    private function showAlert($type, $message)
    {
        if ($type === 'success') {
            $this->showSuccessAlert = true;
            $this->alertMessage = $message;
            
            // Ocultar después de 5 segundos
            $this->dispatch('hide-alert-after', delay: 5000);
        }
        // Aquí puedes agregar manejo para otros tipos de alertas si es necesario
    }

    public function hideAlert()
    {
        $this->showSuccessAlert = false;
        $this->alertMessage = '';
    }

    private function loadReviewData()
    {
        try {
            $tutorRepository = new TutorRepository();
            $reviewData = $tutorRepository->getTutorReviewsWithStats($this->tutor->id);
            
            // 🎯 Actualizar TODAS las propiedades reactivas
            $this->reviews = $reviewData['reviews'];
            $this->averageRating = $reviewData['stats']['avgRating'] ?? 0;
            $this->totalReviews = $reviewData['stats']['totalReviews'] ?? 0;
            $this->ratingDistribution = $reviewData['stats']['distribution'] ?? [];
            
            // 🚀 Asegurar que las barras se ordenen correctamente (5 a 1)
            $this->ratingDistribution = collect($this->ratingDistribution)
                ->sortKeysDesc()
                ->toArray();
                
        } catch (\Exception $e) {
            \Log::error('Error loading review data: ' . $e->getMessage());
            
            // Valores por defecto en caso de error
            $this->reviews = collect([]);
            $this->averageRating = 0;
            $this->totalReviews = 0;
            $this->ratingDistribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        }
    }

    private function checkCanReview()
    {
        if (auth()->check()) {
            try {
                $tutorRepository = new TutorRepository();
                $this->canReview = $tutorRepository->canUserReviewTutor(auth()->id(), $this->tutor->id);
            } catch (\Exception $e) {
                \Log::error('Error checking can review: ' . $e->getMessage());
                $this->canReview = false;
            }
        } else {
            $this->canReview = false;
        }
    }

    public function render()
    {
        return view('livewire.tutor-reviews');
    }
}