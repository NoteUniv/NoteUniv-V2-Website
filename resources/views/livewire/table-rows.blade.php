<tbody>
    @each($template, $rows, 'row')
    @if (!$isAtMax)
        <tr class="h-10 border-l border-b border-r border-nu-gray-200 bg-nu-gray-100 text-center cursor-pointer transition-colors duration-200 hover:bg-gray-200"
            wire:click="$emitSelf('showMore')">
            @if ($rows)
                <td class="text-xl text-nu-gray-400 font-bold tracking-widest leading-8" colspan="100%">...</td>
            @else
                <td class="leading-10 text-sm" colspan="100%">{{ __('No files') }}</td>
            @endif
        </tr>
    @endif
</tbody>
