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
    <x-header title="Profile" separator />

    <!-- PROFILE DETAILS -->

    <x-avatar :image="@asset('storage/' . $user->avatar_url)" class="w-22">
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
                More Information
            </x-slot:heading>
            <x-slot:content class="grid gap-2">
                <x-icon name="o-phone" label="Phone: {{ $user->phone }}" class="mb-2" />
                <x-icon name="o-calendar" label="Date of Birth: {{ $user->birth_date }}" class="mb-2" />
            </x-slot:content>
        </x-collapse>
    @endif

    @if ($user->address)
        <x-collapse class="mt-6">
            <x-slot:heading>
                Address Information
            </x-slot:heading>
            <x-slot:content class="grid gap-2">
                <x-icon name="o-map" label="Address: {{ $user->full_address }}" class="mb-2" />
            </x-slot:content>
        </x-collapse>
    @endif
</div>
