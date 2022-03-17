@section('title', __('Ranking'))
@section('icon', __('ranking-icon'))

<x-app-layout>
    <div class="box box--big col-start-2 col-span-8">
        <div class="flex flex-col md:flex-row justify-between mb-1 items-center">
            <a href="#current" class="btn text-center mb-4 px-6 md:mb-0">{{ __('Go to my rank') }}</a>
            <a href="" class="btn-link">{{ __('Remove me from the ranking') }}</a>
        </div>
        <div class="sticky top-0 h-6 bg-white w-full outline outline-1 outline-white"></div>
        <table class="w-full border-collapse">
            <thead class="sticky top-6">
                <tr class="h-12 text-base bg-nu-primary text-white">
                    <th class="font-semibold w-1/3">{{ __('Rank') }}</th>
                    <th class="font-semibold w-1/3">{{ __('Student') }}</th>
                    <th class="font-semibold w-1/3">{{ __('Average') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $user = Auth::user();
                @endphp
                @foreach ($user->averageAllStudents() as $data)
                    @if ($data['rank'])
                        <tr class="h-12 text-center" @if ($data['student_id'] == $user->student_id) x-data :class="'text-nu-green font-semibold scroll-mt-20'" id="current" @endif>
                            <td class="border border-nu-gray-200">{{ $data['rank'] }}</td>
                            <td class="border border-nu-gray-200">{{ $data['student_id'] }}</td>
                            <td class="border border-nu-gray-200">{{ number_format($data['student_avg'], 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
