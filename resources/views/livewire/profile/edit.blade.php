<?php

use App\Models\User;
use Paraguay\Regions\Models\City;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

new #[Title('Edit Profile')] class extends Component {
    use Toast;
    use WithFileUploads;

    public User $user;

    // User Information
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    public $avatar;

    // Personal Data
    #[Validate('nullable|string|max:50')]
    public ?string $document_number = '';

    #[Validate('nullable|in:male,female,other')]
    public ?string $gender = '';

    #[Validate('nullable|date|before:today')]
    public ?string $birth_date = '';

    #[Validate('nullable|string|max:20')]
    public ?string $phone = '';

    // Address Information
    #[Validate('nullable|exists:cities,id')]
    public ?int $city_id = null;

    #[Validate('nullable|string|max:255')]
    public ?string $street = '';

    #[Validate('nullable|string|max:20')]
    public ?string $number = '';

    #[Validate('nullable|string|max:255')]
    public ?string $reference = '';

    public function mount()
    {
        $this->user = User::with(['personalData', 'address'])->findOrFail(Auth::id());

        // Cargar datos del usuario
        $this->name = $this->user->name;
        $this->email = $this->user->email;

        // Cargar datos personales
        if ($this->user->personalData) {
            $this->document_number = $this->user->personalData->document_number;
            $this->gender = $this->user->personalData->gender;
            $this->birth_date = $this->user->personalData->birth_date;
            $this->phone = $this->user->personalData->phone;
        }

        // Cargar dirección
        if ($this->user->address) {
            $this->city_id = $this->user->address->city_id;
            $this->street = $this->user->address->street;
            $this->number = $this->user->address->number;
            $this->reference = $this->user->address->reference;
        }
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'avatar' => 'nullable|image|max:2048',
            'document_number' => 'nullable|string|max:50',
            'gender' => 'nullable|in:male,female,other',
            'birth_date' => 'nullable|date|before:today',
            'phone' => 'nullable|string|max:20',
            'city_id' => 'nullable|exists:cities,id',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:20',
            'reference' => 'nullable|string|max:255',
        ];
    }

    public function save()
    {
        $this->validate();

        try {
            // Actualizar datos del usuario
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            // Actualizar o crear Personal Data
            $personalDataFields = [
                'document_number' => $this->document_number,
                'gender' => $this->gender,
                'birth_date' => $this->birth_date,
                'phone' => $this->phone,
            ];

            // Actualizar avatar si se subió uno nuevo
            if ($this->avatar) {
                $avatarPath = $this->avatar->store('avatars', 'public');
                $personalDataFields['avatar'] = $avatarPath;
            }

            $this->user->personalData()->updateOrCreate(['user_id' => $this->user->id], $personalDataFields);

            // Actualizar o crear Address
            $this->user->address()->updateOrCreate(
                ['user_id' => $this->user->id],
                [
                    'city_id' => $this->city_id,
                    'street' => $this->street,
                    'number' => $this->number,
                    'reference' => $this->reference,
                ],
            );

            $this->success(__('Profile updated successfully!'));

            return redirect()->route('profile.view');
        } catch (\Exception $e) {
            $this->error(__('An error occurred while updating the profile.') . ' ' . $e->getMessage());
        }
    }

    public function genderOptions()
    {
        return [['id' => 'male', 'name' => __('Male')], ['id' => 'female', 'name' => __('Female')]];
    }

    public function with()
    {
        return [
            'cities' => City::orderBy('name')->get(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Edit Profile') }}" separator>
        <x-slot:actions>
            <x-button link="{{ route('profile.view') }}" label="{{ __('Cancel') }}" icon="o-arrow-left" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="save">
        <!-- USER INFORMATION -->
        <x-card title="{{ __('User Information') }}" shadow separator>
            <div class="grid md:grid-cols-2 gap-4">
                <!-- Avatar Upload -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-4">
                        <x-avatar :image="$user->avatar_url" class="w-20 h-20" />
                        <div class="flex-1">
                            <x-file wire:model="avatar" label="{{ __('Change Avatar') }}" accept="image/*"
                                hint="{{ __('Max 2MB - JPG, PNG') }}" />
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <x-input wire:model="name" label="{{ __('Name') }}" icon="o-user"
                    placeholder="{{ __('Your full name') }}" required />

                <!-- Email -->
                <x-input wire:model="email" label="{{ __('Email') }}" icon="o-envelope" type="email"
                    placeholder="{{ __('your@email.com') }}" required />
            </div>
        </x-card>

        <!-- PERSONAL DATA -->
        <x-card title="{{ __('Personal Data') }}" class="mt-6" shadow separator>
            <div class="grid md:grid-cols-2 gap-4">
                <!-- Document Number -->
                <x-input wire:model="document_number" label="{{ __('Document') }}" icon="o-identification"
                    placeholder="{{ __('Document number') }}" />

                <!-- Gender -->
                <x-select wire:model="gender" label="{{ __('Gender') }}" icon="o-user-circle" :options="$this->genderOptions()"
                    placeholder="{{ __('Select gender') }}" />

                <!-- Birth Date -->
                <x-input wire:model="birth_date" label="{{ __('Birth Date') }}" icon="o-calendar" type="date" />

                <!-- Phone -->
                <x-input wire:model="phone" label="{{ __('Phone') }}" icon="o-phone"
                    placeholder="{{ __('Phone number') }}" />
            </div>
        </x-card>

        <!-- ADDRESS INFORMATION -->
        <x-card title="{{ __('Address information') }}" class="mt-6" shadow separator>
            <div class="grid md:grid-cols-2 gap-4">
                <!-- City -->
                <x-select wire:model="city_id" label="{{ __('City') }}" icon="o-building-office-2" :options="$cities"
                    option-value="id" option-label="name" placeholder="{{ __('Select city') }}" />

                <!-- Street -->
                <x-input wire:model="street" label="{{ __('Street') }}" icon="o-map-pin"
                    placeholder="{{ __('Street name') }}" />

                <!-- Number -->
                <x-input wire:model="number" label="{{ __('Number') }}" icon="o-hashtag"
                    placeholder="{{ __('Street number') }}" />

                <!-- Reference -->
                <x-input wire:model="reference" label="{{ __('Reference') }}" icon="o-map"
                    placeholder="{{ __('Additional reference') }}" />
            </div>
        </x-card>

        <!-- ACTION BUTTONS -->
        <div class="flex justify-end gap-3 mt-6">
            <x-button link="{{ route('profile.view') }}" label="{{ __('Cancel') }}" icon="o-x-mark" />

            <x-button type="submit" label="{{ __('Save Changes') }}" icon="o-check" class="btn-primary"
                spinner="save" />
        </div>
    </x-form>
</div>
