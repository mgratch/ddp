<!-- FILTER RESULTS LISTINGS CONTENT -->

<ul class="listing">
@foreach($properties as $property)
  <li class="listing-item">
    <a href="#" class="js-ddp-live-get-detail" data-ddp-live-id="{{ $property['id'] }}">
      <div class="listing-image">
        <!-- ASPECT RATIO 26:17 - 520x340px -->
        <img src="http://placehold.it/520x340">
        <div class="listing-price">
          ${{ number_format($property['price'], 0, '', ',') }} {{ $property['term'] ? '/' . $property['term'] : null }}
        </div>
      </div>
      <div class="listing-short-description">{{ $property['features'] }}</div>
      <div class="listing-features">{{ $property['sq_footage'] }} sqft. | {{ $property['rooms'] }} bedrooms</div>
    </a>
  </li>
@endforeach
</ul>

<!-- END FILTER RESULTS LISTINGS -->