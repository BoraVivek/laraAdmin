<div class="col-lg-3 col-6">
    <!-- small box -->
    <div {{ $attributes->merge(['class' => 'small-box']) }}>
        <div class="inner">
            <h3>{{ $stats }}</h3>

            <p>{{ $slot }}</p>
        </div>
        <div class="icon">
            <i class="fas {{ $icon }}"></i>
        </div>
        <a href="{{ $url }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
</div>
