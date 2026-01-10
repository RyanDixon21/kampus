<?php

namespace App\Filament\Resources\AboutResource\Pages;

use App\Filament\Resources\AboutResource;
use App\Models\About;
use Filament\Actions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;

class ManageAbout extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = AboutResource::class;

    protected static ?string $title = 'Tentang';

    public ?array $data = [];

    public function getView(): string
    {
        return 'filament.resources.about-resource.pages.manage-about';
    }

    public function mount(): void
    {
        $this->form->fill([
            'tentang_title' => About::bySection('tentang')->first()?->title ?? 'Tentang Kami',
            'tentang_content' => About::bySection('tentang')->first()?->content ?? '',
            'visi_title' => About::bySection('visi')->first()?->title ?? 'Visi',
            'visi_content' => About::bySection('visi')->first()?->content ?? '',
            'misi_title' => About::bySection('misi')->first()?->title ?? 'Misi',
            'misi_content' => About::bySection('misi')->first()?->content ?? '',
            'sejarah_title' => About::bySection('sejarah')->first()?->title ?? 'Sejarah',
            'sejarah_content' => About::bySection('sejarah')->first()?->content ?? '',
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema(AboutResource::getFormSchema())
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Update or create Tentang
        About::updateOrCreate(
            ['section' => 'tentang'],
            [
                'title' => $data['tentang_title'],
                'content' => $data['tentang_content'],
                'order' => 1,
                'is_active' => true,
            ]
        );

        // Update or create Visi
        About::updateOrCreate(
            ['section' => 'visi'],
            [
                'title' => $data['visi_title'],
                'content' => $data['visi_content'],
                'order' => 2,
                'is_active' => true,
            ]
        );

        // Update or create Misi
        About::updateOrCreate(
            ['section' => 'misi'],
            [
                'title' => $data['misi_title'],
                'content' => $data['misi_content'],
                'order' => 3,
                'is_active' => true,
            ]
        );

        // Update or create Sejarah
        About::updateOrCreate(
            ['section' => 'sejarah'],
            [
                'title' => $data['sejarah_title'],
                'content' => $data['sejarah_content'],
                'order' => 4,
                'is_active' => true,
            ]
        );

        Notification::make()
            ->title('Berhasil disimpan')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Simpan Perubahan')
                ->action('save'),
        ];
    }
}
