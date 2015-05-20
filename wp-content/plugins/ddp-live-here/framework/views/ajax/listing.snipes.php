<ul class="listing">
@foreach($properties as $property)
  <li class="listing-item">
    <a href="#" class="js-ddp-live-get-detail" data-ddp-live-id="{{ $property->id }}">
      <div class="listing-image">
        <!-- ASPECT RATIO 26:17 - 520x340px -->
        @if ($property->images->listingImage)
          <img src="{{ $property->images->listingImage[0] }}" alt="{{ $property->title }}">
        @else
          <img src="{{ $asset_url . '/images/na.jpg' }}">
        @endif

        <div class="listing-price">
          @if ($property->type === 'rent')
            ${{ $property->rent->pricing->lowest or null }}
            {{ $property->rent->pricing->highest > 0 ? '- '. $property->rent->pricing->highest : null }}
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