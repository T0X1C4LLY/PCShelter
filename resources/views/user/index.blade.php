<x-main-layout>
    <x-user-setting heading="Manage Your account">
        <div class="flex-col items-center w-full text-center truncate">
            <x-dashboard.account-data dataType="Username:" dataToDisplay="{{ $user[0]->username }}"/>
            <x-dashboard.account-data dataType="Email:" dataToDisplay="{{ $user[0]->email }}"/>
            <x-dashboard.account-data dataType="Email verified at:" dataToDisplay="{{ $user[0]->email_verified_at }}"/>
            <x-dashboard.account-data dataType="Account created at:" dataToDisplay="{{ $user[0]->created_at }}"/>
            <x-dashboard.account-data dataType="Posts created:" dataToDisplay="{{ count($posts) }}"/>
            <x-dashboard.account-data dataType="Comments written:" dataToDisplay="{{ count($comments) }}"/>
        </div>
    </x-user-setting>
</x-main-layout>
