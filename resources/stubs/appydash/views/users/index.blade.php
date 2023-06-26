<x-app-layout>
    <x-section-header>
        <x-slot:title>All Users</x-slot:title>
    </x-section-header>

    <section class="user-list-table">
        @include('users.partials.list-users')
    </section>  
</x-app-layout>
