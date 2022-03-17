@section('title', __('Grades & averages'))
@section('icon', __('grades-icon'))

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Grades & averages') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-y-4 md:gap-y-12">
        @php
            $data = Auth::user()->groupGrades();
            ksort($data);
        @endphp
        @foreach ($data as $ue_id => $subjects)
            <div class="box" x-data="{isOpen: true}">
                <div class="flex justify-between items-center cursor-pointer p-4 xl:p-6" @click="isOpen = !isOpen">
                    <h2 class="title" :class="{'title--underline': isOpen}">UE{{ $ue_id }}</h2>
                    <span class="w-4 h-4 xl:mr-6 transform transition-transform duration-200"
                        :class="{'-rotate-180': isOpen}">
                        @svg(chevron-down)
                    </span>
                </div>
                <div x-cloak x-show="isOpen" class="flex flex-col gap-y-6 px-4 pb-4 pt-2 xl:px-6 xl:pb-6 xl:pt-2">
                    @foreach ($subjects as $subject_id => $subject)
                        @php
                            $subject_name = $subject[0]['subjectName'];
                        @endphp
                        <div x-data="{isOpen: true, desktopVersion: false}">
                            <div class="relative" :class="{'overflow-x-auto': isOpen}">
                                <span
                                    class="hidden xl:inline absolute right-6 top-4 w-4 h-4 text-white transform transition-transform duration-200 pointer-events-none"
                                    :class="{'-rotate-180': isOpen}">@svg(chevron-down)</span>
                                <table class="table w-full border-collapse whitespace-nowrap">
                                    <thead>
                                        <tr class="h-12 text-base bg-nu-primary text-white cursor-pointer"
                                            @click="isOpen = !isOpen; desktopVersion = false">
                                            <th
                                                class="font-semibold text-left px-4 w-3/6 max-w-0 overflow-hidden overflow-ellipsis">
                                                {{ $subject_name }}</th>
                                            <th class="font-semibold px-4 w-1/6" :class="{'min-w-[100px]': isOpen}">
                                                {{ __('Student') }}</th>
                                            <th class="font-semibold px-4 w-2/6 hidden xl:table-cell"
                                                :class="{'min-w-[250px]': isOpen, '!table-cell': desktopVersion}">
                                                {{ __('Class') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr x-cloak x-show="isOpen">
                                            <td colspan="3">
                                                <table
                                                    class="w-full border-collapse border-l border-b border-r border-nu-gray-200">
                                                    <thead class="w-full">
                                                        <tr class="h-12 bg-nu-gray-100 text-sm text-nu-primary">
                                                            <th class="font-semibold text-left px-4 w-3/6">
                                                                {{ __('Work name') }}
                                                            </th>
                                                            <th class="font-semibold px-4 w-1/6 min-w-[100px]">
                                                                {{ __('Grade') }}
                                                            </th>
                                                            <th class="font-semibold px-4 w-2/6 min-w-[250px] hidden xl:table-cell"
                                                                :class="{'!table-cell': desktopVersion}">
                                                                <div class="flex">
                                                                    <span
                                                                        class="w-full">{{ __('Average') }}</span>
                                                                    <span class="w-full">Min</span>
                                                                    <span class="w-full">Max</span>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($subject as $grade_id => $grade)
                                                            <tr class="h-12 text-sm">
                                                                <td class="border border-nu-gray-200 px-4 max-w-0 xl:max-w-none overflow-hidden xl:overflow-visible overflow-ellipsis"
                                                                    :class="{'max-w-none overflow-visible': desktopVersion}">
                                                                    <span>{{ $grade['name'] }}</span>
                                                                    <button
                                                                        class="relative ml-2 w-5 leading-5 bg-nu-secondary rounded-full cursor-pointer hidden xl:inline-block"
                                                                        :class="{'!inline-block':desktopVersion}"
                                                                        x-data="{isInfoOpen: false}"
                                                                        @click="isInfoOpen = true">
                                                                        <span
                                                                            class="text-white font-light text-xs text-center">i</span>
                                                                        <div class="absolute w-max max-w-[180px] -right-2 top-1/2 translate-x-full -translate-y-1/2 text-sm text-nu-primary bg-white rounded-md border-2 border-nu-secondary p-4"
                                                                            x-show="isInfoOpen" @click.stop
                                                                            @click="isInfoOpen = false"
                                                                            @click.outside="isInfoOpen = false">
                                                                            Content for modal
                                                                        </div>
                                                                    </button>
                                                                </td>
                                                                <td
                                                                    class="border border-nu-gray-200 text-center text-lg px-4 font-semibold text-nu-green">
                                                                    {{ $grade['value'] }}</td>
                                                                <td class="border border-nu-gray-200 px-4 text-center hidden xl:table-cell"
                                                                    :class="{'!table-cell': desktopVersion}">
                                                                    <div class="flex">
                                                                        <span
                                                                            class="w-full">{{ $grade['gradeAvg'] }}</span>
                                                                        <span
                                                                            class="w-full">{{ $grade['gradeMin'] }}</span>
                                                                        <span
                                                                            class="w-full">{{ $grade['gradeMax'] }}</span>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr class="h-12 text-sm">
                                                            <td
                                                                class="text-right px-4 font-semibold border border-nu-gray-200">
                                                                {{ __('Average') }}</td>
                                                            <td
                                                                class="text-center px-4 font-semibold bg-nu-green text-nu-primary text-lg border border-nu-gray-200">
                                                                16</td>
                                                            <td class="text-center px-4 font-semibold border border-nu-gray-200 hidden xl:table-cell"
                                                                :class="{'!table-cell': desktopVersion}">
                                                                <div class="flex">
                                                                    <span class="w-full">12</span>
                                                                    <span class="w-full">6</span>
                                                                    <span class="w-full">16</span>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="h-12 text-sm border-l border-b border-r border-nu-gray-200"
                                            x-show="!isOpen">
                                            <td class="text-right px-4 font-semibold">{{ __('Average') }}</td>
                                            <td
                                                class="text-center px4 font-semibold bg-nu-green text-nu-primary text-lg border-l border-r border-nu-gray-200">
                                                16</td>
                                            <td class="text-center px-4 font-semibold hidden xl:table-cell">12</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="xl:hidden mt-4" x-show="isOpen">
                                <p class="text-xs text-nu-gray-400">
                                    {{ __('Some information are hidden on mobile devices.') }}
                                </p>
                                <button class="btn w-full text-xs !font-normal mt-4"
                                    @click="desktopVersion = !desktopVersion"
                                    x-text="desktopVersion?'{{ __('Hide all details') }}':'{{ __('Show all details') }}'"></button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="box box--big col-start-2 col-span-8">
            <h2 class="title title--underline mb-8">{{ __('Overall averages') }}</h2>
            <div class="flex flex-col xl:flex-row justify-between xl:items-end">
                <table class="xl:w-4/6 border-collapse border-l border-b border-r border-nu-gray-200 mb-8 xl:mb-0">
                    <thead>
                        <tr class="h-12 text-base bg-nu-primary text-white">
                            <th class="font-semibold text-left px-4 w-3/4">UE</th>
                            <th class="font-semibold px-4 w-1/4">{{ __('Average') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 0; $i < 2; $i++) : ?>
                        <tr class="h-12">
                            <td class="border border-nu-gray-200 px-4">UE1</td>
                            <td class="border border-nu-gray-200 px-4 text-center font-semibold text-nu-green">18</td>
                        </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
                <div class="xl:max-w-2/6 flex-shrink inline-grid">
                    <h3 class="inline-block font-semibold mb-1 text-center xl:text-left">{{ __('Overall average') }}
                    </h3>
                    <div class="px-12 py-6 bg-nu-green flex justify-center items-end">
                        <span class="text-nu-primary font-normal text-4xl mr-1">14,95</span>
                        <span class="text-nu-gray-400">/ 20</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
