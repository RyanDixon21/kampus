<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog;

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static ?string $modelLabel = 'Pengaturan';

    protected static ?string $pluralModelLabel = 'Pengaturan';

    protected static ?int $navigationSort = 99;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Kampus')
                    ->schema([
                        TextInput::make('university_name')
                            ->label('Nama Universitas (Lengkap)')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: Sekolah Tinggi Teknologi Pratama Adi')
                            ->default(fn () => Setting::get('university_name', 'Sekolah Tinggi Teknologi Pratama Adi')),
                        
                        TextInput::make('university_short_name')
                            ->label('Nama Universitas (Singkat)')
                            ->required()
                            ->maxLength(100)
                            ->helperText('Contoh: STT Pratama Adi')
                            ->default(fn () => Setting::get('university_short_name', 'STT Pratama Adi')),
                        
                        TextInput::make('university_slogan')
                            ->label('Slogan/Tagline')
                            ->maxLength(255)
                            ->helperText('Contoh: Sekolah Tinggi Teknologi')
                            ->default(fn () => Setting::get('university_slogan', 'Sekolah Tinggi Teknologi')),
                        
                        Textarea::make('footer_description')
                            ->label('Deskripsi Footer')
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText('Deskripsi singkat yang ditampilkan di footer website')
                            ->placeholder('Contoh: STT Pratama Adi adalah institusi pendidikan tinggi yang berfokus pada pengembangan teknologi dan inovasi.')
                            ->default(fn () => Setting::get('footer_description')),
                        
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('settings')
                            ->imageEditor()
                            ->imageResizeMode('contain')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('500')
                            ->imageResizeTargetHeight('500')
                            ->maxSize(2048)
                            ->disk('public')
                            ->visibility('public')
                            ->helperText('Ukuran rekomendasi: 500x500px (rasio 1:1). Logo akan otomatis di-resize.'),
                        
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->maxLength(500)
                            ->default(fn () => Setting::get('address')),
                        
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel()
                            ->maxLength(20)
                            ->default(fn () => Setting::get('phone')),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255)
                            ->default(fn () => Setting::get('email')),
                    ])
                    ->columns(2),

                Section::make('Konten Halaman - Section Berita')
                    ->schema([
                        TextInput::make('news_section_title')
                            ->label('Judul Section Berita')
                            ->maxLength(255)
                            ->default(fn () => Setting::get('news_section_title', 'Berita Terkini'))
                            ->helperText('Judul yang ditampilkan di section berita'),
                        
                        Textarea::make('news_section_description')
                            ->label('Deskripsi Section Berita')
                            ->rows(2)
                            ->maxLength(500)
                            ->default(fn () => Setting::get('news_section_description', 'Informasi terkini terkait Civitas Academica'))
                            ->helperText('Deskripsi singkat di bawah judul section berita'),
                    ])
                    ->columns(1),

                Section::make('Konten Halaman - Section Keunggulan')
                    ->schema([
                        TextInput::make('why_choose_us_title')
                            ->label('Judul Section Keunggulan')
                            ->maxLength(255)
                            ->default(fn () => Setting::get('why_choose_us_title', 'Mengapa Memilih Kami?'))
                            ->helperText('Judul yang ditampilkan di section keunggulan'),
                        
                        Textarea::make('why_choose_us_description')
                            ->label('Deskripsi Section Keunggulan')
                            ->rows(2)
                            ->maxLength(500)
                            ->default(fn () => Setting::get('why_choose_us_description', 'Komitmen kami untuk memberikan pendidikan berkualitas tinggi dengan fasilitas modern'))
                            ->helperText('Deskripsi singkat di bawah judul section keunggulan'),
                    ])
                    ->columns(1),

                Section::make('Konten Halaman - Section Fasilitas')
                    ->schema([
                        TextInput::make('facilities_section_title')
                            ->label('Judul Section Fasilitas')
                            ->maxLength(255)
                            ->default(fn () => Setting::get('facilities_section_title', 'Fasilitas Modern'))
                            ->helperText('Judul yang ditampilkan di section fasilitas'),
                        
                        Textarea::make('facilities_section_description')
                            ->label('Deskripsi Section Fasilitas')
                            ->rows(2)
                            ->maxLength(500)
                            ->default(fn () => Setting::get('facilities_section_description', 'Fasilitas lengkap untuk mendukung kegiatan belajar mengajar'))
                            ->helperText('Deskripsi singkat di bawah judul section fasilitas'),
                    ])
                    ->columns(1),

                Section::make('Lokasi Kampus')
                    ->schema([
                        FileUpload::make('campus_images')
                            ->label('Foto Kampus (Maksimal 4)')
                            ->image()
                            ->multiple()
                            ->maxFiles(4)
                            ->directory('settings/campus')
                            ->imageEditor()
                            ->maxSize(5120)
                            ->disk('public')
                            ->visibility('public')
                            ->helperText('Upload maksimal 4 foto kampus untuk ditampilkan dalam kolase di section lokasi')
                            ->reorderable()
                            ->default(function () {
                                $value = Setting::get('campus_images');
                                if (is_string($value)) {
                                    return json_decode($value, true) ?? [];
                                }
                                return is_array($value) ? $value : [];
                            }),
                        
                        Textarea::make('maps_embed')
                            ->label('Google Maps Embed Code')
                            ->rows(5)
                            ->helperText('Paste kode embed dari Google Maps (iframe)')
                            ->placeholder('<iframe src="https://www.google.com/maps/embed?..." width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>')
                            ->default(fn () => Setting::get('maps_embed')),
                    ])
                    ->columns(1),

                Section::make('Social Media')
                    ->schema([
                        TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://facebook.com/sttpratama')
                            ->default(fn () => Setting::get('facebook_url')),
                        
                        TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://instagram.com/sttpratama')
                            ->default(fn () => Setting::get('instagram_url')),
                        
                        TextInput::make('youtube_url')
                            ->label('YouTube URL')
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://youtube.com/@sttpratama')
                            ->default(fn () => Setting::get('youtube_url')),
                    ])
                    ->columns(3),

                Section::make('WhatsApp Admin')
                    ->schema([
                        TextInput::make('wa_admin')
                            ->label('Nomor WhatsApp Admin')
                            ->required()
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('628123456789')
                            ->helperText('Format: 628123456789 (tanpa tanda + atau spasi)')
                            ->default(fn () => Setting::get('wa_admin')),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Key')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Terakhir Diupdate')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSettings::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getFormSchema(): array
    {
        return self::form(\Filament\Schemas\Schema::make())->getComponents();
    }
}

