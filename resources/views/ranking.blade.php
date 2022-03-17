@section('title', __('Ranking'))
@section('icon', __('ranking-icon'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ranking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @php
                    $user = Auth::user();
                @endphp
                @foreach ($user->averageAllStudents() as $data)
                    <ul class="bg-gray-50 px-4 sm:px-6" @if ($data['student_id'] == $user->student_id) id="me" @endif>
                        @if ($data['rank'])
                            <li>
                                {{ $data['rank'] }} {{ $data['student_id'] }} {{ $data['student_avg'] }}
                            </li>
                        @endif
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
