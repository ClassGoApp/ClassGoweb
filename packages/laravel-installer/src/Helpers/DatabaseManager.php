<?php

namespace Froiden\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseManager
{

    /**
     * Migrate and seed the database.
     *
     * @return array
     */
    public function migrateOnly()
    {
        $this->sqlite();
        return $this->migrate();
    }

    /**
     * Run the migration and call the seeder.
     *
     * @return array
     */
    private function migrate()
    {
        try {
            Artisan::call('migrate:fresh', ["--force" => true, '--schema-path' => 'do not run schema path']);
        } catch (Exception $e) {
            return $this->response($e->getMessage());
        }
    }

    /**
     * Seed the database.
     *
     * @return array
     */
    public function seed($seederClass)
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Artisan::call('db:seed', [
                '--class' => $seederClass,
                '--force' => true
            ]);
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (Exception $e) {
            return $this->response($e->getMessage());
        }

        return $this->response(trans('installer_messages.final.finished'), 'success');
    }

    /**
     * Return a formatted error messages.
     *
     * @param $message
     * @param string $status
     * @return array
     */
    private function response($message, $status = 'danger')
    {
        return array(
            'status' => $status,
            'message' => $message
        );
    }

    /**
     * check database type. If SQLite, then create the database file.
     */
    private function sqlite()
    {
        if (DB::connection() instanceof SQLiteConnection) {
            $database = DB::connection()->getDatabaseName();
            if (!file_exists($database)) {
                touch($database);
                DB::reconnect(Config::get('database.default'));
            }
        }
    }
}
