<?php

namespace App\Filament\Seller\Pages;

use App\Models\User;
use Filament\Actions\Action;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use BackedEnum;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Form;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserSetting extends Page
{
    public ?array $data = [];

    protected string $view = 'filament.seller.pages.user-setting';

    protected static ?string $navigationLabel = 'تغير كلمة السر';


    protected static ?string $title = 'تغير كلمة السر';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-lock-closed';

    public function mount(): void
    {
        $this->form->fill($this->getRecord()?->attributesToArray());

    }

    public function form(Schema $schema): Schema
    {

        return $schema->components([
            Form::make([
                Section::make('')
                    ->schema([
                        TextInput::make('password')
                            ->label('كلمة المرور الجديدة')
                            ->password()
                            ->required()
                            ->rule(Password::default())
                            ->dehydrated(fn ($state) => filled($state))
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state)),

                        TextInput::make('password_confirmation')
                            ->label('تأكيد كلمة المرور')
                            ->password()
                            ->required()
                            ->same('password'),

                    ]),

            ]) ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label('حفظ')
                            ->submit('save')
                            ->keyBindings(['mod+s']),
                    ]),
                ])->statePath('data')
        ]);
    }


    public function save(): void
    {
        // التحقق من البيانات وجلبها
      $this->form->getState();

        $user = auth()->user();
        $user->update([
            'password' => $this->data['password'],
        ]);

        // إفراغ الحقول بعد الحفظ
        $this->form->fill();

        Notification::make()
            ->success()
            ->title('تم التحديث')
            ->body('تم تغيير كلمة المرور بنجاح.')
            ->send();
    }


    public function getRecord(): \Illuminate\Database\Eloquent\Model
    {
        $id=auth()->user()->id;
        return  User::findOrFail($id);
    }
}
