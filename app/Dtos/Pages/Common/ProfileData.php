<?php
// app/Dtos/ProfileData.php
namespace App\Dtos\Pages\Common;

class ProfileData
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public ?string $phone_number,
        public string|int $gender,
        public string $slug,
        public string $description,
        public string $native_language,
        public ?string $image = null,
        public ?string $intro_video = null,
    ) {}

}