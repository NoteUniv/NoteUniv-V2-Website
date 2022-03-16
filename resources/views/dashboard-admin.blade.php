@section('title', __('Admin dashboard'))
@section('icon', __('dashboard-icon'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h3>{{ __('Files in public/mecc') }}</h3>
                <ul>
                    @foreach ($meccFiles as $file)
                        <li>
                            {{ explode('_', basename($file), 2)[1] }}
                            {{ date('Y-m-d', explode('_', basename($file), 2)[0]) }}

                            <a href="{{ $file }}">
                                {{ __('Export') }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="w-96 h-96">
                    @if (session()->get('error'))
                        {{ session()->get('error') }}
                    @endif

                    <form action="{{ route('upload-mecc') }}" method="post" enctype="multipart/form-data" id="mecc-upload" class="dropzone h-full">
                        @csrf
                        <div class="dz-message" data-dz-message>{{ __('Upload a file ➕') }}</div>
                    </form>
                </div>

                <a href="{{ url('mecc-template') }}">
                    {{ __('Download Mecc Template') }}
                </a>
            </div>

            <br>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h3>{{ __('Files in public/grades') }}</h3>
                <ul>
                    @foreach ($gradeFiles as $file)
                        <li>
                            {{ explode('_', basename($file), 2)[1] }}
                            {{ date('Y-m-d', explode('_', basename($file), 2)[0]) }}

                            <a href="{{ $file }}">
                                {{ __('Export') }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="w-96 h-96">
                    @if (session()->get('error'))
                        {{ session()->get('error') }}
                    @endif

                    <form action="{{ route('upload-grade') }}" method="post" enctype="multipart/form-data" id="grade-upload" class="dropzone h-full">
                        @csrf
                        <div class="dz-message" data-dz-message>{{ __('Upload a file ➕') }}</div>
                    </form>
                </div>

                <a href="{{ url('grades-template') }}">
                    {{ __('Download Grades Template') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Dropzone('#mecc-upload', {
            acceptedFiles: '.xlx,.xls,.xlsx',
            uploadMultiple: false,
            createImageThumbnails: false,
        });

        new Dropzone('#grade-upload', {
            acceptedFiles: '.xlx,.xls,.xlsx',
            uploadMultiple: false,
            createImageThumbnails: false,
        });
    });
</script>
