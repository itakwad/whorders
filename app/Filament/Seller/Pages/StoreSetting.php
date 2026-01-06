<?php

namespace App\Filament\Seller\Pages;

use App\Models\Store;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StoreSetting extends Page
{

    public ?array $data = [];

    protected string $view = 'filament.seller.pages.store-setting';
    protected static ?string $navigationLabel = 'اعدادت المتجر';


    protected static ?string $title = 'اعدادت المتجر';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-adjustments-horizontal';

    public function mount(): void
    {
        $this->form->fill($this->getRecord()?->attributesToArray());

    }




    public function form(Schema $schema): Schema
    {

        return $schema->components([
            Form::make([


                Section::make('الصور والوسائط')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('اللوجو')
                            ->image()
                            ->disk('public')
                            ->directory('stores/logos')
                            ->visibility('public'),

                        FileUpload::make('cover_image')
                            ->label('صورة الغلاف')
                            ->image()
                            ->disk('public')
                            ->directory('stores/covers')
                            ->visibility('public'),

                    ])->columns(2),

                Section::make('بيانات التواصل والعنوان')
                    ->schema([
                        TextInput::make('address')
                            ->label('العنوان'),
                        Textarea::make('description')
                            ->label('الوصف')
                            ->columnSpanFull(),

                        Grid::make(3)->schema([
                            TextInput::make('phone')
                                ->label('رقم الهاتف')
                                ->tel(),

                            TextInput::make('facebook')
                                ->label('رابط فيسبوك')
                                ->url(),

                            TextInput::make('whatsapp')
                                ->label('رقم الواتساب')
                                ->tel(),
                        ]),
                    ]),

                Section::make('أوقات العمل')
                    ->schema([
                        Grid::make(2)->schema([
                            TimePicker::make('open_time')
                                ->label('وقت الفتح'),

                            TimePicker::make('close_time')
                                ->label('وقت الإغلاق'),
                        ]),
                    ])
            ]) ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label('حفظ')
                            ->submit('save')
                            ->keyBindings(['mod+s']),
                    ]),
                ]),
        ])
            ->record($this->getRecord())
            ->statePath('data');
    }


    public function save(): void
    {
        $data = $this->form->getState();

        $record = $this->getRecord();



        $record->fill($data);
        $record->save();

        if ($record->wasRecentlyCreated) {
            $this->form->record($record)->saveRelationships();
        }

        Notification::make()
            ->success()
            ->title('حفظ')
            ->send();
    }
    public function getRecord(): \Illuminate\Database\Eloquent\Model
    {
        return Filament::getTenant();
    }
}
