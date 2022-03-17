<tr class="h-12 border-b border-nu-gray-200 text-sm">
    <td class="px-4 text-xs font-semibold whitespace-nowrap">
        {{ date('d/m/Y', explode('_', basename($row), 2)[0]) }}</td>
    <td class="px-4">{{ explode('_', basename($row), 2)[1] }}</td>
    <td class="px-4 flex gap-x-2 h-12 items-center justify-center">
        <button class="text-nu-secondary rounded-md p-2 transition-colors duration-200 hover:text-white hover:bg-nu-secondary">
            @svg(upload-icon)
        </button>
        <a href="{{ $row }}" class="inline-block text-nu-secondary rounded-md p-2 transition-colors duration-200 hover:text-white hover:bg-nu-secondary">
            @svg(download-icon)
        </a>
    </td>
</tr>
