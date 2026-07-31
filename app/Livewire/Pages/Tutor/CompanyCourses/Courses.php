<?php

namespace App\Livewire\Pages\Tutor\CompanyCourses;

use App\Models\CompanyCourse;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Courses extends Component
{
    public $currentCourse;
    public $exam;
    public $answers = [];

    public function mount()
    {
        $user = Auth::user();

        $courses = CompanyCourse::whereHas(
            'users',
            function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->whereIn(
                        'company_course_user.status',
                        ['pending', 'in_progress']
                    );
            }
        )
            ->with([
                'users' => function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                },
                'exams.questions'
            ])
            ->get();

        $this->currentCourse = $courses
            ->sortBy(function ($course) {
                $status = $course->users->first()?->pivot?->status;

                return $status === 'pending' ? 0 : 1;
            })
            ->first();

        $this->exam = $this->currentCourse?->exams?->first();
    }

    public function submitExam()
    {
        $user = Auth::user();
        $exam = $this->exam;
        $questions = $exam->questions;

        $this->validate(
            [
                'answers' => ['required', 'array'],
            ],
            [
                'answers.required' => __('company_courses.exam_answers_required'),
                'answers.array' => __('company_courses.exam_answers_invalid'),
            ]
        );

        $score = 0;
        $total = 0;
        $allCorrect = true;

        foreach ($questions as $q) {
            $qid = $q->id;
            $userAnswer = $this->answers[$qid] ?? null;
            $correct = false;

            if ($q->type === 'opcion_unica') {
                
                \Log::debug('Pregunta', [
                    'id' => $qid,
                    'userAnswer' => $userAnswer,
                    'correct_answer' => $q->correct_answer,
                    'comparacion' => $userAnswer == $q->correct_answer
                ]);

                $correct = $userAnswer !== null
                    && $userAnswer == $q->correct_answer;
            } else {

                continue;
            }

            if ($correct) {
                $score += $q->score;
            } else {
                $allCorrect = false;
            }

            $total += $q->score;
        }

        if ($allCorrect) {
            $pivot = \App\Models\CompanyCourseUser::where(
                'company_course_id',
                $this->currentCourse->id
            )
                ->where('user_id', $user->id)
                ->first();

            if ($pivot) {
                $pivot->status = 'completed';
                $pivot->save();
            }

            session()->flash(
                'exam_success',
                __('company_courses.exam_success')
            );

            $courses = CompanyCourse::whereHas(
                'users',
                function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                        ->whereIn(
                            'company_course_user.status',
                            ['pending', 'in_progress']
                        );
                }
            )
                ->with([
                    'users' => function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    },
                    'exams.questions'
                ])
                ->get();

            $this->currentCourse = $courses
                ->sortBy(function ($course) {
                    $status = $course->users->first()?->pivot?->status;

                    return $status === 'pending' ? 0 : 1;
                })
                ->first();

            $this->exam = $this->currentCourse?->exams?->first();
            $this->answers = [];

            $this->dispatch('video-updated');
            $this->dispatch('close-exam-modal');
        } else {
            session()->flash(
                'exam_error',
                __('company_courses.exam_error')
            );

            $this->dispatch('video-updated');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view(
            'livewire.pages.tutor.company-courses.courses',
            [
                'currentCourse' => $this->currentCourse,
                'exam' => $this->exam
            ]
        );
    }
}
