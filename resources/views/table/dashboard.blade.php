<tr class="h-12 border-b border-nu-gray-200 text-sm">
    <td class="px-4 text-xs font-semibold hidden md:table-cell whitespace-nowrap" :class="{'!table-cell': isOpen}">
        {{ $row['date'] }}</td>
    <td class="px-4 hidden md:table-cell" :class="{'!table-cell': isOpen}">
        {{ Str::limit($row['subject_name'], 5) }}</td>
    <td class="px-4 overflow-ellipsis overflow-hidden">{{ $row['grade_name'] }}</td>
    <td class="px-4 text-center font-semibold text-nu-green">{{ $row['grade_value'] }}
    </td>
    <td class="px-4 text-center hidden md:table-cell" :class="{'!table-cell': isOpen}">
        {{ $row['class_avg'] }}</td>
</tr>
