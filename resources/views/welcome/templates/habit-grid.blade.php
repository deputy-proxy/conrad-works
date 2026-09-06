@include('welcome.templates._group-header', ['group' => $group])
<div class="mt-4 overflow-x-auto rounded-xl border border-black/10 p-4">
    <div class="min-w-[820px]">
        <div class="mb-2 grid grid-cols-[150px_minmax(0,1fr)] gap-3"><div></div><div class="grid" style="grid-template-columns:repeat({{ count($group['dates']) }},minmax(11px,1fr));gap:3px;">
            @foreach($group['dates'] as $date)<div class="text-center text-[7px] leading-none text-black/35" title="{{ $date['date'] }}">{{ str_ends_with($date['date'],'-01') || $loop->first ? $date['month'] : '' }}</div>@endforeach
        </div></div>
        @foreach($group['rows'] as $row)
            <div class="mb-2 grid grid-cols-[150px_minmax(0,1fr)] items-center gap-3 last:mb-0"><div class="truncate text-[10px] font-medium" title="{{ $row['name'] }}">{{ $row['name'] }}</div><div class="grid" style="grid-template-columns:repeat({{ count($row['cells']) }},minmax(11px,1fr));gap:3px;">
                @foreach($row['cells'] as $cell)<div class="aspect-square rounded-[2px] border {{ !$cell['scheduled'] ? 'border-black/[0.04] bg-black/[0.02]' : ($cell['completed'] ? 'border-black bg-black' : 'border-black bg-white') }}" title="{{ $cell['date'] }} · {{ $cell['completed'] ? 'completed' : ($cell['scheduled'] ? 'not completed' : 'not scheduled') }}"></div>@endforeach
            </div></div>
        @endforeach
    </div>
</div>
