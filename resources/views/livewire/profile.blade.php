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
        $this->user = User::findOrFail(Auth::id());
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Profile') }}" separator />

    <!-- PROFILE DETAILS -->

    <x-avatar :image="@asset('storage/' . $user->avatar_url ?? 'images/default-avatar.jpg')"
        class="w-22">
        <x-slot:title class="text-3xl font-bold pl-2">
            {{ $user->name }}
        </x-slot:title>

        <x-slot:subtitle class="grid gap-1 mt-2 pl-2">
            <x-icon name="o-envelope" label="{{ $user->email }}" />
        </x-slot:subtitle>
    </x-avatar>

    @if ($user->personalData)
        <x-collapse class="mt-6">
            <x-slot:heading>
                {{ __('Personal information') }}
            </x-slot:heading>
            <x-slot:content class="grid gap-2">
                <x-icon name="o-phone" label="{{ $user->phone }}" class="mb-2" />
                <x-icon name="o-calendar" label="{{ $user->birth_date }}" class="mb-2" />
            </x-slot:content>
        </x-collapse>
    @endif

    @if ($user->address)
        <x-collapse class="mt-6">
            <x-slot:heading>
                {{ __('Address information') }}
            </x-slot:heading>
            <x-slot:content class="grid gap-2">
                <x-icon name="o-map" label="{{ $user->full_address }}" class="mb-2" />
            </x-slot:content>
        </x-collapse>
    @endif
</div>
