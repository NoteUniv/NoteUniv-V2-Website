@section('title', __('Dashboard'))
@section('icon', __('dashboard-icon'))

<x-app-layout>
    <div class="relative flex flex-col xl:flex-row gap-4">
        <div class="box box--big flex-grow" x-data="{isOpen : false}">
            <div class="flex flex-col md:flex-row justify-between xl:items-center mb-6">
                <h2 class="title title--underline mb-6 md:mb-0">{{ __('Last grades') }}</h2>
                <a href="{{ route('grades') }}" class="btn-link">
                    <span>{{ __('View all my grades') }}</span>
                </a>
            </div>
            <div>
                <table
                    class="block xl:table w-full overflow-x-auto border-collapse border-l border-b border-r border-nu-gray-200">
                    <thead>
                        <tr class="h-12 bg-nu-primary text-sm text-white">
                            <th class="font-semibold px-4 text-left whitespace-nowrap hidden md:table-cell"
                                :class="{'!table-cell': isOpen}">{{ __('Date') }}</th>
                            <th class="font-semibold px-4 text-left whitespace-nowrap hidden md:table-cell overflow-hidden"
                                :class="{'!table-cell': isOpen}">{{ __('Subject') }}</th>
                            <th class="font-semibold px-4 text-left whitespace-nowrap hidden md:table-cell"
                                class="font-semibold px-4 text-left whitespace-nowrap hidden md:table-cell"
                                :class="{'!table-cell': isOpen}">{{ __('Subject') }}</th>

                            <th class="font-semibold px-4 whitespace-nowrap">{{ __('My grade') }}</th>
                            <th class="font-semibold px-4 whitespace-nowrap hidden md:table-cell"
                                :class="{'!table-cell': isOpen}">{{ __('Class average') }}</th>
                        </tr>
                    </thead>
                    @php
                        $user = Auth::user();
                        $data = $user->lastGrades();
                    @endphp
                    @livewire('table-rows', ['data' => $data, 'template' => 'table.dashboard'])
                </table>
                <div class="md:hidden mt-4">
                    <p class="text-xs text-nu-gray-400">{{ __('Some information are hidden on mobile devices.') }}
                    </p>
                    <button class="btn w-full text-xs !font-normal mt-4" @click="isOpen = !isOpen"
                        x-text="isOpen?'{{ __('Hide all details') }}':'{{ __('Show all details') }}'"></button>
                </div>
            </div>
        </div>
        <div class="self-start flex flex-col md:flex-row xl:flex-col w-full gap-4 xl:sticky xl:top-4 xl:w-1/4">
            <div class="box box--small min-w-[220px] aspect-square md:flex-grow flex flex-col justify-between">
                <h2 class="title title--underline">{{ __('Overall average') }}</h2>
                <div class="text-center">
                    {{-- <span class="text-grade text-5xl xl:text-4xl">{{ number_format(Auth::user()->overallAverage(), 2) }}</span> --}}
                    <span class="text-grade text-5xl xl:text-4xl">15</span>
                    <span class="text-nu-gray-300 text-xl">/ 20</span>
                </div>
                <a href="{{ route('grades') }}" class="btn-link w-full">
                    <span>{{ __('View my averages') }}</span>
                </a>
            </div>
            <div class="box box--small min-w-[220px] aspect-square md:flex-grow flex flex-col justify-between">
                <h2 class="title title--underline">{{ __('Position in the ranking') }}</h2>
                <div class="text-center">
                    @php
                        $rank = Auth::user()->rank;
                    @endphp
                    <span class="text-nu-primary text-5xl xl:text-4xl">{{ $rank[0] }}</span>
                    <span class="text-nu-gray-300 text-xl">/ {{ $rank[1] }}</span>
                </div>
                <a href="{{ route('ranking') }}" class="btn-link w-full">
                    <span>{{ __('View the ranking') }}</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
