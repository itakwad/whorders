<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Hash;
use Filament\Forms;

class AdminSetting extends Page
{
    protected string $view = 'filament.pages.admin-setting';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::AdjustmentsVertical;
    protected static ?string $title = 'الملف الشخصي';
    protected static ?string $navigationLabel = 'بيانات الادمن'; // label عربي للقائمة
    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {

        $this->form->fill($this->getRecord()?->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->label('الاسم') // label عربي
                    //->default($this->data['name'])
                    ,
                    TextInput::make('email')
                        ->label('البريد الإلكتروني')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),
                    TextInput::make('password')
                        ->label('كلمة المرور')
                        ->password()

                        // دائمًا فارغ حتى في edit
                        ->default(null)
                        ->formatStateUsing(fn () => null)

                        // منع المتصفح من وضع قيمة افتراضية
                        ->extraInputAttributes([
                            'autocomplete' => 'new-password',
                        ])

                        // مطلوب فقط عند الإنشاء
                        ->required(fn (string $context): bool => $context === 'create')

                        // لا يتم إرساله لقاعدة البيانات إذا كان فارغًا
                        ->dehydrated(fn (?string $state): bool => filled($state))

                        // تشفير فقط عند الإدخال
                        ->dehydrateStateUsing(
                            fn (?string $state): ?string =>
                            filled($state) ? Hash::make($state) : null
                        )

        ])
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
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
            ->title('Saved')
            ->send();
    }

    public function getRecord(): ?User
    {
        $user = User::query()
            ->where('role', 'admin')
            ->first();

        return $user;
    }
}
