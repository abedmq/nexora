{{-- Custom HTML Section --}}
<section style="padding:40px 0;">
    <div class="container">
        @if($section->title)<div class="section-title"><h2>{{ $section->title }}</h2></div>@endif
        {!! $section->content !!}
    </div>
</section>
