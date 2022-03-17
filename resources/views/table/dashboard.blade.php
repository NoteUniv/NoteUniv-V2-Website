<tr class="h-12 border-b border-nu-gray-200 text-sm cursor-pointer hover:bg-nu-gray-100" @click="window.location.href = '{{ route('grades') }}' + '?id=' + {{ $row['grade_id'] }}">
    <td class="px-4 text-xs font-semibold hidden md:table-cell whitespace-nowrap" :class="{'!table-cell': isOpen}">
        {{ date('d/m/Y', strtotime($row['date'])) }}</td>
    <td class="px-4 hidden md:table-cell" :class="{'!table-cell': isOpen}">
        {{ Str::limit($row['subject_name'], 10) }}</td>
    <td class="px-4 overflow-ellipsis overflow-hidden">{{ $row['grade_name'] }}</td>
    <td class="px-4 text-center font-semibold text-grade">{{ $row['grade_value'] }}
    </td>
    <td class="px-4 text-center hidden md:table-cell" :class="{'!table-cell': isOpen}">
        {{ number_format($row['class_avg'], 2) }}</td>
</tr>
