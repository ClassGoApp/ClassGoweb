<?php

namespace App\Services;

use App\Jobs\SendNotificationJob;
use App\Models\Code;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\Coupon;
use App\Models\UserCoupon;


class RegisterService
{


    //registro normal
    public function registerUser($request): User
    {
        $user = User::create([
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $user->profile()->create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone_number' => $request['phone_number']
        ]);
        $user->assignRole($request['user_role']);

        // Disparar evento Registered para que Laravel envíe el correo de verificación de email
        event(new Registered($user));

        // realiza las operaciones necesarias para los cupones
        $this->generaCupones($request, $user);

        $this->assignExistingCourses($user);

        $emailData = [
            'userName' => $user->profile->full_name, 
            'userEmail' => $user->email, 
            'key' => $user->getKey(),
            'userRole' => $user->role ?? 'unknown'
        ];
        dispatch(new SendNotificationJob('registration', $user, $emailData));
        dispatch(new SendNotificationJob('registration', User::admin(), $emailData));
        $user->token = $user->createToken('learnen')->plainTextToken;
        return $user;
    }




    //este es por google 
    public function completeSocialProfile($user, $request): User
    {
        $user->profile()->create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'phone_number' => $request['phone_number']
        ]);
        $user->assignRole($request['user_role']);
        // realiza las operaciones necesarias para los cupones
        $this->generaCupones($request, $user);

        $this->assignExistingCourses($user);

        $emailData = ['userName' => $user->profile->full_name, 'userEmail' => $user->email, 'key' => $user->getKey()];
        dispatch(job: new SendNotificationJob('welcome', $user, $emailData));
        dispatch(new SendNotificationJob('welcome', User::admin(), $emailData));
        return $user;
    }

    public function sendEmailVerificationNotification($user)
    {
        $emailData = ['userName' => $user->profile->full_name, 'userEmail' => $user->email, 'key' => $user->getKey()];
        dispatch(new SendNotificationJob('emailVerification', $user, $emailData));
        return true;
    }

    public function sendPasswordResetLink($request): array
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );
        if ($status != Password::RESET_LINK_SENT) {
            return [
                'success' => false,
                'message' => $status
            ];
        }
        return [
            'success' => true,
            'message' => $status
        ];
    }


    public function resetPassword($request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
        if ($status != Password::PASSWORD_RESET) {
            return [
                'success' => false,
                'message' => $status
            ];
        }
        return [
            'success' => true,
            'message' => $status
        ];
    }

    function generaCupones($request, $user)
    {
        if ($request['user_role'] == 'student') {
            $cuponservice = new CuponesService();
            // agrega el cupon de bienvenida
            //$cuponservice->asignacionCuponBienvenida($user);
            // genera su cupon de invitacion del ususario registrado
            $cuponservice->generaCuponInvitacion($user);
            if (!empty($request['codigo'])) {
                $cupon = Coupon::where('codigo', $request['codigo'])->first();
                // agregamos el cupon de invitacion al nuevo usuario
                $cuponservice->asignacionCuponInvitacion($cupon, $user);
                //agregamos el cupon al dueño del cupón
                $cuponservice->asignacionCuponDuenio($cupon);
            }
        }
    }




    private function assignExistingCourses(User $user): void
    {
        // Obtener todos los cursos de la empresa
        $companyCourses = \App\Models\CompanyCourse::all();

        // Preparar los datos para inserción masiva
        $courseUserData = [];
        foreach ($companyCourses as $course) {
            $courseUserData[] = [
                'company_course_id' => $course->id,
                'user_id' => $user->id,
                'status' => 'pending', // Estado inicial
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insertar todos los cursos de una vez (más eficiente)
        if (!empty($courseUserData)) {
            \DB::table('company_course_user')->insert($courseUserData);
        }
    }
}
