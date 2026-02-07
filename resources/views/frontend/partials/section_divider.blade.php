@php
    $dividerType   = setting('section_divider', 'none');
    if ($dividerType === 'none') return;

    $dividerHeight = (int) setting('divider_height', '60');
    $dividerFlip   = setting('divider_flip', '0');

    $shouldFlip = false;
    if ($dividerFlip === '1') {
        $shouldFlip = true;
    } elseif ($dividerFlip === 'alternate') {
        $shouldFlip = isset($dividerIndex) && $dividerIndex % 2 !== 0;
    }

    $flipStyle = $shouldFlip ? 'transform:scaleY(-1);' : '';
@endphp

<div class="nx-section-divider" style="position:relative;z-index:5;margin-top:-{{ $dividerHeight }}px;height:{{ $dividerHeight }}px;line-height:0;overflow:hidden;pointer-events:none;{{ $flipStyle }}">
    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="width:calc(100% + 2px);height:100%;display:block;margin-left:-1px;">
    @switch($dividerType)
        @case('wave')
            <path d="M0,40 C200,100 400,0 600,60 C800,120 1000,20 1200,80 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('waves-multi')
            <path d="M0,60 C300,120 600,0 1200,60 L1200,120 L0,120 Z" fill="var(--bg,#fff)" opacity="0.33"/>
            <path d="M0,40 C200,80 500,20 700,60 C900,100 1100,20 1200,50 L1200,120 L0,120 Z" fill="var(--bg,#fff)" opacity="0.55"/>
            <path d="M0,50 C150,90 350,10 600,50 C850,90 1050,20 1200,60 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('curve')
            <path d="M0,80 Q600,-20 1200,80 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('tilt')
            <path d="M0,0 L1200,80 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('triangle')
            <path d="M600,0 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('mountains')
            <path d="M0,120 L100,40 L200,80 L350,10 L500,60 L650,20 L800,70 L950,0 L1100,50 L1200,30 L1200,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('clouds')
            <path d="M0,80 C80,50 150,30 250,50 C350,20 400,0 500,30 C600,0 650,10 750,40 C850,10 950,0 1050,30 C1100,50 1150,60 1200,50 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('zigzag')
            <path d="M0,60 L60,20 L120,60 L180,20 L240,60 L300,20 L360,60 L420,20 L480,60 L540,20 L600,60 L660,20 L720,60 L780,20 L840,60 L900,20 L960,60 L1020,20 L1080,60 L1140,20 L1200,60 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('torn')
            <path d="M0,50 L30,62 L60,44 L100,72 L130,34 L170,60 L200,42 L240,70 L280,36 L320,56 L360,40 L400,66 L440,34 L480,58 L520,38 L560,64 L600,46 L640,72 L680,36 L720,56 L760,44 L800,70 L840,30 L880,58 L920,42 L960,66 L1000,48 L1040,72 L1080,38 L1120,62 L1160,46 L1200,56 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('rounded')
            <path d="M0,0 C300,120 900,120 1200,0 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('split')
            <path d="M0,70 L540,70 L600,0 L660,70 L1200,70 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('leaves')
            <path d="M0,50 C100,20 200,80 300,40 C400,0 500,60 600,30 C700,0 800,70 900,40 C1000,10 1100,60 1200,30 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break

        @case('swoosh')
            <path d="M0,0 C0,0 100,120 400,80 C700,40 900,120 1200,100 L1200,120 L0,120 Z" fill="var(--bg,#fff)"/>
            @break
    @endswitch
    </svg>
</div>
