@section('title', __('Dashboard'))
@section('icon', __('dashboard-icon'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <p>Hey {{ Auth::user()->student_id }}!</p>
            </div>
        </div>
    </div>
</x-app-layout>
