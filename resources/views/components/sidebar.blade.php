<div class="w-8 md:w-12 xl:w-auto h-screen flex-shrink-0" x-data="{isOpen: false}">
    <div class="fixed z-20 top-0 left-0 h-screen -translate-x-full transition-transform duration-500 xl:translate-x-0 xl:relative xl:block" :class="{'!translate-x-0': isOpen}">
        <aside class="relative z-20 xl:sticky w-72 xl:w-60 flex flex-col top-0 col-span-2 bg-white h-screen rounded-tr-md shadow-drop">
            <button class="absolute left-full top-0 h-screen w-8 md:w-12 bg-nu-primary text-white rounded-tr-md xl:hidden transition-colors duration-300" :class="{'bg-transparent text-nu-primary':isOpen}" @click="isOpen = !isOpen">
                <div class="absolute top-6 md:top-8 -left-6 md:-left-4 flex items-center -rotate-90 translate-y-full">
                    <span class="uppercase font-medium text-sm tracking-wide">Menu</span>
                    <div class="flex-shrink-0 w-4 h-4 ml-4">
                        <svg width="18" height="8" viewBox="0 0 18 8" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <line x1="1" y1="7" x2="17" y2="7" stroke-width="2" stroke-linecap="round" class="origin-center transition-transform duration-300" :class="{'rotate-45 -translate-y-[2px]':isOpen}" />
                            <line x1="1" y1="1" x2="17" y2="1" stroke-width="2" stroke-linecap="round" class="origin-center transition-transform duration-300" :class="{'-rotate-45 translate-y-[2px]':isOpen}" />
                        </svg>
                    </div>
                </div>
            </button>
            @if (Auth::user()->is_admin)
                <a href="{{ route('dashboard-admin') }}" class="bg-nu-primary w-full aspect-square flex items-center justify-center">
                    <div class="w-2/3 text-white">
                        @svg(logo)
                    </div>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-nu-primary w-full aspect-square flex items-center justify-center">
                    <div class="w-2/3 text-white">
                        @svg(logo)
                    </div>
                </a>
            @endif
            @if (Auth::user()->is_student)
                <div class="relative">
                    <select name="semesters" id="semester-select" class="appearance-none bg-nu-secondary w-full text-white px-6 py-2 focus:outline-none">
                        @php
                            $userData = Auth::user()->data;
                        @endphp
                        @for ($i = 1; $i < $userData['max_semester'] + 1; $i++)
                            <option value="{{ $i }}" @if ($i == $userData['current_semester']) selected @endif>
                                {{ __('Semester') }} {{ $i }}
                            </option>
                        @endfor
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white">
                        @svg(chevron-down)
                    </div>
                </div>
                <div class="bg-nu-gray-100 w-full py-4 text-center">
                    <p class="mb-2">{{ __('Overall average') }}</p>
                    <div>
                        {{-- <span class="text-grade text-2xl">{{ number_format(Auth::user()->overallAverage(), 2) }}</span> --}}
                        <span class="text-nu-gray-300">/ 20</span>
                    </div>
                </div>
            @endif
            <nav class="flex-grow py-10 px-6 text-lg font-medium">
                <ul class="flex flex-col gap-y-8">
                    @if (Auth::user()->is_admin)
                        <!-- Navigation Links -->
                        <li>
                            <x-nav-link href="{{ route('dashboard-admin') }}" :active="request()->routeIs('dashboard-admin')">
                                <div class="w-3 mr-4 transform scale-150">
                                    @svg(dashboard-icon)
                                </div>
                                <p class="text-sm">{{ __('Admin dashboard') }}</p>
                            </x-nav-link>
                        </li>
                    @endif
                    @if (Auth::user()->is_student)
                        <!-- Navigation Links -->
                        <li>
                            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                <div class="w-3 mr-4 transform scale-150">
                                    @svg(dashboard-icon)
                                </div>
                                <p class="text-sm">{{ __('Dashboard') }}</p>
                            </x-nav-link>
                        </li>

                        <li>
                            <x-nav-link href="{{ route('grades') }}" :active="request()->routeIs('grades')">
                                <div class="w-3 mr-4 transform scale-150">
                                    @svg(grades-icon)
                                </div>
                                <p class="text-sm">{{ __('Grades & averages') }}</p>
                            </x-nav-link>
                        </li>

                        <li>
                            <x-nav-link href="{{ route('ranking') }}" :active="request()->routeIs('ranking')">
                                <div class="w-3 mr-4 transform scale-150">
                                    @svg(ranking-icon)
                                </div>
                                <p class="text-sm">{{ __('Ranking') }}</p>
                            </x-nav-link>
                        </li>
                    @endif
                </ul>
            </nav>
        </aside>
    </div>
    <div class="fixed z-10 left-0 top-0 w-screen h-screen bg-white/80 backdrop-filter backdrop-blur-sm xl:hidden" x-cloak x-show="isOpen" @click="isOpen = false">
    </div>
</div>
