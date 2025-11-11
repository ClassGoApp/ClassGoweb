<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/install' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LaravelInstaller::welcome',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/install/environment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LaravelInstaller::environment',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/install/environment/save' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LaravelInstaller::environmentSave',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/install/requirements' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LaravelInstaller::requirements',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/install/permissions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LaravelInstaller::permissions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/install/database' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LaravelInstaller::database',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/install/final' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LaravelInstaller::final',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/messenger' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'laraguppy.messenger',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/chatapp-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'chatapp-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/contacts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZdanzgX0R7lsdwsW',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/friend-requests' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KZskIFeVhnUGbJmH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/blocked-friends' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rIR3LTIhLKgBMjeu',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/clear-chat' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VFEZUFQPkUDcRkby',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/account-notifications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Qm6JZRjU2qCEoJ7d',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/friends' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'friends.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'friends.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/threads' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'threads.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'threads.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/unread-counts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ylPizUsRYo842ssL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/delivered-message' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uEYMACdncE2cQlLQ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/messages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'messages.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/guppy-user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'guppy-user.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'guppy-user.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/broadcasting/auth' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eb3Uo84gi0peADtv',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'POST' => 1,
            'HEAD' => 2,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/translations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.translation.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/translations/publish' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.translation.publish',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.translation.export',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/translations/download' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.translation.download',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/translations/add-translation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.translation.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.translation.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/translations/import' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.translation.import',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/translations/source-translation' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.source_translation',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/translations/source-translation/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.source_translation.add_source_key',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.source_translation.store_source_key',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/translations/source-translation/delete-phrases' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.source_translation.delete_phrases',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/update' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/livewire.js' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cbLAxDIHpBwN23qi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/livewire.min.js.map' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::K5xrctwW7vUQ2uqV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/livewire/upload-file' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.upload-file',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::hQT7OHeI1cbsqxYy',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XOftbWkmMdqYlHDP',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/forget-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::E0CEmWZqpoHglW3w',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/recommended-tutors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::QvDRbFDxTg6dbNP5',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/find-tutors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::uXKt2JZODOMozJev',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/verified-tutors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::aejY4hhaftx8sZmI',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/students-list' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VRi5LSfZnmgdmqh9',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor-available-slots' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WWGkK4NiRonW6JVD',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor-education' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-education.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor-experience' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-experience.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor-certification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-certification.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/tutor-subjects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-subjects.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-subjects.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/countries' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jDq6pxmTiJxnHYvr',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/languages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GgCHGecGcjJfHoTf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/states' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ogkbKgOrsIndSp8N',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/subject-slots' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HawYEXVH0ti4TsI3',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/upcoming-bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::RMnkKet5DbVLqCFm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/reset-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::czYv1qypES1MQRli',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/resend-email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DbSGFfAfLEqQfWV7',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dkmTwDgCGLZ2L7oN',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/favourite-tutors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'favourite-tutors.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/identity-verification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'identity-verification.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/invoices' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Ake84NfZWTdq64t3',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/billing-detail' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'billing-detail.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/earning-detail' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wlhCeRWUju9om4vN',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user-withdrawal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::v5jMAf6inJbTJPR3',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/payout-status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kFMjOxsMmz23lEhp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::frQpLF1dUV5uLMCN',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/payout-method' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KLOfzvBuAJwyCOKP',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nGPU3KbpWTcoGuWi',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/booking-cart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'booking-cart.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'booking-cart.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/checkout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WAq5faP0lwLvPKPV',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/reviews' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FZDXPJl6pUIHWUTc',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dJKF8bWFuwoSRk8Q',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/reviews/received' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::04WLJG32f4RKcwqo',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/reviews/given' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::B3OcsyMixdxt2h2d',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/booking/change-to-cursando' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MmckzUA8WGf3AXSJ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/booking/change-to-aceptado' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::e1SWFJbyxFTiFc3s',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/user/bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HdGo48l0xpAm86OK',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/country-states' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FwSa3NcLXYTHjRdQ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/subject-groups' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kk4Sthm5oRICAnvH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/subjects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ocvgSCRcdK9TZxve',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::u1c3GNjuyQviboG8',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/alianzas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lxbygT7q0ZjcAmib',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/all-subjects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DeX4ODXP1GABXnAi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/verified-tutors-photos' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lPCnx1ND6NYRFMEE',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/slot-bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jggjMSPxZMX9Ymol',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/test-payment-upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mUXnVXlv1pvXVZX7',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/update-fcm-token' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VUXP55wsCV2u83E6',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/verify-email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ijJydCgEelpAg9ON',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/available-tutors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yiqdSt7te3xlW1go',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/google/url' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZEHtL57fLS7GQKd6',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/google/callback' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MyLNJu8c2ZYTetpl',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/auth/google/disconnect' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::4LJxtcwDHqDAjc17',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/google-calendar/callback' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YlfFLZqYNMRlUFcC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/google-calendar/auth-url' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::LUKuHIXGSNWq2aSF',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/google-calendar/connect' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::f3JZrd8wPlnaT806',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/google-calendar/status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::SybT3iRcIpBizr9t',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/google-calendar/events' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WQdxPOImL91HHOV1',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/google-calendar/disconnect' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::i7kmMVZhikXxHKJt',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5YkKnEzmqxJXlmVN',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payease/stripe' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payease.stripe',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/e' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'e',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/traduccion' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'traduccion',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bQnNN7OlgEG10RLQ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/prueba' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::u1TEKtPlgmeujCJW',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/google/authenticate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google.authenticate',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/auth/api/google/callback' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'google.callback',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/conferences' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'conferences.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/blogs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'blogs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/subscriptions-page' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ZQPCjb3sUxnOOA4M',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'home',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/nosotros' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'nosotros',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/como-trabajamos' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'como-trabajamos',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/preguntas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'preguntas',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/desarrolladores' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'desarrolladores',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'buscar.tutor',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/buscar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'buscar',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/modal' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'modal',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/terminos' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'terminos',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/kkkk' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'buscador.tutor',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/promociones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'promociones',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/promociones/canjear' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'coupons.canjear',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/favourite' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.favourite',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/openai/submit' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'openai.submit',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/favourite-tutor' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'favourite-tutor',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/google/callback' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::g024zDDdY7YNCQDy',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/checkout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'checkout',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.dashboard',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/payouts' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.payouts',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile/personal-details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.personal-details',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile/account-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.account-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile/courses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.courses',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile/resume/education' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.resume.education',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile/resume/experience' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.resume.experience',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile/resume/certificate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.resume.certificate',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/profile/identification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.profile.identification',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/bookings/manage-subjects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.subjects',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/bookings/manage-sessions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.manage-sessions',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/bookings/upcoming-bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.upcoming-bookings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/invoices' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.invoices',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/tutor/disputes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.disputes',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/profile/personal-details' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.profile.personal-details',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/profile/account-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.profile.account-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/profile/identification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.profile.identification',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.bookings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/invoices' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.invoices',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/favourites' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.favourites',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/certificates' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.certificate-list',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/student/disputes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.disputes',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/remove-cart' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::v2Oj7x2R7CFzLzgj',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/checkout/cancel' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'checkout.cancel',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payfast/webhook' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payfast.webhook',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/payment/success' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'post.success',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'get.success',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/switch-lang' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'switch-lang',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/switch-currency' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'switch-currency',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/exit-impersonate' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'exit-impersonate',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/social-profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'social-profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/verify-email' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.notice',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/confirm-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.confirm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/insights' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.insights',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.profile',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/manage-menus' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.manage-menus',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/blogs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.blog-listing',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/blogs/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.create-blog',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/blog-categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.blog-categories',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/taxonomies/languages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.taxonomy.languages',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/taxonomies/subjects' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.taxonomy.subjects',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/taxonomies/subject-groups' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.taxonomy.subject-groups',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/taxonomies/courses' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.taxonomy.courses',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/commission-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.commission-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/payment-methods' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.payment-methods',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/withdraw-requests' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.withdraw-requests',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.users',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/identity-verification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.identity-verification',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/bookings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.bookings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/invoices' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.invoices',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/email-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.email-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/upgrade' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.upgrade',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/upgrade/logs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.upgrade-logs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/update-sass-style' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/packages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.packages.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/packages/installed' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.packages.installed',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/packages/upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.packages.upload',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/disputes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.disputes',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/clear-cache' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.clear-cache',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/update-smtp-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.update-smtp-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/update-social-login-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.update-social-login-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/alianzas' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.alianzas.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/alianzas/create' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.alianzas.create',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/alianzas/store' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.alianzas.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/tutorias' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tutorias.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/tutors' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tutors.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/cupones' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.cupones.index',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/option-builder' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'optionbuilder',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/option-builder/update-section-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'optionbuilder.update-section-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/option-builder/reset-section-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'optionbuilder.reset-section-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/option-builder/upload-files' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'optionbuilder.upload-files',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/pages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pagebuilder',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'page.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/get-section-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pagebuilder.get-section-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/set-section-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pagebuilder.set-section-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/admin/set-page-settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pagebuilder.set-page-settings',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/get-pb-section' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pagebuilder.html',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/install/import/(migrate|general|pages|students|tutors)(*:62)|/a(?|pi/(?|s(?|t(?|art\\-chat/([^/]++)(*:106)|udent\\-reviews/([^/]++)(*:137))|lot\\-detail/([^/]++)(*:166)|end\\-message/([^/]++)(*:195)|ubject/([^/]++)/name(*:223))|chat\\-notifications/([^/]++)(*:260)|download\\-all\\-attachments/([^/]++)(*:303)|f(?|riends/([^/]++)(?|(*:333))|avourite\\-tutors/([^/]++)(*:367))|t(?|hreads/([^/]++)(?|(*:398))|utor(?|/(?|([^/]++)(?|(*:429)|/available\\-slots(*:454))|slots(?|(*:471))|([^/]++)/instant\\-slots(*:503)|availability(*:523)|([^/]++)/subjects/([^/]++)(*:557))|\\-(?|e(?|ducation/([^/]++)(?|(*:595))|xperience/([^/]++)(?|(*:625)))|certification/([^/]++)(?|(*:660)|(*:668))|subjects/(?|([^/]++)(?|(*:700))|groups(?|(*:718)|/([^/]++)/subjects(*:744))|available(*:762))|payouts/([^/]++)(*:787)|for\\-subject/([^/]++)(*:816)))|imezone/([^/]++)(?|(*:845)))|m(?|essages/([^/]++)(?|(*:878))|y\\-earning/([^/]++)(*:906))|u(?|pdate\\-password/([^/]++)(*:943)|ser/([^/]++)/(?|bookings(*:975)|tutoring\\-availability(*:1005)|profile(?|\\-(?|image(?|(*:1037))|files(*:1052))|(*:1062))))|profile\\-settings/([^/]++)(?|(*:1103))|identity\\-verification/([^/]++)(?|(*:1147))|b(?|illing\\-detail/([^/]++)(?|(*:1187))|ooking\\-cart/([^/]++)(?|(*:1221)))|reviews/(?|([^/]++)(?|(*:1254))|stats/([^/]++)(*:1278))|google\\-calendar/events/([^/]++)(*:1320))|dmin/translations/(?|source\\-translation/([^/]++)(?|(*:1382)|/delete(*:1398))|phrases/(?|([^/]++)(?|(*:1430)|/(?|edit/([^/]++)(?|(*:1459))|delete(*:1475)))|delete\\-multiple(*:1502)))|uth/([^/]++)(?|(*:1528)|/callback(*:1546)))|/livewire/preview\\-file/([^/]++)(*:1589)|/t(?|utor(?|/(?|ficha(?|/([^/]++)/([^/]++)(*:1640)|\\-(?|img/([^/]++)/([^/]++)(*:1675)|download/([^/]++)/([^/]++)(*:1710)))|bookings/session\\-detail/([^/]++)(*:1754)|manage\\-dispute/([^/]++)(*:1787)|([^/]++)(*:1804))|es/([^/]++)(*:1825))|hank\\-you/([^/]++)(*:1853))|/pay\\-qr/([^/]++)(*:1880)|/blog/([^/]++)(*:1903)|/user/identity\\-confirmation/([^/]++)(*:1949)|/student/(?|reschedule\\-session/([^/]++)(*:1998)|complete\\-booking/([^/]++)(*:2033)|manage\\-dispute/([^/]++)(*:2066))|/([^/]++)/process/payment(*:2101)|/pa(?|y/([^/]++)(*:2126)|ges/([^/]++)/iframe(*:2154))|/reset\\-password/([^/]++)(*:2189)|/verify\\-email/([^/]++)/([^/]++)(*:2230)|/admin/(?|blogs/update/([^/]++)(*:2270)|users/approve\\-identity/([^/]++)(*:2311)|manage\\-dispute/([^/]++)(*:2344)|alianzas/([^/]++)(?|/(?|edit(*:2381)|toggle\\-status(*:2404))|(*:2414))|tutor(?|ias/([^/]++)/status(*:2451)|s([^/]++)(*:2469))|pages/(?|([^/]++)(?|/edit(*:2504)|(*:2513))|create(*:2529)|([^/]++)(?|(*:2549)|/(?|build(*:2567)|store(*:2581)))))|/(.*)(*:2599)|/tutor/([^/]++)(*:2623)|/api/(.*)(*:2641))/?$}sDu',
    ),
    3 => 
    array (
      62 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'LaravelInstaller::import',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      106 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::y4u8ErfuvzE5Xd6V',
          ),
          1 => 
          array (
            0 => 'userId',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      137 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cGvsFCRUwnjd5kK3',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      166 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::96v1ifCYzCN4N5bm',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      195 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EL8C8KXCMk4N2jTh',
          ),
          1 => 
          array (
            0 => 'recipientId',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      223 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tOsENptT6U1wieki',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      260 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xL8lUx6lVOqpjcZC',
          ),
          1 => 
          array (
            0 => 'threadId',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      303 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VoTiZCE3eGoBB6PS',
          ),
          1 => 
          array (
            0 => 'threadId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      333 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'friends.show',
          ),
          1 => 
          array (
            0 => 'friend',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'friends.update',
          ),
          1 => 
          array (
            0 => 'friend',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'friends.destroy',
          ),
          1 => 
          array (
            0 => 'friend',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      367 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'favourite-tutors.update',
          ),
          1 => 
          array (
            0 => 'favourite_tutor',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      398 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'threads.show',
          ),
          1 => 
          array (
            0 => 'thread',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'threads.update',
          ),
          1 => 
          array (
            0 => 'thread',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'threads.destroy',
          ),
          1 => 
          array (
            0 => 'thread',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      429 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rNEDr7UxGzspT2TP',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      454 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dSngCteblUXuP2Uv',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      471 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::iEhw3ujFidmpjOm8',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wIkfdaSLEbS8R8s6',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      503 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bDAUecIAt9EFLm8k',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      523 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::LwvFqgtruo8UWExH',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      557 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TF5B4h37ZuUxzyeX',
          ),
          1 => 
          array (
            0 => 'tutor_id',
            1 => 'subject_id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      595 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-education.show',
          ),
          1 => 
          array (
            0 => 'tutor_education',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-education.update',
          ),
          1 => 
          array (
            0 => 'tutor_education',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-education.destroy',
          ),
          1 => 
          array (
            0 => 'tutor_education',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      625 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-experience.show',
          ),
          1 => 
          array (
            0 => 'tutor_experience',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-experience.update',
          ),
          1 => 
          array (
            0 => 'tutor_experience',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-experience.destroy',
          ),
          1 => 
          array (
            0 => 'tutor_experience',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      660 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-certification.show',
          ),
          1 => 
          array (
            0 => 'tutor_certification',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-certification.destroy',
          ),
          1 => 
          array (
            0 => 'tutor_certification',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      668 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::BiMiqk9XbyMqmsKx',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      700 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-subjects.show',
          ),
          1 => 
          array (
            0 => 'tutor_subject',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-subjects.update',
          ),
          1 => 
          array (
            0 => 'tutor_subject',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-subjects.destroy',
          ),
          1 => 
          array (
            0 => 'tutor_subject',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      718 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2OCNDJv4wSPwzCCD',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      744 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Voi7Ot2C4jTshAuo',
          ),
          1 => 
          array (
            0 => 'groupId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      762 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0hPRG2J8HVvql9xT',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      787 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::54NX9LlYaX7inm0j',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      816 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YZJlxDAeUBZ38AQT',
          ),
          1 => 
          array (
            0 => 'subject_id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      845 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1MlayS12IGNH7JJq',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::f0xz7VEomQZsaLou',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      878 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'messages.show',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'messages.update',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'messages.destroy',
          ),
          1 => 
          array (
            0 => 'message',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      906 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vBeSplYbUpOCYo9e',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      943 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::W8Uz0iXdE57wdiNz',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      975 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GqilXckVc1TWuPk8',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1005 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gwoSl2IsWogTqAZh',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1037 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::s7ajbg2CQMvP2wEQ',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::79525xYbBMX4bPOM',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1052 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ylmeQxaVbl23beJO',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1062 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NNWdU4BNhX9q13Gc',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1103 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pCdSBi5PcskErybS',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::0h3ilfPFO0B01sMK',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1147 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'identity-verification.show',
          ),
          1 => 
          array (
            0 => 'identity_verification',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'identity-verification.destroy',
          ),
          1 => 
          array (
            0 => 'identity_verification',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1187 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'billing-detail.show',
          ),
          1 => 
          array (
            0 => 'billing_detail',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'billing-detail.update',
          ),
          1 => 
          array (
            0 => 'billing_detail',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1221 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'booking-cart.show',
          ),
          1 => 
          array (
            0 => 'booking_cart',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'booking-cart.update',
          ),
          1 => 
          array (
            0 => 'booking_cart',
          ),
          2 => 
          array (
            'PUT' => 0,
            'PATCH' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'booking-cart.destroy',
          ),
          1 => 
          array (
            0 => 'booking_cart',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1254 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9EHv87YUh9VKsEI3',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::9T5KLnULaHzr6jcW',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::x2p5Mu0MpSor5HOC',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1278 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XcTBIirxW0xUmgym',
          ),
          1 => 
          array (
            0 => 'userId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1320 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eoq8PnH3m81jez0S',
          ),
          1 => 
          array (
            0 => 'eventId',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1382 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.source_translation.edit',
          ),
          1 => 
          array (
            0 => 'phrase',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.source_translation.update',
          ),
          1 => 
          array (
            0 => 'phrase',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1398 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.source_translation.delete_phrase',
          ),
          1 => 
          array (
            0 => 'phrase',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1430 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.phrases.index',
          ),
          1 => 
          array (
            0 => 'translation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1459 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.phrases.edit',
          ),
          1 => 
          array (
            0 => 'translation',
            1 => 'phrase',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.phrases.update',
          ),
          1 => 
          array (
            0 => 'translation',
            1 => 'phrase',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1475 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.translation.delete',
          ),
          1 => 
          array (
            0 => 'translation',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1502 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'ltu.translation.delete_multiple',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1528 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'social.redirect',
          ),
          1 => 
          array (
            0 => 'provider',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1546 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'social.callback',
          ),
          1 => 
          array (
            0 => 'provider',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1589 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'livewire.preview-file',
          ),
          1 => 
          array (
            0 => 'filename',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1640 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.ficha',
          ),
          1 => 
          array (
            0 => 'slug',
            1 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1675 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.ficha.img',
          ),
          1 => 
          array (
            0 => 'slug',
            1 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1710 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.ficha.download',
          ),
          1 => 
          array (
            0 => 'slug',
            1 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1754 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.bookings.session-detail',
          ),
          1 => 
          array (
            0 => 'date',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1787 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.manage-dispute',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1804 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor-detail',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1825 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1853 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'thank-you',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1880 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pay-qr',
          ),
          1 => 
          array (
            0 => 'orderId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1903 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'blog-details',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1949 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'confirm-identity',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1998 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.reschedule-session',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2033 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.complete-booking',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2066 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'student.manage-dispute',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2101 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'payment.process',
          ),
          1 => 
          array (
            0 => 'gateway',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2126 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pay',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2154 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pagebuilder.iframe',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2189 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2230 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.verify',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2270 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.update-blog',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2311 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.approve-user-identity',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2344 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.manage-dispute',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2381 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.alianzas.edit',
          ),
          1 => 
          array (
            0 => 'alianza',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2404 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.alianzas.toggle-status',
          ),
          1 => 
          array (
            0 => 'alianza',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2414 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.alianzas.update',
          ),
          1 => 
          array (
            0 => 'alianza',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'admin.alianzas.destroy',
          ),
          1 => 
          array (
            0 => 'alianza',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2451 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tutorias.updateStatus',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2469 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'admin.tutors.show',
          ),
          1 => 
          array (
            0 => 'tutor',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2504 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page.edit',
          ),
          1 => 
          array (
            0 => 'page',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2513 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page.update',
          ),
          1 => 
          array (
            0 => 'page',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2529 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page.create',
          ),
          1 => 
          array (
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2549 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'page.delete',
          ),
          1 => 
          array (
            0 => 'page',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2567 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pagebuilder.build',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2581 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pagebuilder.store-component-data',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      2599 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'pagebuilder.page',
          ),
          1 => 
          array (
            0 => 'any',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
            'POST' => 2,
            'PUT' => 3,
            'PATCH' => 4,
            'DELETE' => 5,
            'OPTIONS' => 6,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2623 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'tutor.perfil',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      2641 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2om5YEfcX6qAwiin',
          ),
          1 => 
          array (
            0 => 'fallbackPlaceholder',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'LaravelInstaller::welcome' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'install',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'install',
        ),
        'as' => 'LaravelInstaller::welcome',
        'uses' => 'Froiden\\LaravelInstaller\\Controllers\\WelcomeController@welcome',
        'controller' => 'Froiden\\LaravelInstaller\\Controllers\\WelcomeController@welcome',
        'namespace' => 'Froiden\\LaravelInstaller\\Controllers',
        'prefix' => 'install',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LaravelInstaller::environment' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'install/environment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'install',
        ),
        'as' => 'LaravelInstaller::environment',
        'uses' => 'Froiden\\LaravelInstaller\\Controllers\\EnvironmentController@environment',
        'controller' => 'Froiden\\LaravelInstaller\\Controllers\\EnvironmentController@environment',
        'namespace' => 'Froiden\\LaravelInstaller\\Controllers',
        'prefix' => 'install',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LaravelInstaller::environmentSave' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'install/environment/save',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'install',
        ),
        'as' => 'LaravelInstaller::environmentSave',
        'uses' => 'Froiden\\LaravelInstaller\\Controllers\\EnvironmentController@save',
        'controller' => 'Froiden\\LaravelInstaller\\Controllers\\EnvironmentController@save',
        'namespace' => 'Froiden\\LaravelInstaller\\Controllers',
        'prefix' => 'install',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LaravelInstaller::requirements' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'install/requirements',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'install',
        ),
        'as' => 'LaravelInstaller::requirements',
        'uses' => 'Froiden\\LaravelInstaller\\Controllers\\RequirementsController@requirements',
        'controller' => 'Froiden\\LaravelInstaller\\Controllers\\RequirementsController@requirements',
        'namespace' => 'Froiden\\LaravelInstaller\\Controllers',
        'prefix' => 'install',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LaravelInstaller::permissions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'install/permissions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'install',
        ),
        'as' => 'LaravelInstaller::permissions',
        'uses' => 'Froiden\\LaravelInstaller\\Controllers\\PermissionsController@permissions',
        'controller' => 'Froiden\\LaravelInstaller\\Controllers\\PermissionsController@permissions',
        'namespace' => 'Froiden\\LaravelInstaller\\Controllers',
        'prefix' => 'install',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LaravelInstaller::database' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'install/database',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'install',
        ),
        'as' => 'LaravelInstaller::database',
        'uses' => 'Froiden\\LaravelInstaller\\Controllers\\DatabaseController@database',
        'controller' => 'Froiden\\LaravelInstaller\\Controllers\\DatabaseController@database',
        'namespace' => 'Froiden\\LaravelInstaller\\Controllers',
        'prefix' => 'install',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LaravelInstaller::import' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'install/import/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'install',
        ),
        'as' => 'LaravelInstaller::import',
        'uses' => 'Froiden\\LaravelInstaller\\Controllers\\DatabaseController@seed',
        'controller' => 'Froiden\\LaravelInstaller\\Controllers\\DatabaseController@seed',
        'namespace' => 'Froiden\\LaravelInstaller\\Controllers',
        'prefix' => 'install',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'type' => 'migrate|general|pages|students|tutors',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'LaravelInstaller::final' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'install/final',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'install',
        ),
        'as' => 'LaravelInstaller::final',
        'uses' => 'Froiden\\LaravelInstaller\\Controllers\\FinalController@finish',
        'controller' => 'Froiden\\LaravelInstaller\\Controllers\\FinalController@finish',
        'namespace' => 'Froiden\\LaravelInstaller\\Controllers',
        'prefix' => 'install',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'laraguppy.messenger' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'messenger',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@index',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'laraguppy.messenger',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'chatapp-settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/chatapp-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
          3 => 'auth',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ProfileController@settings',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ProfileController@settings',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'chatapp-settings',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZdanzgX0R7lsdwsW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/contacts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ProfileController@contacts',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ProfileController@contacts',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::ZdanzgX0R7lsdwsW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KZskIFeVhnUGbJmH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/friend-requests',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@requests',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@requests',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::KZskIFeVhnUGbJmH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rIR3LTIhLKgBMjeu' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/blocked-friends',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@blocked',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@blocked',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::rIR3LTIhLKgBMjeu',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VFEZUFQPkUDcRkby' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/clear-chat',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@clearChat',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@clearChat',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::VFEZUFQPkUDcRkby',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::y4u8ErfuvzE5Xd6V' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/start-chat/{userId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@startChat',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@startChat',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::y4u8ErfuvzE5Xd6V',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Qm6JZRjU2qCEoJ7d' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/account-notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@toggleAccountNotifications',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@toggleAccountNotifications',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::Qm6JZRjU2qCEoJ7d',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xL8lUx6lVOqpjcZC' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/chat-notifications/{threadId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@toggleChatNotifications',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ChatActionsController@toggleChatNotifications',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::xL8lUx6lVOqpjcZC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VoTiZCE3eGoBB6PS' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/download-all-attachments/{threadId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@downloadAllAttachments',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@downloadAllAttachments',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::VoTiZCE3eGoBB6PS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'friends.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/friends',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'friends.index',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@index',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@index',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'friends.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/friends',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'friends.store',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@store',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@store',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'friends.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/friends/{friend}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'friends.show',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@show',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@show',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'friends.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/friends/{friend}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'friends.update',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@update',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@update',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'friends.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/friends/{friend}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'friends.destroy',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@destroy',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\FriendsController@destroy',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'threads.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/threads',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'threads.index',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@index',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@index',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'threads.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/threads',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'threads.store',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@store',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@store',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'threads.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/threads/{thread}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'threads.show',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@show',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@show',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'threads.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/threads/{thread}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'threads.update',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@update',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@update',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'threads.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/threads/{thread}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'threads.destroy',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@destroy',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@destroy',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ylPizUsRYo842ssL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/unread-counts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@unreadCount',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ThreadsController@unreadCount',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::ylPizUsRYo842ssL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uEYMACdncE2cQlLQ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/delivered-message',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@deliveredMessage',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@deliveredMessage',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
        'as' => 'generated::uEYMACdncE2cQlLQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'messages.index',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@index',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@index',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messages.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'messages.store',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@store',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@store',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messages.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/messages/{message}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'messages.show',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@show',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@show',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messages.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/messages/{message}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'messages.update',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@update',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@update',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'messages.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/messages/{message}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'messages.destroy',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@destroy',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\MessageController@destroy',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'guppy-user.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/guppy-user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'guppy-user.index',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ProfileController@index',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ProfileController@index',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'guppy-user.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/guppy-user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:sanctum',
          2 => 'Amentotech\\LaraGuppy\\Http\\Middleware\\UserOnline',
        ),
        'as' => 'guppy-user.store',
        'uses' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ProfileController@store',
        'controller' => 'Amentotech\\LaraGuppy\\Http\\Controllers\\ProfileController@store',
        'namespace' => NULL,
        'prefix' => '/api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eb3Uo84gi0peADtv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'POST',
        2 => 'HEAD',
      ),
      'uri' => 'broadcasting/auth',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Broadcasting\\BroadcastController@authenticate',
        'controller' => '\\Illuminate\\Broadcasting\\BroadcastController@authenticate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'excluded_middleware' => 
        array (
          0 => 'Illuminate\\Foundation\\Http\\Middleware\\VerifyCsrfToken',
        ),
        'as' => 'generated::eb3Uo84gi0peADtv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.translation.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@index',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@index',
        'as' => 'ltu.translation.index',
        'namespace' => NULL,
        'prefix' => 'admin/translations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.translation.publish' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations/publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@publish',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@publish',
        'as' => 'ltu.translation.publish',
        'namespace' => NULL,
        'prefix' => 'admin/translations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.translation.export' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/translations/publish',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@export',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@export',
        'as' => 'ltu.translation.export',
        'namespace' => NULL,
        'prefix' => 'admin/translations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.translation.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations/download',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@download',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@download',
        'as' => 'ltu.translation.download',
        'namespace' => NULL,
        'prefix' => 'admin/translations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.translation.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations/add-translation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@create',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@create',
        'as' => 'ltu.translation.create',
        'namespace' => NULL,
        'prefix' => 'admin/translations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.translation.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/translations/add-translation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@store',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@store',
        'as' => 'ltu.translation.store',
        'namespace' => NULL,
        'prefix' => 'admin/translations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.translation.import' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations/import',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@import',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@import',
        'as' => 'ltu.translation.import',
        'namespace' => NULL,
        'prefix' => 'admin/translations',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.source_translation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations/source-translation',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@index',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@index',
        'as' => 'ltu.source_translation',
        'namespace' => NULL,
        'prefix' => 'admin/translations/source-translation',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.source_translation.add_source_key' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations/source-translation/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@create',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@create',
        'as' => 'ltu.source_translation.add_source_key',
        'namespace' => NULL,
        'prefix' => 'admin/translations/source-translation',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.source_translation.store_source_key' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/translations/source-translation/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@store',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@store',
        'as' => 'ltu.source_translation.store_source_key',
        'namespace' => NULL,
        'prefix' => 'admin/translations/source-translation',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.source_translation.delete_phrases' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/translations/source-translation/delete-phrases',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@destroy_multiple',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@destroy_multiple',
        'as' => 'ltu.source_translation.delete_phrases',
        'namespace' => NULL,
        'prefix' => 'admin/translations/source-translation',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.source_translation.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations/source-translation/{phrase}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@edit',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@edit',
        'as' => 'ltu.source_translation.edit',
        'namespace' => NULL,
        'prefix' => 'admin/translations/source-translation/{phrase:uuid}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'phrase' => 'uuid',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.source_translation.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/translations/source-translation/{phrase}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@update',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@update',
        'as' => 'ltu.source_translation.update',
        'namespace' => NULL,
        'prefix' => 'admin/translations/source-translation/{phrase:uuid}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'phrase' => 'uuid',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.source_translation.delete_phrase' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/translations/source-translation/{phrase}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@destroy',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\SourcePhraseController@destroy',
        'as' => 'ltu.source_translation.delete_phrase',
        'namespace' => NULL,
        'prefix' => 'admin/translations/source-translation/{phrase:uuid}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'phrase' => 'uuid',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.phrases.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations/phrases/{translation}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\PhraseController@index',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\PhraseController@index',
        'as' => 'ltu.phrases.index',
        'namespace' => NULL,
        'prefix' => 'admin/translations/phrases/{translation}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.phrases.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/translations/phrases/{translation}/edit/{phrase}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\PhraseController@edit',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\PhraseController@edit',
        'as' => 'ltu.phrases.edit',
        'namespace' => NULL,
        'prefix' => 'admin/translations/phrases/{translation}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'phrase' => 'uuid',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.phrases.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/translations/phrases/{translation}/edit/{phrase}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\PhraseController@update',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\PhraseController@update',
        'as' => 'ltu.phrases.update',
        'namespace' => NULL,
        'prefix' => 'admin/translations/phrases/{translation}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
        'phrase' => 'uuid',
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.translation.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/translations/phrases/{translation}/delete',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@destroy',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@destroy',
        'as' => 'ltu.translation.delete',
        'namespace' => NULL,
        'prefix' => 'admin/translations/phrases/{translation}',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'ltu.translation.delete_multiple' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/translations/phrases/delete-multiple',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth',
          2 => 'role:admin',
          3 => 'Outhebox\\TranslationsUI\\Http\\Middleware\\HandleInertiaRequests',
        ),
        'uses' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@destroy_multiple',
        'controller' => 'Outhebox\\TranslationsUI\\Http\\Controllers\\TranslationController@destroy_multiple',
        'as' => 'ltu.translation.delete_multiple',
        'namespace' => NULL,
        'prefix' => 'admin/translations/phrases',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'livewire/update',
      'action' => 
      array (
        'uses' => 'Livewire\\Mechanisms\\HandleRequests\\HandleRequests@handleUpdate',
        'controller' => 'Livewire\\Mechanisms\\HandleRequests\\HandleRequests@handleUpdate',
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'livewire.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cbLAxDIHpBwN23qi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/livewire.js',
      'action' => 
      array (
        'uses' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@returnJavaScriptAsFile',
        'controller' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@returnJavaScriptAsFile',
        'as' => 'generated::cbLAxDIHpBwN23qi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::K5xrctwW7vUQ2uqV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/livewire.min.js.map',
      'action' => 
      array (
        'uses' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@maps',
        'controller' => 'Livewire\\Mechanisms\\FrontendAssets\\FrontendAssets@maps',
        'as' => 'generated::K5xrctwW7vUQ2uqV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.upload-file' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'livewire/upload-file',
      'action' => 
      array (
        'uses' => 'Livewire\\Features\\SupportFileUploads\\FileUploadController@handle',
        'controller' => 'Livewire\\Features\\SupportFileUploads\\FileUploadController@handle',
        'as' => 'livewire.upload-file',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'livewire.preview-file' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'livewire/preview-file/{filename}',
      'action' => 
      array (
        'uses' => 'Livewire\\Features\\SupportFileUploads\\FilePreviewController@handle',
        'controller' => 'Livewire\\Features\\SupportFileUploads\\FilePreviewController@handle',
        'as' => 'livewire.preview-file',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::hQT7OHeI1cbsqxYy' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@login',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@login',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::hQT7OHeI1cbsqxYy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XOftbWkmMdqYlHDP' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@register',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@register',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::XOftbWkmMdqYlHDP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::E0CEmWZqpoHglW3w' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/forget-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@resetEmailPassword',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@resetEmailPassword',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::E0CEmWZqpoHglW3w',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::QvDRbFDxTg6dbNP5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/recommended-tutors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@getRecommendedTutors',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@getRecommendedTutors',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::QvDRbFDxTg6dbNP5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::uXKt2JZODOMozJev' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/find-tutors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@findTutots',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@findTutots',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::uXKt2JZODOMozJev',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::aejY4hhaftx8sZmI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/verified-tutors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@getVerifiedTutorsWithSubjects',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@getVerifiedTutorsWithSubjects',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::aejY4hhaftx8sZmI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rNEDr7UxGzspT2TP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@getTutorDetail',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@getTutorDetail',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::rNEDr7UxGzspT2TP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VRi5LSfZnmgdmqh9' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/students-list',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\StudentController@userList',
        'controller' => 'App\\Http\\Controllers\\Api\\StudentController@userList',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::VRi5LSfZnmgdmqh9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cGvsFCRUwnjd5kK3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/student-reviews/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\StudentController@getStudentReviews',
        'controller' => 'App\\Http\\Controllers\\Api\\StudentController@getStudentReviews',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::cGvsFCRUwnjd5kK3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WWGkK4NiRonW6JVD' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-available-slots',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@getTutorAvailableSlots',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@getTutorAvailableSlots',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::WWGkK4NiRonW6JVD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::96v1ifCYzCN4N5bm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/slot-detail/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@slotDetail',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@slotDetail',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::96v1ifCYzCN4N5bm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-education.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor-education',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-education.store',
        'uses' => 'App\\Http\\Controllers\\Api\\EducationController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\EducationController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-education.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-education/{tutor_education}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-education.show',
        'uses' => 'App\\Http\\Controllers\\Api\\EducationController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\EducationController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-education.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/tutor-education/{tutor_education}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-education.update',
        'uses' => 'App\\Http\\Controllers\\Api\\EducationController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\EducationController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-education.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/tutor-education/{tutor_education}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-education.destroy',
        'uses' => 'App\\Http\\Controllers\\Api\\EducationController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\EducationController@destroy',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-experience.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor-experience',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-experience.store',
        'uses' => 'App\\Http\\Controllers\\Api\\ExperienceController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\ExperienceController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-experience.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-experience/{tutor_experience}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-experience.show',
        'uses' => 'App\\Http\\Controllers\\Api\\ExperienceController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\ExperienceController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-experience.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/tutor-experience/{tutor_experience}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-experience.update',
        'uses' => 'App\\Http\\Controllers\\Api\\ExperienceController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\ExperienceController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-experience.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/tutor-experience/{tutor_experience}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-experience.destroy',
        'uses' => 'App\\Http\\Controllers\\Api\\ExperienceController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\ExperienceController@destroy',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-certification.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor-certification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-certification.store',
        'uses' => 'App\\Http\\Controllers\\Api\\CertificationController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\CertificationController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-certification.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-certification/{tutor_certification}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-certification.show',
        'uses' => 'App\\Http\\Controllers\\Api\\CertificationController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\CertificationController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-certification.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/tutor-certification/{tutor_certification}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-certification.destroy',
        'uses' => 'App\\Http\\Controllers\\Api\\CertificationController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\CertificationController@destroy',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-subjects.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-subjects.index',
        'uses' => 'App\\Http\\Controllers\\Api\\UserSubjectController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\UserSubjectController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-subjects.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor-subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-subjects.store',
        'uses' => 'App\\Http\\Controllers\\Api\\UserSubjectController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\UserSubjectController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-subjects.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-subjects/{tutor_subject}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-subjects.show',
        'uses' => 'App\\Http\\Controllers\\Api\\UserSubjectController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\UserSubjectController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-subjects.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/tutor-subjects/{tutor_subject}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-subjects.update',
        'uses' => 'App\\Http\\Controllers\\Api\\UserSubjectController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\UserSubjectController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-subjects.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/tutor-subjects/{tutor_subject}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'as' => 'tutor-subjects.destroy',
        'uses' => 'App\\Http\\Controllers\\Api\\UserSubjectController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\UserSubjectController@destroy',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jDq6pxmTiJxnHYvr' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/countries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TaxonomiesController@getCountries',
        'controller' => 'App\\Http\\Controllers\\Api\\TaxonomiesController@getCountries',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::jDq6pxmTiJxnHYvr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GgCHGecGcjJfHoTf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/languages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TaxonomiesController@getLanguages',
        'controller' => 'App\\Http\\Controllers\\Api\\TaxonomiesController@getLanguages',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::GgCHGecGcjJfHoTf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ogkbKgOrsIndSp8N' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/states',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TaxonomiesController@getStates',
        'controller' => 'App\\Http\\Controllers\\Api\\TaxonomiesController@getStates',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ogkbKgOrsIndSp8N',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HawYEXVH0ti4TsI3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/subject-slots',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\SubjectSlotController@getUserSubjectSlots',
        'controller' => 'App\\Http\\Controllers\\Api\\SubjectSlotController@getUserSubjectSlots',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::HawYEXVH0ti4TsI3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::RMnkKet5DbVLqCFm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/upcoming-bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BookingController@getUpComingBooking',
        'controller' => 'App\\Http\\Controllers\\Api\\BookingController@getUpComingBooking',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::RMnkKet5DbVLqCFm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::BiMiqk9XbyMqmsKx' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor-certification/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CertificationController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\CertificationController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::BiMiqk9XbyMqmsKx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::czYv1qypES1MQRli' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/reset-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@resetPassword',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@resetPassword',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::czYv1qypES1MQRli',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::W8Uz0iXdE57wdiNz' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/update-password/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AccountSettingController@updatePassword',
        'controller' => 'App\\Http\\Controllers\\Api\\AccountSettingController@updatePassword',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::W8Uz0iXdE57wdiNz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1MlayS12IGNH7JJq' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/timezone/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AccountSettingController@updateTimezone',
        'controller' => 'App\\Http\\Controllers\\Api\\AccountSettingController@updateTimezone',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::1MlayS12IGNH7JJq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::f0xz7VEomQZsaLou' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/timezone/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AccountSettingController@getTimezone',
        'controller' => 'App\\Http\\Controllers\\Api\\AccountSettingController@getTimezone',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::f0xz7VEomQZsaLou',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EL8C8KXCMk4N2jTh' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/send-message/{recipientId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\StudentController@sendMessage',
        'controller' => 'App\\Http\\Controllers\\Api\\StudentController@sendMessage',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::EL8C8KXCMk4N2jTh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DbSGFfAfLEqQfWV7' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/resend-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@resendEmail',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@resendEmail',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::DbSGFfAfLEqQfWV7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dkmTwDgCGLZ2L7oN' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@logout',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@logout',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::dkmTwDgCGLZ2L7oN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'favourite-tutors.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/favourite-tutors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'favourite-tutors.index',
        'uses' => 'App\\Http\\Controllers\\Api\\FavouriteTutorController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\FavouriteTutorController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'favourite-tutors.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/favourite-tutors/{favourite_tutor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'favourite-tutors.update',
        'uses' => 'App\\Http\\Controllers\\Api\\FavouriteTutorController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\FavouriteTutorController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pCdSBi5PcskErybS' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/profile-settings/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProfileController@updateProfile',
        'controller' => 'App\\Http\\Controllers\\Api\\ProfileController@updateProfile',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::pCdSBi5PcskErybS',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0h3ilfPFO0B01sMK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/profile-settings/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProfileController@getProfile',
        'controller' => 'App\\Http\\Controllers\\Api\\ProfileController@getProfile',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::0h3ilfPFO0B01sMK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'identity-verification.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/identity-verification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'identity-verification.store',
        'uses' => 'App\\Http\\Controllers\\Api\\IdentityController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\IdentityController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'identity-verification.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/identity-verification/{identity_verification}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'identity-verification.show',
        'uses' => 'App\\Http\\Controllers\\Api\\IdentityController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\IdentityController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'identity-verification.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/identity-verification/{identity_verification}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'identity-verification.destroy',
        'uses' => 'App\\Http\\Controllers\\Api\\IdentityController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\IdentityController@destroy',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Ake84NfZWTdq64t3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/invoices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\InvoiceController@getInvoices',
        'controller' => 'App\\Http\\Controllers\\Api\\InvoiceController@getInvoices',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::Ake84NfZWTdq64t3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'billing-detail.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/billing-detail',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'billing-detail.store',
        'uses' => 'App\\Http\\Controllers\\Api\\BillingDetailController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\BillingDetailController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'billing-detail.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/billing-detail/{billing_detail}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'billing-detail.show',
        'uses' => 'App\\Http\\Controllers\\Api\\BillingDetailController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\BillingDetailController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'billing-detail.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/billing-detail/{billing_detail}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'billing-detail.update',
        'uses' => 'App\\Http\\Controllers\\Api\\BillingDetailController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\BillingDetailController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::54NX9LlYaX7inm0j' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-payouts/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\PayoutController@getPayoutHistory',
        'controller' => 'App\\Http\\Controllers\\Api\\PayoutController@getPayoutHistory',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::54NX9LlYaX7inm0j',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vBeSplYbUpOCYo9e' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/my-earning/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\PayoutController@getEarning',
        'controller' => 'App\\Http\\Controllers\\Api\\PayoutController@getEarning',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::vBeSplYbUpOCYo9e',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wlhCeRWUju9om4vN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/earning-detail',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\PayoutController@getEarningDetail',
        'controller' => 'App\\Http\\Controllers\\Api\\PayoutController@getEarningDetail',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::wlhCeRWUju9om4vN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::v5jMAf6inJbTJPR3' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/user-withdrawal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\PayoutController@userWithdrawal',
        'controller' => 'App\\Http\\Controllers\\Api\\PayoutController@userWithdrawal',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::v5jMAf6inJbTJPR3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kFMjOxsMmz23lEhp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/payout-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\PayoutController@getPayoutStatus',
        'controller' => 'App\\Http\\Controllers\\Api\\PayoutController@getPayoutStatus',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::kFMjOxsMmz23lEhp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::frQpLF1dUV5uLMCN' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/payout-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\PayoutController@updateStatus',
        'controller' => 'App\\Http\\Controllers\\Api\\PayoutController@updateStatus',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::frQpLF1dUV5uLMCN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KLOfzvBuAJwyCOKP' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/payout-method',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\PayoutController@addPayoutMethod',
        'controller' => 'App\\Http\\Controllers\\Api\\PayoutController@addPayoutMethod',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::KLOfzvBuAJwyCOKP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nGPU3KbpWTcoGuWi' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/payout-method',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\PayoutController@removePayoutMethod',
        'controller' => 'App\\Http\\Controllers\\Api\\PayoutController@removePayoutMethod',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::nGPU3KbpWTcoGuWi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'booking-cart.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/booking-cart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'booking-cart.index',
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'booking-cart.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/booking-cart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'booking-cart.store',
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'booking-cart.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/booking-cart/{booking_cart}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'booking-cart.show',
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'booking-cart.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
        1 => 'PATCH',
      ),
      'uri' => 'api/booking-cart/{booking_cart}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'booking-cart.update',
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'booking-cart.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/booking-cart/{booking_cart}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'as' => 'booking-cart.destroy',
        'uses' => 'App\\Http\\Controllers\\Api\\CartController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\CartController@destroy',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WAq5faP0lwLvPKPV' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/checkout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CheckoutController@addCheckoutDetails',
        'controller' => 'App\\Http\\Controllers\\Api\\CheckoutController@addCheckoutDetails',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::WAq5faP0lwLvPKPV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FZDXPJl6pUIHWUTc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::FZDXPJl6pUIHWUTc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::04WLJG32f4RKcwqo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/reviews/received',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@getReceivedReviews',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@getReceivedReviews',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::04WLJG32f4RKcwqo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::B3OcsyMixdxt2h2d' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/reviews/given',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@getUserReviews',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@getUserReviews',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::B3OcsyMixdxt2h2d',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dJKF8bWFuwoSRk8Q' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@store',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::dJKF8bWFuwoSRk8Q',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9EHv87YUh9VKsEI3' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/reviews/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@show',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::9EHv87YUh9VKsEI3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::9T5KLnULaHzr6jcW' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/reviews/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@update',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::9T5KLnULaHzr6jcW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::x2p5Mu0MpSor5HOC' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/reviews/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@destroy',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::x2p5Mu0MpSor5HOC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XcTBIirxW0xUmgym' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/reviews/stats/{userId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@getStats',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@getStats',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::XcTBIirxW0xUmgym',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MmckzUA8WGf3AXSJ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/booking/change-to-cursando',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BookingStatusController@changeToCursando',
        'controller' => 'App\\Http\\Controllers\\Api\\BookingStatusController@changeToCursando',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::MmckzUA8WGf3AXSJ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::e1SWFJbyxFTiFc3s' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/booking/change-to-aceptado',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BookingStatusController@changeToAceptado',
        'controller' => 'App\\Http\\Controllers\\Api\\BookingStatusController@changeToAceptado',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::e1SWFJbyxFTiFc3s',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dSngCteblUXuP2Uv' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor/{id}/available-slots',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\SubjectSlotController@getTutorAvailableSlots',
        'controller' => 'App\\Http\\Controllers\\Api\\SubjectSlotController@getTutorAvailableSlots',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::dSngCteblUXuP2Uv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::iEhw3ujFidmpjOm8' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor/slots',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\SubjectSlotController@createUserSubjectSlot',
        'controller' => 'App\\Http\\Controllers\\Api\\SubjectSlotController@createUserSubjectSlot',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::iEhw3ujFidmpjOm8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wIkfdaSLEbS8R8s6' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/tutor/slots',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\SubjectSlotController@deleteUserSubjectSlot',
        'controller' => 'App\\Http\\Controllers\\Api\\SubjectSlotController@deleteUserSubjectSlot',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::wIkfdaSLEbS8R8s6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HdGo48l0xpAm86OK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BookingController@getUpComingBooking',
        'controller' => 'App\\Http\\Controllers\\Api\\BookingController@getUpComingBooking',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::HdGo48l0xpAm86OK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FwSa3NcLXYTHjRdQ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/country-states',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@getStates',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@getStates',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::FwSa3NcLXYTHjRdQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kk4Sthm5oRICAnvH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/subject-groups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BookingController@getSubjectGroups',
        'controller' => 'App\\Http\\Controllers\\Api\\BookingController@getSubjectGroups',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::kk4Sthm5oRICAnvH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ocvgSCRcdK9TZxve' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BookingController@getSubjects',
        'controller' => 'App\\Http\\Controllers\\Api\\BookingController@getSubjects',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ocvgSCRcdK9TZxve',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::u1c3GNjuyQviboG8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\OptionBuilderController@getOpSettings',
        'controller' => 'App\\Http\\Controllers\\Api\\OptionBuilderController@getOpSettings',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::u1c3GNjuyQviboG8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lxbygT7q0ZjcAmib' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/alianzas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AlianzaController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\AlianzaController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::lxbygT7q0ZjcAmib',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DeX4ODXP1GABXnAi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/all-subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\SubjectController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\SubjectController@index',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::DeX4ODXP1GABXnAi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lPCnx1ND6NYRFMEE' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/verified-tutors-photos',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@getVerifiedTutorsPhotos',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@getVerifiedTutorsPhotos',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::lPCnx1ND6NYRFMEE',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bDAUecIAt9EFLm8k' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor/{id}/instant-slots',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@getInstantSlots',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@getInstantSlots',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::bDAUecIAt9EFLm8k',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GqilXckVc1TWuPk8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user/{id}/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BookingController@getUserBookingsById',
        'controller' => 'App\\Http\\Controllers\\Api\\BookingController@getUserBookingsById',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::GqilXckVc1TWuPk8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jggjMSPxZMX9Ymol' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/slot-bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BookingController@storeSlotBooking',
        'controller' => 'App\\Http\\Controllers\\Api\\BookingController@storeSlotBooking',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::jggjMSPxZMX9Ymol',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mUXnVXlv1pvXVZX7' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/test-payment-upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BookingController@storePaymentSlotBooking',
        'controller' => 'App\\Http\\Controllers\\Api\\BookingController@storePaymentSlotBooking',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::mUXnVXlv1pvXVZX7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VUXP55wsCV2u83E6' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/update-fcm-token',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@updateFcmToken',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@updateFcmToken',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::VUXP55wsCV2u83E6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ijJydCgEelpAg9ON' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/verify-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@verifyEmail',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@verifyEmail',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ijJydCgEelpAg9ON',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::LwvFqgtruo8UWExH' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/tutor/availability',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@updateTutoringAvailability',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@updateTutoringAvailability',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::LwvFqgtruo8UWExH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gwoSl2IsWogTqAZh' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/user/{id}/tutoring-availability',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@updateTutoringAvailability',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@updateTutoringAvailability',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::gwoSl2IsWogTqAZh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yiqdSt7te3xlW1go' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/available-tutors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@getAvailableTutors',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@getAvailableTutors',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::yiqdSt7te3xlW1go',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YZJlxDAeUBZ38AQT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-for-subject/{subject_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\TutorController@getTutorForSubject',
        'controller' => 'App\\Http\\Controllers\\Api\\TutorController@getTutorForSubject',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::YZJlxDAeUBZ38AQT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::s7ajbg2CQMvP2wEQ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/user/{id}/profile-image',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProfileController@getProfileImage',
        'controller' => 'App\\Http\\Controllers\\Api\\ProfileController@getProfileImage',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::s7ajbg2CQMvP2wEQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::79525xYbBMX4bPOM' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/user/{id}/profile-image',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProfileController@updateProfileImage',
        'controller' => 'App\\Http\\Controllers\\Api\\ProfileController@updateProfileImage',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::79525xYbBMX4bPOM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ylmeQxaVbl23beJO' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/user/{id}/profile-files',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProfileController@updateUserProfileFiles',
        'controller' => 'App\\Http\\Controllers\\Api\\ProfileController@updateUserProfileFiles',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::ylmeQxaVbl23beJO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NNWdU4BNhX9q13Gc' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/user/{id}/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProfileController@updateUserProfile',
        'controller' => 'App\\Http\\Controllers\\Api\\ProfileController@updateUserProfile',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::NNWdU4BNhX9q13Gc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tOsENptT6U1wieki' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/subject/{id}/name',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\SubjectController@getSubjectName',
        'controller' => 'App\\Http\\Controllers\\Api\\SubjectController@getSubjectName',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::tOsENptT6U1wieki',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2OCNDJv4wSPwzCCD' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-subjects/groups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\UserSubjectController@getSubjectGroups',
        'controller' => 'App\\Http\\Controllers\\Api\\UserSubjectController@getSubjectGroups',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::2OCNDJv4wSPwzCCD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Voi7Ot2C4jTshAuo' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-subjects/groups/{groupId}/subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\UserSubjectController@getSubjectsByGroup',
        'controller' => 'App\\Http\\Controllers\\Api\\UserSubjectController@getSubjectsByGroup',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::Voi7Ot2C4jTshAuo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::0hPRG2J8HVvql9xT' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/tutor-subjects/available',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\UserSubjectController@getAvailableSubjects',
        'controller' => 'App\\Http\\Controllers\\Api\\UserSubjectController@getAvailableSubjects',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::0hPRG2J8HVvql9xT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::TF5B4h37ZuUxzyeX' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/tutor/{tutor_id}/subjects/{subject_id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\UserSubjectController@removeTutorSubject',
        'controller' => 'App\\Http\\Controllers\\Api\\UserSubjectController@removeTutorSubject',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::TF5B4h37ZuUxzyeX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZEHtL57fLS7GQKd6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/auth/google/url',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleAuthController@getGoogleAuthUrl',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleAuthController@getGoogleAuthUrl',
        'namespace' => NULL,
        'prefix' => 'api/auth/google',
        'where' => 
        array (
        ),
        'as' => 'generated::ZEHtL57fLS7GQKd6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MyLNJu8c2ZYTetpl' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/google/callback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleAuthController@handleGoogleCallback',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleAuthController@handleGoogleCallback',
        'namespace' => NULL,
        'prefix' => 'api/auth/google',
        'where' => 
        array (
        ),
        'as' => 'generated::MyLNJu8c2ZYTetpl',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::4LJxtcwDHqDAjc17' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/auth/google/disconnect',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleAuthController@disconnectGoogle',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleAuthController@disconnectGoogle',
        'namespace' => NULL,
        'prefix' => 'api/auth/google',
        'where' => 
        array (
        ),
        'as' => 'generated::4LJxtcwDHqDAjc17',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YlfFLZqYNMRlUFcC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/google-calendar/callback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@handleCallback',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@handleCallback',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::YlfFLZqYNMRlUFcC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::LUKuHIXGSNWq2aSF' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/google-calendar/auth-url',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@getAuthUrl',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@getAuthUrl',
        'namespace' => NULL,
        'prefix' => 'api/google-calendar',
        'where' => 
        array (
        ),
        'as' => 'generated::LUKuHIXGSNWq2aSF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::f3JZrd8wPlnaT806' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/google-calendar/connect',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@connectCalendar',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@connectCalendar',
        'namespace' => NULL,
        'prefix' => 'api/google-calendar',
        'where' => 
        array (
        ),
        'as' => 'generated::f3JZrd8wPlnaT806',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::SybT3iRcIpBizr9t' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/google-calendar/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@getConnectionStatus',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@getConnectionStatus',
        'namespace' => NULL,
        'prefix' => 'api/google-calendar',
        'where' => 
        array (
        ),
        'as' => 'generated::SybT3iRcIpBizr9t',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WQdxPOImL91HHOV1' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/google-calendar/events',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@createEvent',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@createEvent',
        'namespace' => NULL,
        'prefix' => 'api/google-calendar',
        'where' => 
        array (
        ),
        'as' => 'generated::WQdxPOImL91HHOV1',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eoq8PnH3m81jez0S' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/google-calendar/events/{eventId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@deleteEvent',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@deleteEvent',
        'namespace' => NULL,
        'prefix' => 'api/google-calendar',
        'where' => 
        array (
        ),
        'as' => 'generated::eoq8PnH3m81jez0S',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::i7kmMVZhikXxHKJt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/google-calendar/disconnect',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@disconnect',
        'controller' => 'App\\Http\\Controllers\\Api\\GoogleCalendarController@disconnect',
        'namespace' => NULL,
        'prefix' => 'api/google-calendar',
        'where' => 
        array (
        ),
        'as' => 'generated::i7kmMVZhikXxHKJt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2om5YEfcX6qAwiin' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/{fallbackPlaceholder}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:173:"function () {
    return \\response()->json([
        \'message\' => \\__(\'general.api_url_not_found\'),
    ], \\Symfony\\Component\\HttpFoundation\\Response::HTTP_NOT_FOUND);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000012340000000000000000";}}',
        'namespace' => NULL,
        'prefix' => 'api',
        'where' => 
        array (
        ),
        'as' => 'generated::2om5YEfcX6qAwiin',
      ),
      'fallback' => true,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'fallbackPlaceholder' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5YkKnEzmqxJXlmVN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:829:"function () {
                    $exception = null;

                    try {
                        \\Illuminate\\Support\\Facades\\Event::dispatch(new \\Illuminate\\Foundation\\Events\\DiagnosingHealth);
                    } catch (\\Throwable $e) {
                        if (app()->hasDebugModeEnabled()) {
                            throw $e;
                        }

                        report($e);

                        $exception = $e->getMessage();
                    }

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'C:\\\\laragon\\\\www\\\\ClassGoweb\\\\vendor\\\\laravel\\\\framework\\\\src\\\\Illuminate\\\\Foundation\\\\Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"00000000000012ea0000000000000000";}}',
        'as' => 'generated::5YkKnEzmqxJXlmVN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payease.stripe' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'payease/stripe',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'Modules\\LaraPayease\\Http\\Controllers\\StripePaymentController@prepareCharge',
        'controller' => 'Modules\\LaraPayease\\Http\\Controllers\\StripePaymentController@prepareCharge',
        'namespace' => 'Modules\\LaraPayease\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'payease.stripe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'e' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'e',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'e',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'vistas.view.pages.e',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'traduccion' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'traduccion',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'traduccion',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'vistas.view.pages.traduccion',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bQnNN7OlgEG10RLQ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:1369:"function (\\Illuminate\\Http\\Request $request) {
    $id = $request->query(\'id\');
    $hash = $request->query(\'hash\');
    $status = null;
    $message = null;
    $redirect = null;

    if ($id && $hash) {
        $user = \\App\\Models\\User::find($id);
        if ($user && \\hash_equals($hash, \\sha1($user->email))) {
            if (!$user->email_verified_at) {
                $user->email_verified_at = \\now();
                $user->save();
                $status = \'success\';
                $message = \'Correo verificado correctamente.\';
            } else {
                $status = \'info\';
                $message = \'El correo ya estaba verificado.\';
            }
            // Redirección según el rol
            if ($user->hasRole(\'tutor\')) {
                $redirect = \\url(\'/tutor/dashboard\');
            } elseif ($user->hasRole(\'student\')) {
                $redirect = \\url(\'/student/bookings\');
            }
        } else {
            $status = \'error\';
            $message = \'El enlace de verificación no es válido.\';
        }
    } else {
        $status = \'error\';
        $message = \'Parámetros inválidos.\';
    }

    return \\view(\'verify\', [
        \'status\' => $status,
        \'message\' => $message,
        \'redirect\' => $redirect,
        \'id\' => $id,
        \'hash\' => $hash,
    ]);
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000012450000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::bQnNN7OlgEG10RLQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::u1TEKtPlgmeujCJW' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'prueba',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:61:"function () {
    return \'¡Ruta de prueba funcionando!\';
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000012470000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::u1TEKtPlgmeujCJW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.ficha' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/ficha/{slug}/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ExportImageController@index',
        'controller' => 'App\\Http\\Controllers\\ExportImageController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'tutor.ficha',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.ficha.img' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/ficha-img/{slug}/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ExportImageController@exportFicha',
        'controller' => 'App\\Http\\Controllers\\ExportImageController@exportFicha',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'tutor.ficha.img',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.ficha.download' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/ficha-download/{slug}/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ExportImageController@downloadFicha',
        'controller' => 'App\\Http\\Controllers\\ExportImageController@downloadFicha',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'tutor.ficha.download',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'social.redirect' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'auth/{provider}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\SocialController@redirect',
        'controller' => 'App\\Http\\Controllers\\Auth\\SocialController@redirect',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'social.redirect',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'social.callback' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'auth/{provider}/callback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\SocialController@callback',
        'controller' => 'App\\Http\\Controllers\\Auth\\SocialController@callback',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'social.callback',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pay-qr' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'pay-qr/{orderId}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\PaymentController@showQR',
        'controller' => 'App\\Http\\Controllers\\PaymentController@showQR',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'pay-qr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google.authenticate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'google/authenticate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleController@authenticate',
        'controller' => 'App\\Http\\Controllers\\GoogleController@authenticate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'google.authenticate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'google.callback' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'auth/api/google/callback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\GoogleController@googlecallback',
        'controller' => 'App\\Http\\Controllers\\GoogleController@googlecallback',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'google.callback',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'conferences.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'conferences',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\ConferencesController@index',
        'controller' => 'App\\Http\\Controllers\\ConferencesController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'conferences.index',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'blogs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blogs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Livewire\\Frontend\\Blogs@__invoke',
        'controller' => 'App\\Livewire\\Frontend\\Blogs',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'blogs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'blog-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'blog/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Livewire\\Frontend\\BlogDetails@__invoke',
        'controller' => 'App\\Livewire\\Frontend\\BlogDetails',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'blog-details',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ZQPCjb3sUxnOOA4M' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'subscriptions-page',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::ZQPCjb3sUxnOOA4M',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'subscriptions-page',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'home' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '/',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\HomeController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'home',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'nosotros' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'nosotros',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@nosotros',
        'controller' => 'App\\Http\\Controllers\\HomeController@nosotros',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'nosotros',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'como-trabajamos' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'como-trabajamos',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'como-trabajamos',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'vistas.view.pages.trabajamos',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'preguntas' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'preguntas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'preguntas',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'vistas.view.pages.preguntas',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutores/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@tutor',
        'controller' => 'App\\Http\\Controllers\\HomeController@tutor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'tutor',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'desarrolladores' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'desarrolladores',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'desarrolladores',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'vistas.view.pages.desarrolladores',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'buscar.tutor' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@buscarTutor',
        'controller' => 'App\\Http\\Controllers\\HomeController@buscarTutor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'buscar.tutor',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'buscar' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'buscar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\HomeController@buscar',
        'controller' => 'App\\Http\\Controllers\\HomeController@buscar',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'buscar',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'modal' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'modal',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'modal',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'vistas.view.pages.modals.modal-reserva',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'terminos' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'terminos',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => '\\Illuminate\\Routing\\ViewController@__invoke',
        'controller' => '\\Illuminate\\Routing\\ViewController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'terminos',
      ),
      'fallback' => false,
      'defaults' => 
      array (
        'view' => 'vistas.view.pages.terminos',
        'data' => 
        array (
        ),
        'status' => 200,
        'headers' => 
        array (
        ),
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'buscador.tutor' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'kkkk',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Livewire\\BuscadorTutor@__invoke',
        'controller' => 'App\\Livewire\\BuscadorTutor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'buscador.tutor',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'promociones' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'promociones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\PromocionesController@index',
        'controller' => 'App\\Http\\Controllers\\PromocionesController@index',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'promociones',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'coupons.canjear' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'promociones/canjear',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
        ),
        'uses' => 'App\\Http\\Controllers\\PromocionesController@canjear',
        'controller' => 'App\\Http\\Controllers\\PromocionesController@canjear',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'coupons.canjear',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.favourite' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'tutor/favourite',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\SearchController@favouriteTutor',
        'controller' => 'App\\Http\\Controllers\\Frontend\\SearchController@favouriteTutor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'tutor.favourite',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'openai.submit' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'openai/submit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
        ),
        'uses' => 'App\\Http\\Controllers\\OpenAiController@submit',
        'controller' => 'App\\Http\\Controllers\\OpenAiController@submit',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'openai.submit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'favourite-tutor' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'favourite-tutor',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\SearchController@favouriteTutor',
        'controller' => 'App\\Http\\Controllers\\Frontend\\SearchController@favouriteTutor',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'favourite-tutor',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@logout',
        'controller' => 'App\\Http\\Controllers\\SiteController@logout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'confirm-identity' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/identity-confirmation/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\PersonalDetails@confirmParentVerification',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\PersonalDetails@confirmParentVerification',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'confirm-identity',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::g024zDDdY7YNCQDy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'google/callback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@getGoogleToken',
        'controller' => 'App\\Http\\Controllers\\SiteController@getGoogleToken',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::g024zDDdY7YNCQDy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'checkout' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'checkout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Frontend\\Checkout@__invoke',
        'controller' => 'App\\Livewire\\Frontend\\Checkout',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'checkout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'thank-you' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'thank-you/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Frontend\\ThankYou@__invoke',
        'controller' => 'App\\Livewire\\Frontend\\ThankYou',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'thank-you',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.dashboard' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Tutor\\ManageAccount\\ManageAccount@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Tutor\\ManageAccount\\ManageAccount',
        'as' => 'tutor.dashboard',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.payouts' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/payouts',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Payouts@__invoke',
        'controller' => 'App\\Livewire\\Payouts',
        'as' => 'tutor.payouts',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:51:"fn() => \\redirect(\'tutor.profile.personal-details\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000012720000000000000000";}}',
        'as' => 'tutor.profile',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.personal-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/profile/personal-details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\PersonalDetails@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\PersonalDetails',
        'as' => 'tutor.profile.personal-details',
        'namespace' => NULL,
        'prefix' => 'tutor/profile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.account-settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/profile/account-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\AccountSettings@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\AccountSettings',
        'as' => 'tutor.profile.account-settings',
        'namespace' => NULL,
        'prefix' => 'tutor/profile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.courses' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/profile/courses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Tutor\\CompanyCourses\\Courses@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Tutor\\CompanyCourses\\Courses',
        'as' => 'tutor.profile.courses',
        'namespace' => NULL,
        'prefix' => 'tutor/profile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.resume.education' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/profile/resume/education',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\Resume@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\Resume',
        'as' => 'tutor.profile.resume.education',
        'namespace' => NULL,
        'prefix' => 'tutor/profile/resume',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.resume.experience' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/profile/resume/experience',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\Resume@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\Resume',
        'as' => 'tutor.profile.resume.experience',
        'namespace' => NULL,
        'prefix' => 'tutor/profile/resume',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.resume.certificate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/profile/resume/certificate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\Resume@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\Resume',
        'as' => 'tutor.profile.resume.certificate',
        'namespace' => NULL,
        'prefix' => 'tutor/profile/resume',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.profile.identification' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/profile/identification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\IdentityVerification@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\IdentityVerification',
        'as' => 'tutor.profile.identification',
        'namespace' => NULL,
        'prefix' => 'tutor/profile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.subjects' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/bookings/manage-subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Tutor\\ManageSessions\\ManageSubjects@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Tutor\\ManageSessions\\ManageSubjects',
        'as' => 'tutor.bookings.subjects',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.manage-sessions' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/bookings/manage-sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Tutor\\ManageSessions\\MyCalendar@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Tutor\\ManageSessions\\MyCalendar',
        'as' => 'tutor.bookings.manage-sessions',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.session-detail' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/bookings/session-detail/{date}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Tutor\\ManageSessions\\SessionDetail@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Tutor\\ManageSessions\\SessionDetail',
        'as' => 'tutor.bookings.session-detail',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.bookings.upcoming-bookings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/bookings/upcoming-bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\Bookings\\UserBooking@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\Bookings\\UserBooking',
        'as' => 'tutor.bookings.upcoming-bookings',
        'namespace' => NULL,
        'prefix' => 'tutor/bookings',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.invoices' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/invoices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Student\\Invoices@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Student\\Invoices',
        'as' => 'tutor.invoices',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.disputes' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/disputes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\Dispute\\Dispute@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\Dispute\\Dispute',
        'as' => 'tutor.disputes',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.manage-dispute' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/manage-dispute/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'role:tutor',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\Dispute\\ManageDispute@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\Dispute\\ManageDispute',
        'as' => 'tutor.manage-dispute',
        'namespace' => NULL,
        'prefix' => '/tutor',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:51:"fn() => \\redirect(\'tutor.profile.personal-details\')";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000012820000000000000000";}}',
        'as' => 'student.profile',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.profile.personal-details' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/profile/personal-details',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\PersonalDetails@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\PersonalDetails',
        'as' => 'student.profile.personal-details',
        'namespace' => NULL,
        'prefix' => 'student/profile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.profile.account-settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/profile/account-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\AccountSettings@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\AccountSettings',
        'as' => 'student.profile.account-settings',
        'namespace' => NULL,
        'prefix' => 'student/profile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.profile.identification' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/profile/identification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\IdentityVerification@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\ProfileSettings\\IdentityVerification',
        'as' => 'student.profile.identification',
        'namespace' => NULL,
        'prefix' => 'student/profile',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.bookings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\Bookings\\UserBooking@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\Bookings\\UserBooking',
        'as' => 'student.bookings',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.invoices' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/invoices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Student\\Invoices@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Student\\Invoices',
        'as' => 'student.invoices',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.favourites' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/favourites',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Student\\Favourite\\Favourites@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Student\\Favourite\\Favourites',
        'as' => 'student.favourites',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.reschedule-session' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/reschedule-session/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Student\\RescheduleSession@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Student\\RescheduleSession',
        'as' => 'student.reschedule-session',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.complete-booking' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/complete-booking/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@completeBooking',
        'controller' => 'App\\Http\\Controllers\\SiteController@completeBooking',
        'as' => 'student.complete-booking',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.certificate-list' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/certificates',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Student\\CertificateList@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Student\\CertificateList',
        'as' => 'student.certificate-list',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.disputes' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/disputes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\Dispute\\Dispute@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\Dispute\\Dispute',
        'as' => 'student.disputes',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'student.manage-dispute' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'student/manage-dispute/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'onlineUser',
          6 => 'student',
        ),
        'uses' => 'App\\Livewire\\Pages\\Common\\Dispute\\ManageDispute@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Common\\Dispute\\ManageDispute',
        'as' => 'student.manage-dispute',
        'namespace' => NULL,
        'prefix' => '/student',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::v2Oj7x2R7CFzLzgj' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'remove-cart',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@removeCart',
        'controller' => 'App\\Http\\Controllers\\SiteController@removeCart',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::v2Oj7x2R7CFzLzgj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor-detail' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\Frontend\\SearchController@tutorDetail',
        'controller' => 'App\\Http\\Controllers\\Frontend\\SearchController@tutorDetail',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'tutor-detail',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payment.process' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '{gateway}/process/payment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@processPayment',
        'controller' => 'App\\Http\\Controllers\\SiteController@processPayment',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'payment.process',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'checkout.cancel' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'checkout/cancel',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:101:"fn() => \\redirect()->route(\'invoices\')->with(\'payment_cancel\', \\__(\'general.payment_cancelled_desc\'))";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"000000000000126d0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'checkout.cancel',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'payfast.webhook' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'payfast/webhook',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@payfastWebhook',
        'controller' => 'App\\Http\\Controllers\\SiteController@payfastWebhook',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'payfast.webhook',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'post.success' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'payment/success',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@paymentSuccess',
        'controller' => 'App\\Http\\Controllers\\SiteController@paymentSuccess',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'post.success',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'get.success' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'payment/success',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@paymentSuccess',
        'controller' => 'App\\Http\\Controllers\\SiteController@paymentSuccess',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'get.success',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'switch-lang' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'switch-lang',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@switchLang',
        'controller' => 'App\\Http\\Controllers\\SiteController@switchLang',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'switch-lang',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'switch-currency' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'switch-currency',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@switchCurrency',
        'controller' => 'App\\Http\\Controllers\\SiteController@switchCurrency',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'switch-currency',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'exit-impersonate' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'exit-impersonate',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\Impersonate@exitImpersonate',
        'controller' => 'App\\Http\\Controllers\\Impersonate@exitImpersonate',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'exit-impersonate',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pay' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'pay/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'App\\Http\\Controllers\\SiteController@preparePayment',
        'controller' => 'App\\Http\\Controllers\\SiteController@preparePayment',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'pay',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'guest',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:1:{s:13:"componentName";s:19:"pages.auth.register";}s:8:"function";s:294:"function () use ($componentName) {
            $container = \\Illuminate\\Container\\Container::getInstance();

            return $container->call([
                $container->make(\\Livewire\\Volt\\LivewireManager::class)->new($componentName),
                \'__invoke\',
            ]);
        }";s:5:"scope";s:25:"Livewire\\Volt\\VoltManager";s:4:"this";N;s:4:"self";s:32:"000000000000126c0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'guest',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:1:{s:13:"componentName";s:16:"pages.auth.login";}s:8:"function";s:294:"function () use ($componentName) {
            $container = \\Illuminate\\Container\\Container::getInstance();

            return $container->call([
                $container->make(\\Livewire\\Volt\\LivewireManager::class)->new($componentName),
                \'__invoke\',
            ]);
        }";s:5:"scope";s:25:"Livewire\\Volt\\VoltManager";s:4:"this";N;s:4:"self";s:32:"000000000000129b0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'guest',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:1:{s:13:"componentName";s:26:"pages.auth.forgot-password";}s:8:"function";s:294:"function () use ($componentName) {
            $container = \\Illuminate\\Container\\Container::getInstance();

            return $container->call([
                $container->make(\\Livewire\\Volt\\LivewireManager::class)->new($componentName),
                \'__invoke\',
            ]);
        }";s:5:"scope";s:25:"Livewire\\Volt\\VoltManager";s:4:"this";N;s:4:"self";s:32:"000000000000129d0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reset-password/{token}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'guest',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:1:{s:13:"componentName";s:25:"pages.auth.reset-password";}s:8:"function";s:294:"function () use ($componentName) {
            $container = \\Illuminate\\Container\\Container::getInstance();

            return $container->call([
                $container->make(\\Livewire\\Volt\\LivewireManager::class)->new($componentName),
                \'__invoke\',
            ]);
        }";s:5:"scope";s:25:"Livewire\\Volt\\VoltManager";s:4:"this";N;s:4:"self";s:32:"000000000000129f0000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'social-profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'social-profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:1:{s:13:"componentName";s:25:"pages.auth.social-profile";}s:8:"function";s:294:"function () use ($componentName) {
            $container = \\Illuminate\\Container\\Container::getInstance();

            return $container->call([
                $container->make(\\Livewire\\Volt\\LivewireManager::class)->new($componentName),
                \'__invoke\',
            ]);
        }";s:5:"scope";s:25:"Livewire\\Volt\\VoltManager";s:4:"this";N;s:4:"self";s:32:"00000000000012970000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'social-profile',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.notice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'verify-email',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:1:{s:13:"componentName";s:23:"pages.auth.verify-email";}s:8:"function";s:294:"function () use ($componentName) {
            $container = \\Illuminate\\Container\\Container::getInstance();

            return $container->call([
                $container->make(\\Livewire\\Volt\\LivewireManager::class)->new($componentName),
                \'__invoke\',
            ]);
        }";s:5:"scope";s:25:"Livewire\\Volt\\VoltManager";s:4:"this";N;s:4:"self";s:32:"00000000000012a10000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.notice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'verify-email/{id}/{hash}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'signed',
          5 => 'throttle:6,1',
        ),
        'uses' => 'App\\Http\\Controllers\\Auth\\VerifyEmailController@__invoke',
        'controller' => 'App\\Http\\Controllers\\Auth\\VerifyEmailController',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'confirm-password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:1:{s:13:"componentName";s:27:"pages.auth.confirm-password";}s:8:"function";s:294:"function () use ($componentName) {
            $container = \\Illuminate\\Container\\Container::getInstance();

            return $container->call([
                $container->make(\\Livewire\\Volt\\LivewireManager::class)->new($componentName),
                \'__invoke\',
            ]);
        }";s:5:"scope";s:25:"Livewire\\Volt\\VoltManager";s:4:"this";N;s:4:"self";s:32:"00000000000012a60000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.insights' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/insights',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Insights\\Insights@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Insights\\Insights',
        'as' => 'admin.insights',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.profile' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Profile\\AdminProfile@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Profile\\AdminProfile',
        'as' => 'admin.profile',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.manage-menus' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/manage-menus',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Menu\\ManageMenu@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Menu\\ManageMenu',
        'as' => 'admin.manage-menus',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.blog-listing' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/blogs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Blogs\\Blogs@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Blogs\\Blogs',
        'as' => 'admin.blog-listing',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.create-blog' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/blogs/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Blogs\\CreateBlog@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Blogs\\CreateBlog',
        'as' => 'admin.create-blog',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.update-blog' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/blogs/update/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Blogs\\UpdateBlog@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Blogs\\UpdateBlog',
        'as' => 'admin.update-blog',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.blog-categories' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/blog-categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Blogs\\BlogCategories@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Blogs\\BlogCategories',
        'as' => 'admin.blog-categories',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.taxonomy.languages' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/taxonomies/languages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Taxonomy\\Languages@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Taxonomy\\Languages',
        'as' => 'admin.taxonomy.languages',
        'namespace' => NULL,
        'prefix' => 'admin/taxonomies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.taxonomy.subjects' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/taxonomies/subjects',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Taxonomy\\Subjects@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Taxonomy\\Subjects',
        'as' => 'admin.taxonomy.subjects',
        'namespace' => NULL,
        'prefix' => 'admin/taxonomies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.taxonomy.subject-groups' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/taxonomies/subject-groups',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Taxonomy\\SubjectGroups@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Taxonomy\\SubjectGroups',
        'as' => 'admin.taxonomy.subject-groups',
        'namespace' => NULL,
        'prefix' => 'admin/taxonomies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.taxonomy.courses' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/taxonomies/courses',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\CoursesCompany\\Courses@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\CoursesCompany\\Courses',
        'as' => 'admin.taxonomy.courses',
        'namespace' => NULL,
        'prefix' => 'admin/taxonomies',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.commission-settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/commission-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Payments\\CommissionSettings@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Payments\\CommissionSettings',
        'as' => 'admin.commission-settings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.payment-methods' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/payment-methods',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Payments\\PaymentMethods@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Payments\\PaymentMethods',
        'as' => 'admin.payment-methods',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.withdraw-requests' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/withdraw-requests',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Payments\\WithdrawRequest@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Payments\\WithdrawRequest',
        'as' => 'admin.withdraw-requests',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.users' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Users\\Users@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Users\\Users',
        'as' => 'admin.users',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.identity-verification' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/identity-verification',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\IdentityVerification\\IdentityVerification@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\IdentityVerification\\IdentityVerification',
        'as' => 'admin.identity-verification',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.bookings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/bookings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Bookings\\Bookings@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Bookings\\Bookings',
        'as' => 'admin.bookings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.invoices' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/invoices',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Invoices\\Invoices@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Invoices\\Invoices',
        'as' => 'admin.invoices',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.email-settings' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/email-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\EmailTemplates\\EmailTemplates@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\EmailTemplates\\EmailTemplates',
        'as' => 'admin.email-settings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.approve-user-identity' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/users/approve-identity/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Users\\Users@approveUserIdentity',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Users\\Users@approveUserIdentity',
        'as' => 'admin.approve-user-identity',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.upgrade' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/upgrade',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Upgrade\\Upgrade@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Upgrade\\Upgrade',
        'as' => 'admin.upgrade',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.upgrade-logs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/upgrade/logs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GeneralController@getUpgradeLogs',
        'controller' => 'App\\Http\\Controllers\\Admin\\GeneralController@getUpgradeLogs',
        'as' => 'admin.upgrade-logs',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/update-sass-style',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GeneralController@updateSaas',
        'controller' => 'App\\Http\\Controllers\\Admin\\GeneralController@updateSaas',
        'as' => 'admin.',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.packages.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/packages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Packages\\ManagePackages@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Packages\\ManagePackages',
        'as' => 'admin.packages.index',
        'namespace' => NULL,
        'prefix' => 'admin/packages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.packages.installed' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/packages/installed',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Packages\\InstalledPackages@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Packages\\InstalledPackages',
        'as' => 'admin.packages.installed',
        'namespace' => NULL,
        'prefix' => 'admin/packages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.packages.upload' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/packages/upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GeneralController@uploadAddon',
        'controller' => 'App\\Http\\Controllers\\Admin\\GeneralController@uploadAddon',
        'as' => 'admin.packages.upload',
        'namespace' => NULL,
        'prefix' => 'admin/packages',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.disputes' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/disputes',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Dispute\\Dispute@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Dispute\\Dispute',
        'as' => 'admin.disputes',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.manage-dispute' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/manage-dispute/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Pages\\Admin\\Dispute\\ManageDispute@__invoke',
        'controller' => 'App\\Livewire\\Pages\\Admin\\Dispute\\ManageDispute',
        'as' => 'admin.manage-dispute',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.clear-cache' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/clear-cache',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GeneralController@clearCache',
        'controller' => 'App\\Http\\Controllers\\Admin\\GeneralController@clearCache',
        'as' => 'admin.clear-cache',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.update-smtp-settings' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/update-smtp-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GeneralController@updateSMTPSettings',
        'controller' => 'App\\Http\\Controllers\\Admin\\GeneralController@updateSMTPSettings',
        'as' => 'admin.update-smtp-settings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.update-social-login-settings' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/update-social-login-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\GeneralController@updateSocialLoginSettings',
        'controller' => 'App\\Http\\Controllers\\Admin\\GeneralController@updateSocialLoginSettings',
        'as' => 'admin.update-social-login-settings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.alianzas.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/alianzas',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AlianzaController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\AlianzaController@index',
        'as' => 'admin.alianzas.index',
        'namespace' => NULL,
        'prefix' => 'admin/alianzas',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.alianzas.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/alianzas/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AlianzaController@create',
        'controller' => 'App\\Http\\Controllers\\Admin\\AlianzaController@create',
        'as' => 'admin.alianzas.create',
        'namespace' => NULL,
        'prefix' => 'admin/alianzas',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.alianzas.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/alianzas/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AlianzaController@store',
        'controller' => 'App\\Http\\Controllers\\Admin\\AlianzaController@store',
        'as' => 'admin.alianzas.store',
        'namespace' => NULL,
        'prefix' => 'admin/alianzas',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.alianzas.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/alianzas/{alianza}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AlianzaController@edit',
        'controller' => 'App\\Http\\Controllers\\Admin\\AlianzaController@edit',
        'as' => 'admin.alianzas.edit',
        'namespace' => NULL,
        'prefix' => 'admin/alianzas',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.alianzas.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/alianzas/{alianza}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AlianzaController@update',
        'controller' => 'App\\Http\\Controllers\\Admin\\AlianzaController@update',
        'as' => 'admin.alianzas.update',
        'namespace' => NULL,
        'prefix' => 'admin/alianzas',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.alianzas.destroy' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/alianzas/{alianza}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AlianzaController@destroy',
        'controller' => 'App\\Http\\Controllers\\Admin\\AlianzaController@destroy',
        'as' => 'admin.alianzas.destroy',
        'namespace' => NULL,
        'prefix' => 'admin/alianzas',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.alianzas.toggle-status' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/alianzas/{alianza}/toggle-status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\AlianzaController@toggleStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\AlianzaController@toggleStatus',
        'as' => 'admin.alianzas.toggle-status',
        'namespace' => NULL,
        'prefix' => 'admin/alianzas',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tutorias.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/tutorias',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SlotBookingAdminController@index',
        'controller' => 'App\\Http\\Controllers\\Admin\\SlotBookingAdminController@index',
        'as' => 'admin.tutorias.index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tutorias.updateStatus' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/tutorias/{id}/status',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Http\\Controllers\\Admin\\SlotBookingAdminController@updateStatus',
        'controller' => 'App\\Http\\Controllers\\Admin\\SlotBookingAdminController@updateStatus',
        'as' => 'admin.tutorias.updateStatus',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tutors.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/tutors',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Admin\\Tutors\\Tutors@__invoke',
        'controller' => 'App\\Livewire\\Admin\\Tutors\\Tutors',
        'as' => 'admin.tutors.index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.tutors.show' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/tutors{tutor}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Admin\\Tutors\\Tutors@__invoke',
        'controller' => 'App\\Livewire\\Admin\\Tutors\\Tutors',
        'as' => 'admin.tutors.show',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'admin.cupones.index' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/cupones',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'verified',
          5 => 'role:admin',
        ),
        'uses' => 'App\\Livewire\\Promociones\\Cupones@__invoke',
        'controller' => 'App\\Livewire\\Promociones\\Cupones',
        'as' => 'admin.cupones.index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'optionbuilder' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/option-builder',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Optionbuilder\\Http\\Controllers\\OptionBuilderController@index',
        'controller' => 'Larabuild\\Optionbuilder\\Http\\Controllers\\OptionBuilderController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'optionbuilder',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'optionbuilder.update-section-settings' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/option-builder/update-section-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Optionbuilder\\Http\\Controllers\\OptionBuilderController@updateSettings',
        'controller' => 'Larabuild\\Optionbuilder\\Http\\Controllers\\OptionBuilderController@updateSettings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'optionbuilder.update-section-settings',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'optionbuilder.reset-section-settings' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/option-builder/reset-section-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Optionbuilder\\Http\\Controllers\\OptionBuilderController@resetSettings',
        'controller' => 'Larabuild\\Optionbuilder\\Http\\Controllers\\OptionBuilderController@resetSettings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'optionbuilder.reset-section-settings',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'optionbuilder.upload-files' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/option-builder/upload-files',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Optionbuilder\\Http\\Controllers\\OptionBuilderController@uploadFiles',
        'controller' => 'Larabuild\\Optionbuilder\\Http\\Controllers\\OptionBuilderController@uploadFiles',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'optionbuilder.upload-files',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pagebuilder' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/pages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@index',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@index',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'pagebuilder',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page.edit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/pages/{page}/edit',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@edit',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@edit',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'page.edit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/pages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@store',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@store',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'page.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page.update' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'admin/pages/{page}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@update',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@update',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'page.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page.create' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/pages/create',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@create',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@create',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'page.create',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'page.delete' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'admin/pages/{page}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@destroy',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageController@destroy',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'page.delete',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pagebuilder.build' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'admin/pages/{id}/build',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@build',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@build',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'pagebuilder.build',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pagebuilder.store-component-data' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/pages/{id}/store',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@storeComponentData',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@storeComponentData',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'pagebuilder.store-component-data',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pagebuilder.get-section-settings' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/get-section-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@getSettings',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@getSettings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'pagebuilder.get-section-settings',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pagebuilder.set-section-settings' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/set-section-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@setSectionSettings',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@setSectionSettings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'pagebuilder.set-section-settings',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pagebuilder.set-page-settings' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'admin/set-page-settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
          3 => 'auth',
          4 => 'role:admin',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@setPageSettings',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@setPageSettings',
        'namespace' => NULL,
        'prefix' => '/admin',
        'where' => 
        array (
        ),
        'as' => 'pagebuilder.set-page-settings',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pagebuilder.html' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'get-pb-section',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@getPageSectionHtml',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@getPageSectionHtml',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'pagebuilder.html',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pagebuilder.iframe' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'pages/{id}/iframe',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@iframe',
        'controller' => 'Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController@iframe',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'pagebuilder.iframe',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'pagebuilder.page' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
        2 => 'POST',
        3 => 'PUT',
        4 => 'PATCH',
        5 => 'DELETE',
        6 => 'OPTIONS',
      ),
      'uri' => '{any}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
          1 => 'locale',
          2 => 'maintenance',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:186:"function (\\Illuminate\\Http\\Request $request) {
    $builder = new \\Larabuild\\Pagebuilder\\Http\\Controllers\\PageBuilderController();
    return $builder->renderPage($request->path());
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000012e50000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'pagebuilder.page',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'any' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'tutor.perfil' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'tutor/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'App\\Http\\Controllers\\TutorPerfilController@show',
        'controller' => 'App\\Http\\Controllers\\TutorPerfilController@show',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'tutor.perfil',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
