<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Cache;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = SettingResource::class;

    protected static ?string $title = 'Pengaturan Website';

    public ?array $data = [];

    public function getView(): string
    {
        return 'filament.resources.setting-resource.pages.manage-settings';
    }

    public function mount(): void
    {
        $data = $this->getSettingsData();
        
        // Handle logo separately - only set if exists
        if (!empty($data['logo'])) {
            // Check if file exists
            if (\Storage::disk('public')->exists($data['logo'])) {
                $this->form->fill($data);
            } else {
                // Remove logo from data if file doesn't exist
                unset($data['logo']);
                $this->form->fill($data);
            }
        } else {
            $this->form->fill($data);
        }
    }

    protected function getSettingsData(): array
    {
        $data = [
            'university_name' => Setting::get('university_name', 'Sekolah Tinggi Teknologi Pratama Adi'),
            'university_short_name' => Setting::get('university_short_name', 'STT Pratama Adi'),
            'address' => Setting::get('address'),
            'phone' => Setting::get('phone'),
            'email' => Setting::get('email'),
            'facebook_url' => Setting::get('facebook_url'),
            'instagram_url' => Setting::get('instagram_url'),
            'youtube_url' => Setting::get('youtube_url'),
            'wa_admin' => Setting::get('wa_admin'),
        ];
        
        // Only include logo if it exists and file is valid
        $logo = Setting::get('logo');
        if ($logo && \Storage::disk('public')->exists($logo)) {
            $data['logo'] = $logo;
        }
        
        return $data;
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema(SettingResource::getFormSchema())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            // Handle file uploads specially
            if ($key === 'logo' && $value) {
                // If it's a new upload (UploadedFile), it's already saved by Filament
                // Just save the path
                Setting::set($key, $value);
            } else {
                Setting::set($key, $value);
            }
        }

        // Clear all caches
        \Cache::forget('settings.all');
        \Artisan::call('cache:clear');

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->action('save'),
        ];
    }
}

