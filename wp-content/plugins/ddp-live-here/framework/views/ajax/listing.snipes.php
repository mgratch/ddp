<ul class="listing">
@foreach($properties as $property)
  <li class="listing-item">
    <a href="#" class="js-ddp-live-get-detail" data-ddp-live-id="{{ $property->id }}">
      <div class="listing-image">
        <!-- ASPECT RATIO 26:17 - 520x340px -->
        @if (!empty($property->images->detailImages[0][0]))
          <img src="{{ $property->images->detailImages[0][0] }}" alt="{{ $property->title }}">
        @else
          <img src="{{ $asset_url . '/images/na.jpg' }}">
        @endif

        <div class="listing-price">
          @if ($property->type === 'rent')
            @if ($property->rent->pricing->lowest == 0)
              Price not Available
            @else
              ${{ $property->rent->pricing->lowest or null }}
              {{ $property->rent->pricing->highest > 0 ? '- '. $property->rent->pricing->highest : null }}
            @endif
          @endif

          @if ($property->type === 'sale')
            @if ($property->sale->price != 0)
              ${{ number_format($property->sale->price, 0, '', ',') }}
            @else
              Price not Available
            @endif
          @endif
        </div>
      </div>
      <div class="listing-short-description">{{ $property->title }}</div>

      <div>
        {{ $property->address }}
      </div>

      @if ($property->type === 'rent')
        <div class="listing-features">
          @foreach ($property->rent->listingDisplay as $lKey => $listing)
            @if ($lKey < (count($property->rent->listingDisplay) - 1))
              {{-- add a comma for multiples --}}
              {{ preg_replace('/bedroom/i', 'BR', $listing) }},
            @else
              {{ preg_replace('/bedroom/i', 'BR', $listing) }}
            @endif
          @endforeach
        </div>
      @endif
    </a>
  </li>
@endforeach
</ul>