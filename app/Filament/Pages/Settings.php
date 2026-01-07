<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class Settings extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string | \UnitEnum | null $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Website Settings';
    protected static ?string $title = 'Settings';
    
    protected string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        $this->data = $settings;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Logo & Favicon')
                    ->schema([
                        Placeholder::make('existing_logo')
                            ->label('Existing Logo')
                            ->content(fn () => $this->getImageHtml('site_logo')),
                        FileUpload::make('site_logo')
                            ->label('Change Logo')
                            ->image()
                            ->directory('settings')
                            ->visibility('public'),
                        Placeholder::make('existing_favicon')
                            ->label('Existing Favicon')
                            ->content(fn () => $this->getImageHtml('site_favicon')),
                        FileUpload::make('site_favicon')
                            ->label('Change Favicon')
                            ->image()
                            ->directory('settings')
                            ->visibility('public'),
                    ]),

                Section::make("Other's Setting")
                    ->schema([
                        TextInput::make('site_title')
                            ->label('App Name'),
                        TextInput::make('phone')
                            ->label('Phone'),
                        Textarea::make('address')
                            ->label('Address')
                            ->rows(3),
                        TextInput::make('google_tag_manager')
                            ->label('Google Tag Manager ID')
                            ->placeholder('GTM-XXXXXXX'),
                        Textarea::make('footer_text')
                            ->label('Footer Text')
                            ->rows(3),
                    ]),
            ]);
    }

    protected function getImageHtml(string $key): HtmlString
    {
        $value = Setting::get($key);
        if (!$value) {
            return new HtmlString('<span class="text-gray-400">No image set</span>');
        }
        $url = Storage::url($value);
        return new HtmlString('<img src="' . $url . '" style="max-height: 80px;" />');
    }

    public function save(): void
    {
        foreach ($this->data as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}
