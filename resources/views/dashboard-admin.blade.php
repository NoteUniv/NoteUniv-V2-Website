@section('title', __('Admin dashboard'))
@section('icon', __('dashboard-icon'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-y-4 md:gap-y-12">
        <div class="box box--big">
            <div class="flex">
                <div class="mb-4 w-2/3 mr-6">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="title title--underline">MECC</h2>
                        <div class="flex">
                            <div class="bg-nu-gray-100 mr-4 flex items-center rounded-md">
                                <input type="search" id="mecc-search" placeholder="{{ __('Search...') }}"
                                    class="bg-transparent text-nu-secondary px-4 py-2 text-xs border-none">
                                <button class="px-3 h-full">
                                    @svg(search-icon)
                                </button>
                            </div>
                            <div class="relative">
                                <select name="semesters" id="semester-select"
                                    class="appearance-none bg-nu-gray-100 text-nu-secondary pl-4 pr-10 py-2 text-xs rounded-md border-none">
                                    <option value="1">{{ __('Select a promo') }}</option>
                                    <option value="2">Promo 1</option>
                                    <option value="3">Promo 2</option>
                                </select>
                                <div
                                    class="absolute right-4 top-1/2 -translate-y-1/2 w-3 h-3 text-nu-secondary pointer-events-none">
                                    @svg(chevron-down)
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="w-full border-collapse border-l border-b border-r border-nu-gray-200"
                        x-data="{filter: '', sort: 0}">
                        <thead>
                            <tr class="h-12 bg-nu-primary text-sm text-white">
                                <th>
                                    <button class="px-4 w-full h-12 font-semibold text-left flex items-center">
                                        <div class="flex flex-col items-center mr-1">
                                            <div class="w-2 h-1 rotate-180">
                                                @svg(triangle-down)
                                            </div>
                                            <div class="w-2 h-1">
                                                @svg(triangle-down)
                                            </div>
                                        </div>
                                        <span>Date</span>
                                    </button>
                                </th>
                                <th class="w-full">
                                    <button class="px-4 w-full h-12 font-semibold text-left flex items-center">
                                        <div class="flex flex-col items-center mr-1">
                                            <div class="w-2 h-1 rotate-180">
                                                @svg(triangle-down)
                                            </div>
                                            <div class="w-2 h-1">
                                                @svg(triangle-down)
                                            </div>
                                        </div>
                                        <span>{{ __('File') }}</span>
                                    </button>
                                </th>
                                <th class="min-w-[120px] font-semibold text-center">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 0; $i < 5; $i++) : ?>
                            <tr class="h-12 border-b border-nu-gray-200 text-sm">
                                <td class="px-4 text-xs font-semibold">27/05/2021</td>
                                <td class="px-4">nom_du_fichier_mmi_1</td>
                                <td class="px-4 flex h-12 items-center">
                                    <div class="w-1/2 text-center">
                                        <button
                                            class="text-nu-secondary rounded-md p-2 transition-colors duration-200 hover:text-white hover:bg-nu-secondary">
                                            @svg(download-icon)
                                        </button>
                                    </div>
                                    <div class="w-1/2 text-center">
                                        <button
                                            class="text-nu-secondary rounded-md p-2 transition-colors duration-200 hover:text-white hover:bg-nu-secondary">
                                            @svg(upload-icon)
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                    <div
                        class="h-10 border-l border-b border-r border-nu-gray-200 text-xl text-nu-gray-400 bg-nu-gray-100 text-center font-bold tracking-widest cursor-pointer transition-colors duration-200 hover:bg-gray-200 leading-8">
                        ...
                    </div>
                </div>
                <div class="pl-6 w-1/3 border-l border-nu-gray-200">
                    <a href="{{ url('mecc-template') }}"
                        class="btn flex items-center justify-center text-sm w-full text-center">
                        <span class="inline-block w-4 h-4 mr-3">
                            @svg(upload-icon)
                        </span>
                        <span>{{ __('MECC template') }}</span>
                    </a>
                    <div>
                        @if (session()->get('error'))
                            {{ session()->get('error') }}
                        @endif

                        <form action="{{ route('upload-mecc') }}" method="post" enctype="multipart/form-data"
                            id="mecc-upload"
                            class="dropzone w-full border-2 border-nu-gray-400 text-nu-gray-400 text-2xl aspect-square mt-8 flex justify-center items-center transition-colors duration-200 hover:border-nu-green hover:text-nu-green">
                            @csrf
                            <div class="dz-message flex flex-col items-center" data-dz-message>
                                <span>{{ __('Upload a file') }}</span>
                                <div class="w-8 h-8 mt-2">
                                    @svg(plus-icon)
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12 hidden">
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

                    <form action="{{ route('upload-mecc') }}" method="post" enctype="multipart/form-data"
                        id="mecc-upload" class="dropzone h-full">
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

                    <form action="{{ route('upload-grade') }}" method="post" enctype="multipart/form-data"
                        id="grade-upload" class="dropzone h-full">
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
