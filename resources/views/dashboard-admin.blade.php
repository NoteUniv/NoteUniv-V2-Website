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
                        <li class="list-group-item">
                            {{ explode('_', basename($file), 2)[1] }}
                            {{ date('Y-m-d', explode('_', basename($file), 2)[0]) }}

                            <a href="{{ $file }}">
                                {{ __('Export') }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="col-md-8 w-96 h-96">
                    @if (session()->get('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <form action="{{ route('upload-mecc') }}" method="post" enctype="multipart/form-data" id="image-upload" class="dropzone h-full">
                        @csrf
                        <div class="dz-message" data-dz-message>{{ __('Upload a file ➕') }}</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropzone = new Dropzone('#image-upload', {
            acceptedFiles: '.xlx,.xls,.xlsx',
            uploadMultiple: false,
            createImageThumbnails: false,
        });
    });
</script>
