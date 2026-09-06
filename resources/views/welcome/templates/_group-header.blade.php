<div class="flex items-end justify-between gap-4">
    <h4 class="cw-card-h4 text-[14px]">{{ $group['heading'] }}</h4>
    @if(!empty($group['week_label']))
        <span class="text-[10px] uppercase tracking-[0.16em] text-black/40">{{ $group['week_label'] }}</span>
    @endif
</div>
