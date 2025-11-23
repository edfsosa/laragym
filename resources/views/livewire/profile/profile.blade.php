<?php

use App\Models\User;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;

new #[Title('Profile')] class extends Component {
    use Toast;

    public User $user;

    public function mount()
    {
        $this->user = User::with(['personalData', 'address.city'])->findOrFail(Auth::id());
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Profile') }}" separator />

    <!-- USER AVATAR AND NAME -->
    <x-card title="{{ __('User Information') }}" shadow separator>
        <x-avatar :image="$user->avatar_url" class="w-22">
            <x-slot:title class="text-3xl font-bold pl-2">
                {{ $user->name }}
            </x-slot:title>

            <x-slot:subtitle class="grid gap-1 mt-2 pl-2 text-xs">
                <x-icon name="o-envelope" label="{{ $user->email }}" />
                <x-icon name="o-calendar" label="{{ __('Member since') }} {{ $user->created_at->format('d/m/Y') }}" />
                <x-badge value="{{ $user->status_translated }}" class="{{ $user->status_badge_class }}" />
            </x-slot:subtitle>
        </x-avatar>
        <x-slot:menu>
            <x-button link="{{ route('profile.edit') }}" label="{{ __('Edit Profile') }}" icon="o-pencil"
                class="btn-primary" />
        </x-slot:menu>
    </x-card>

    <!-- PERSONAL DATA -->
    <x-card title="{{ __('Personal Data') }}" class="mt-6" shadow separator>
        @if ($user->personalData)
            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <strong>{{ __('Document') }}</strong>
                    <div>{{ $user->personalData->document_number ?? __('Not specified') }}</div>
                </div>

                <div>
                    <strong>{{ __('Gender') }}</strong>
                    <div>{{ $user->personalData->gender_translated ?? __('Not specified') }}</div>
                </div>

                <div>
                    <strong>{{ __('Birth Date') }}</strong>
                    <div>
                        {{ $user->personalData->birth_date_formatted ?? __('Not specified') }}
                    </div>
                </div>

                <div>
                    <strong>{{ __('Phone') }}</strong>
                    <div>{{ $user->personalData->phone ?? __('Not specified') }}</div>
                </div>
            </div>
        @else
            <div class="text-center text-gray-500 text-sm">
                <p class="mb-4">
                    {{ __('No personal data available.') }}
                </p>
                <x-button link="{{ route('profile.edit') }}" label="{{ __('Add information') }}" icon="o-plus"
                    class="btn-primary" />
            </div>
        @endif
    </x-card>

    <!-- ADDRESS INFORMATION -->
    <x-card title="{{ __('Address information') }} " class="mt-6" shadow separator>
        @if ($user->address)
            <div class="grid md:grid-cols-2 gap-4 text-sm">
                <div>
                    <strong>{{ __('Street') }}</strong>
                    <div>{{ $user->address->street ?? __('Not specified') }}</div>
                </div>

                <div>
                    <strong>{{ __('Number') }}</strong>
                    <div>{{ $user->address->number ?? __('Not specified') }}</div>
                </div>

                <div>
                    <strong>{{ __('City') }}</strong>
                    <div>{{ $user->address->city->name ?? __('Not specified') }}</div>
                </div>

                <div>
                    <strong>{{ __('Reference') }}</strong>
                    <div>{{ $user->address->reference ?? __('Not specified') }}</div>
                </div>
            </div>
        @else
            <div class="text-center text-gray-500 text-sm">
                <p class="mb-4">
                    {{ __('No address information available.') }}
                </p>
                <x-button link="{{ route('profile.edit') }}" label="{{ __('Add information') }}" icon="o-plus"
                    class="btn-primary" />
            </div>
        @endif
    </x-card>
</div>
