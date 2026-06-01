<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return $this->success($settings, 'Settings retrieved successfully');
    }

    public function update(Request $request)
    {
        $validFields = ['library_name', 'library_logo', 'library_address', 'library_phone', 'library_email'];

        foreach ($validFields as $field) {
            if ($request->has($field)) {
                Setting::setValue($field, $request->$field);
            }
        }

        if ($request->hasFile('library_logo')) {
            $path = $request->file('library_logo')->store('settings', 'public');
            Setting::setValue('library_logo', Storage::url($path));
        }

        return $this->success(null, 'Settings updated successfully');
    }

    public function backup()
    {
        $dbPath = database_path('database.sqlite');
        if (file_exists($dbPath)) {
            $backupDir = storage_path('app/backups');
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            $backupFile = $backupDir . '/backup-' . date('Y-m-d-His') . '.sqlite';
            copy($dbPath, $backupFile);
            return $this->success(['path' => $backupFile], 'Database backup created successfully');
        }
        return $this->error('Database file not found', 404);
    }
}
