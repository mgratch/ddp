<ul class="listing">
@foreach($properties as $property)
  <li class="listing-item">
    <a href="#" class="js-ddp-live-get-detail" data-ddp-live-id="{{ $property->id }}">
      <div class="listing-image">
        <!-- ASPECT RATIO 26:17 - 520x340px -->
        <img src="http://placehold.it/520x340">

        <div class="listing-price">
          @if ($property->type === 'rent')

          @endif

          @if ($property->type === 'sale')
            ${{ number_format($property->sale->price, 0, '', ',') }}
          @endif
        </div>
      </div>
      <div class="listing-short-description">{{ $property->title }}</div>

      @if ($property->type === 'rent')
        <div class="listing-features">
          @foreach ($property->rent->listings as $lKey => $listing)
            @if ($lKey < (count($property->rent->listings) - 1))
              {{ $listing->title }},
            @else
              {{ $listing->title }}
            @endif
          @endforeach
        </div>
      @endif

    </a>
  </li>
@endforeach
</ul>