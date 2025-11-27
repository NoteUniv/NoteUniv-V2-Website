@section('title', __('Admin dashboard'))
@section('icon', __('dashboard-icon'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-y-4 md:gap-y-12">
        <div class="box box--big" id="mecc">
            <div class="flex">
                <div class="mb-4 w-2/3 mr-6">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="title title--underline">MECC</h2>
                        <div class="flex">
                            <div class="bg-nu-gray-100 mr-4 flex items-center rounded-md">
                                <input type="search" placeholder="{{ __('Search...') }}" class="bg-transparent text-nu-secondary px-4 py-2 text-xs border-none">
                                <button class="px-3 h-full">
                                    @svg(search-icon)
                                </button>
                            </div>
                            <div class="relative">
                                <select name="semesters" id="promo-select" class="appearance-none bg-nu-gray-100 text-nu-secondary pl-4 pr-10 py-2 text-xs rounded-md border-none">
                                    <option value="1">{{ __('Select a promo') }}</option>
                                    <option value="2">Promo 1</option>
                                    <option value="3">Promo 2</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-3 h-3 text-nu-secondary pointer-events-none">
                                    @svg(chevron-down)
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="w-full border-collapse border-l border-b border-r border-nu-gray-200" x-data="{filter: '', sort: 0}">
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
                        @livewire('table-rows', ['data' => $meccFiles, 'template' => 'table.dashboard-admin'])
                    </table>
                </div>
                <div class="pl-6 w-1/3 border-l border-nu-gray-200">
                    <a href="{{ url('mecc-template') }}" class="btn h-8 flex items-center justify-center text-sm w-full text-center">
                        <span class="inline-block w-3 h-3 mr-3">
                            @svg(download-icon)
                        </span>
                        <span>{{ __('MECC template') }}</span>
                    </a>
                    <div>
                        @if (session()->get('error'))
                            {{ session()->get('error') }}
                        @endif

                        <form action="{{ route('upload-mecc') }}" method="post" enctype="multipart/form-data" id="mecc-upload" class="dropzone w-full !rounded-none !border-2 !border-nu-gray-400 aspect-square mt-8 flex justify-center items-center transition-colors duration-200 hover:!border-nu-green group">
                            @csrf
                            <div class="dz-message flex flex-col items-center text-nu-gray-400 text-2xl transition-colors duration-200 group-hover:text-nu-green" data-dz-message>
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
        <div class="box box--big" id="grades">
            <div class="flex">
                <div class="mb-4 w-2/3 mr-6">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="title title--underline">{{ __('Grades') }}</h2>
                        <div class="flex">
                            <div class="bg-nu-gray-100 mr-4 flex items-center rounded-md">
                                <input type="search" placeholder="{{ __('Search...') }}" class="bg-transparent text-nu-secondary px-4 py-2 text-xs border-none">
                                <button class="px-3 h-full">
                                    @svg(search-icon)
                                </button>
                            </div>
                            <div class="relative">
                                <select name="semesters" id="promo-select" class="appearance-none bg-nu-gray-100 text-nu-secondary pl-4 pr-10 py-2 text-xs rounded-md border-none">
                                    <option value="1">{{ __('Select a promo') }}</option>
                                    <option value="2">Promo 1</option>
                                    <option value="3">Promo 2</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 w-3 h-3 text-nu-secondary pointer-events-none">
                                    @svg(chevron-down)
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="w-full border-collapse border-l border-b border-r border-nu-gray-200" x-data="{filter: '', sort: 0}">
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
                        @livewire('table-rows', ['data' => $gradeFiles, 'template' => 'table.dashboard-admin'])
                    </table>
                </div>
                <div class="pl-6 w-1/3 border-l border-nu-gray-200">
                    <a href="{{ url('grades-template') }}" class="btn h-8 flex items-center justify-center text-sm w-full text-center">
                        <span class="inline-block w-3 h-3 mr-3">
                            @svg(download-icon)
                        </span>
                        <span>{{ __('Grades template') }}</span>
                    </a>
                    <div>
                        @if (session()->get('error'))
                            {{ session()->get('error') }}
                        @endif

                        <form action="{{ route('upload-grade') }}" method="post" enctype="multipart/form-data" id="grades-upload" class="dropzone w-full !rounded-none !border-2 !border-nu-gray-400 aspect-square mt-8 flex justify-center items-center transition-colors duration-200 hover:!border-nu-green group">
                            @csrf
                            <div class="dz-message flex flex-col items-center text-nu-gray-400 text-2xl transition-colors duration-200 group-hover:text-nu-green" data-dz-message>
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
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new Dropzone('#mecc-upload', {
            acceptedFiles: '.xlx,.xls,.xlsx',
            uploadMultiple: false,
            createImageThumbnails: false,
        });

        new Dropzone('#grades-upload', {
            acceptedFiles: '.xlx,.xls,.xlsx',
            uploadMultiple: false,
            createImageThumbnails: false,
        });
    });
</script>
