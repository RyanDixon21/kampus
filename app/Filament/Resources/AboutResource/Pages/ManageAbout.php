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
        $nilai = About::bySection('nilai')->ordered()->get();
        $akreditasi = About::bySection('akreditasi')->ordered()->get();
        
        $this->form->fill([
            'sejarah_title' => About::bySection('sejarah')->first()?->title ?? 'Sejarah Kami',
            'sejarah_content' => About::bySection('sejarah')->first()?->content ?? '',
            'visi_content' => About::bySection('visi')->first()?->content ?? '',
            'misi_content' => About::bySection('misi')->first()?->content ?? '',
            'nilai_title' => About::bySection('nilai_header')->first()?->title ?? 'Nilai-Nilai Kami',
            'nilai_description' => About::bySection('nilai_header')->first()?->content ?? 'Prinsip yang menjadi landasan dalam setiap kegiatan kami',
            'nilai_items' => $nilai->map(fn($item) => [
                'icon' => $item->icon ?? ($item->order == 1 ? 'shield' : ($item->order == 2 ? 'lightbulb' : ($item->order == 3 ? 'star' : 'users'))),
                'title' => $item->title,
                'content' => $item->content,
            ])->toArray(),
            'akreditasi_title' => About::bySection('akreditasi_header')->first()?->title ?? 'Akreditasi & Penghargaan',
            'akreditasi_description' => About::bySection('akreditasi_header')->first()?->content ?? 'Pengakuan atas komitmen kami terhadap kualitas pendidikan',
            'akreditasi_items' => $akreditasi->map(fn($item) => [
                'icon' => $item->icon ?? ($item->order == 1 ? 'badge' : ($item->order == 2 ? 'shield' : 'sparkles')),
                'title' => $item->title,
                'content' => $item->content,
            ])->toArray(),
            'cta_title' => About::bySection('cta')->first()?->title ?? 'Siap Bergabung Bersama Kami?',
            'cta_description' => About::bySection('cta')->first()?->content ?? 'Wujudkan impian Anda untuk menjadi profesional di bidang teknologi',
            'cta_button_text' => About::bySection('cta_button')->first()?->title ?? 'Daftar Sekarang',
            'cta_button_link' => About::bySection('cta_button')->first()?->content ?? route('registration.create'),
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

        // Update or create Sejarah
        About::updateOrCreate(
            ['section' => 'sejarah', 'order' => 1],
            [
                'title' => $data['sejarah_title'],
                'content' => $data['sejarah_content'],
                'is_active' => true,
            ]
        );

        // Update or create Visi
        About::updateOrCreate(
            ['section' => 'visi', 'order' => 1],
            [
                'title' => 'Visi',
                'content' => $data['visi_content'],
                'is_active' => true,
            ]
        );

        // Update or create Misi
        About::updateOrCreate(
            ['section' => 'misi', 'order' => 1],
            [
                'title' => 'Misi',
                'content' => $data['misi_content'],
                'is_active' => true,
            ]
        );

        // Update or create Nilai Header
        About::updateOrCreate(
            ['section' => 'nilai_header', 'order' => 1],
            [
                'title' => $data['nilai_title'],
                'content' => $data['nilai_description'],
                'is_active' => true,
            ]
        );

        // Delete existing nilai and create new ones
        About::where('section', 'nilai')->delete();
        
        if (isset($data['nilai_items']) && is_array($data['nilai_items'])) {
            foreach ($data['nilai_items'] as $index => $nilai) {
                About::create([
                    'section' => 'nilai',
                    'title' => $nilai['title'],
                    'content' => $nilai['content'],
                    'icon' => $nilai['icon'] ?? null,
                    'order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        // Update or create Akreditasi Header
        About::updateOrCreate(
            ['section' => 'akreditasi_header', 'order' => 1],
            [
                'title' => $data['akreditasi_title'],
                'content' => $data['akreditasi_description'],
                'is_active' => true,
            ]
        );

        // Delete existing akreditasi and create new ones
        About::where('section', 'akreditasi')->delete();
        
        if (isset($data['akreditasi_items']) && is_array($data['akreditasi_items'])) {
            foreach ($data['akreditasi_items'] as $index => $akreditasi) {
                About::create([
                    'section' => 'akreditasi',
                    'title' => $akreditasi['title'],
                    'content' => $akreditasi['content'],
                    'icon' => $akreditasi['icon'] ?? null,
                    'order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        // Update or create CTA
        About::updateOrCreate(
            ['section' => 'cta', 'order' => 1],
            [
                'title' => $data['cta_title'],
                'content' => $data['cta_description'],
                'is_active' => true,
            ]
        );

        // Update or create CTA Button
        About::updateOrCreate(
            ['section' => 'cta_button', 'order' => 1],
            [
                'title' => $data['cta_button_text'],
                'content' => $data['cta_button_link'],
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
