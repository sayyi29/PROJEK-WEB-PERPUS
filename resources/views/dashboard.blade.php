<x-app-layout>
    @if($role == 'admin')
        @include('partials.dashboard-admin')
    @else
        @include('partials.dashboard-member')
    @endif
</x-app-layout>
