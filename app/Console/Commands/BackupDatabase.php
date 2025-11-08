<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupDatabase extends Command
{
    protected $signature = 'backup:db';
    protected $description = 'Backup database MySQL ke folder database/backups';

    public function handle()
    {
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST', '127.0.0.1');
        $dbPort = env('DB_PORT', '3306');

        $timestamp = date('Y-m-d_H-i-s');
        $backupPath = database_path("backups/{$dbName}_backup_{$timestamp}.sql");

        // Pastikan folder backup ada
        if (!File::isDirectory(database_path('backups'))) {
            File::makeDirectory(database_path('backups'), 0755, true);
        }

        // Perintah mysqldump lengkap
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s --port=%s %s > "%s"',
            $dbUser,
            $dbPass,
            $dbHost,
            $dbPort,
            $dbName,
            $backupPath
        );

        $this->info("🕒 Membackup database {$dbName}...");
        $result = null;
        $output = null;

        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("✅ Backup database berhasil disimpan di: {$backupPath}");
        } else {
            $this->error("❌ Gagal melakukan backup database. Pastikan MySQL dan mysqldump sudah tersedia di PATH environment.");
        }
    }
}
