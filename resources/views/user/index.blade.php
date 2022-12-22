<x-main-layout>
    <x-user-setting heading="My Account">
        <div class="flex-col items-center w-full text-center truncate">
            <x-dashboard.account-data dataType="Username:" dataToDisplay="{{ $user['username'] }}"/>
            <x-dashboard.account-data dataType="Name:" dataToDisplay="{{ $user['name'] }}"/>
            <x-dashboard.account-data dataType="Email:" dataToDisplay="{{ $user['email'] }}"/>
            <x-dashboard.account-data dataType="Email verified at:" dataToDisplay="{{ $user['email_verified_at'] }}"/>
            <x-dashboard.account-data dataType="Account created at:" dataToDisplay="{{ $user['created_at'] }}"/>
            @can('watch_own_posts')
                <x-dashboard.account-data dataType="Posts created:" dataToDisplay="{{ $posts }}"/>
            @endcan
            <x-dashboard.account-data dataType="Comments written:" dataToDisplay="{{ $comments }}"/>
        </div>
    </x-user-setting>
</x-main-layout>
