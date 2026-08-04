<?php

namespace App\Spotlight;

use Illuminate\Http\Request;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ManageSessions extends SpotlightCommand
{
    protected string $name = 'spotlight_manage_sessions_name';

    protected string $description = 'spotlight_manage_sessions_desc';

    protected array $synonyms = [
        'administrar',
        'sesiones',
        'crear',
        'manage',
        'sessions',
        'create',
        'gerenciar',
        'sessões',
        'criar',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirect(route('tutor.bookings.manage-sessions'));
    }

    public function shouldBeShown(Request $request): bool
    {
        return $request->user()->role == 'tutor';
    }
}
