<div class="single-listing-detail-content js-ddp-live-detail-container">
  <button type="button" class="js-close-detail close-detail"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="15px" height="15px" viewBox="0 0 15 15" enable-background="new 0 0 15 15" xml:space="preserve" version="1.1" id="Layer_1"><polygon fill="currentColor" points="15,12.603 9.897,7.5 15,2.397 12.603,0 7.5,5.103 2.397,0 0,2.397 5.103,7.5 0,12.603 2.397,15 7.5,9.897 12.603,15"/></svg></button>

  <div class="scroll-content">
    @if ($property->images->detailImages)
      <ul class="listing-carousel js-listing-carousel">
        @foreach ($property->images->detailImages as $number => $image)
          <li class="slide">
            {{-- ASPECT RATIO 3:2 - 1080x720px --}}
            <img src="{{ $image[0] }}" alt="{{ $property->title }} Photo #{{ $number }}">
          </li>
        @endforeach
      </ul>
    @endif

    <div class="listing-details">
      <h2 class="listing-detail-name">{{ $property->title }}</h2>
      {{-- <span class="listing-detail-price">$0,000 - $0,000/month</span> --}}
      @if ($property->type === 'sale')
        {{ $property->price }}
      @endif
    </div>
    <div class="detail-content">

      @if ($property->type === 'rent')
        <h3 class="section-title">Units</h3>
        <ul class="listing-unit-types">
          @foreach ($property->rent->listings as $listing)
            <li class="unit-type {{ $listing->available ? 'available' : null }}">
              {{ $listing->title }}: ${{ $listing->priceLow }} {{ !empty($listing->priceHigh) ? '- ' . $listing->priceHigh : null }}
              @if (!empty($listing->sqFeetLow))
              | {{ $listing->sqFeetLow }} {{ !empty($listing->sqFeetHigh) ? '- ' . $listing->sqFeetHigh : null }} sq.ft.
              @endif
            </li>
          @endforeach
        </ul>
      @endif

      <h3 class="section-title">Description</h3>

      {{ apply_filters('the_content', $property->description) }}

      @if ($property->type === 'rent')
      <h3 class="section-title">Features</h3>
      <ul class="unit-features">
        @if ($property->rent->attributes->pets)
          <li class="unit-feature">
            <span class="icon-pets">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="21.999px" height="21px" viewBox="0 0 21.999 21" enable-background="new 0 0 21.999 21" xml:space="preserve"><path fill="currentColor" d="M19.012 16.945c0 2.24-1.844 4.055-4.121 4.055c-0.621 0-1.209-0.139-1.738-0.381c-0.799-0.256-1.521-0.33-2.153-0.309 c-0.632-0.021-1.354 0.053-2.153 0.309C8.318 20.9 7.7 21 7.1 21c-2.277 0-4.122-1.814-4.122-4.055 c0-1.574 0.953-2.865 2.246-3.607c0.615-0.354 1.351-0.922 2.205-2.479c0.674-1.23 1.616-2.18 3.562-2.18 c1.946 0 2.9 0.9 3.6 2.18c0.854 1.6 1.6 2.1 2.2 2.479C18.061 14.1 19 15.4 19 16.945z M0.889 6.3 c-0.962 0.939-1.832 4.9 1.3 5.791c2.556 0.8 3.662-2.224 2.033-4.163C2.417 5.7 1.8 5.4 0.9 6.268z M9.992 3.7 C9.142 0.8 8.646-0.295 6.9 0.067C6.085 0.2 4.2 2 4.7 4.849c0.455 2.9 2.5 2.5 2.9 2.5 C7.909 7.4 10.8 6.7 10 3.743z M17.773 7.896c-1.629 1.939-0.521 4.9 2 4.163c3.133-0.938 2.264-4.852 1.303-5.791 C20.246 5.4 19.6 5.7 17.8 7.896z M14.463 7.383c0.373-0.004 2.4 0.3 2.861-2.534c0.455-2.864-1.412-4.62-2.193-4.781 c-1.777-0.362-2.273 0.722-3.123 3.676C11.158 6.7 14.1 7.4 14.5 7.383z"/></svg>
            </span>
            Pet Friendly
          </li>
        @endif

        @if($property->rent->attributes->fitness)
          <li class="unit-feature">
            <span class="icon-fitness">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="23px" height="22px" viewBox="0 0 23 22" enable-background="new 0 0 23 22" xml:space="preserve"><path fill="currentColor" d="M7.243 7.269L5.009 14.67c-0.493-0.164-1.413-0.303-1.98-0.426c-0.636-0.139-1.435-0.469-2.026 0.1 c-0.211 0.201-0.318 0.48-0.316 0.762l0.042 0.291c0.073 0.3 0.2 0.5 0.5 0.637c0.329 0.2 1.5 0.4 2 0.6 c1.224 0.3 3.1 1.2 3.653-0.168l1.407-3.473l2.934 1.113c0.138 0.875-0.722 3.754-0.25 4.439c0.222 0.3 0.6 0.5 1 0.5 l0.3-0.039c0.218-0.057 0.424-0.176 0.586-0.365c0.295-0.344 0.678-3.564 0.772-4.223c0.105-0.738 0.389-1.537-0.393-1.996 l-3.885-1.417c0.144-0.581 0.539-1.37 0.779-1.949c0.145-0.35 0.5-1.791 0.972-1.628c1.799 0.6 2.5 1.7 3.786-0.164 c0.611-0.936 2.41-2.798 1.018-3.625c-1.596-0.948-2.213 2.45-3.146 2.229c-1.263-0.298-3.276-1.174-4.537-1.018 c-0.799 0.1-1.83 0.403-2.623 0.611C4.597 5.7 3.7 5.5 3.6 6.552c-0.122 1.015-1.078 4 0.9 3.8 c0.828-0.106 0.822-1.242 0.904-1.845c0.059-0.428-0.028-0.859 0.42-0.953C6.234 7.5 6.9 7.3 7.2 7.269L7.243 7.269z M9.817 0c1.301 0 2.4 1 2.4 2.233c0 1.233-1.055 2.232-2.356 2.232s-2.356-1-2.356-2.232C7.461 1 8.5 0 9.8 0L9.817 0z M16.712 9.611c-0.63 0-1.14 0.483-1.14 1.08s0.51 1.1 1.1 1.08h1.425l-3.352 8.069H1.14C0.51 19.8 0 20.3 0 20.9 S0.51 22 1.1 22h14.419c0.508 0 0.938-0.316 1.086-0.75l3.938-9.479h1.277c0.63 0 1.141-0.484 1.141-1.08s-0.511-1.08-1.141-1.08 H16.712L16.712 9.611z"/></svg>
            </span>
            Fitness Center
          </li>
        @endif

        @if ($property->rent->attributes->parking)
          <li class="unit-feature">
            <span class="icon-parking">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="23px" height="23px" viewBox="0 0 23 23" enable-background="new 0 0 23 23" xml:space="preserve"><g><path fill="currentColor" d="M18 0H5C2.238 0 0 2.2 0 5v13c0 2.8 2.2 5 5 5h13c2.762 0 5-2.238 5-5V5C23 2.2 20.8 0 18 0z M21 18 c0 1.654-1.346 3-3 3H5c-1.654 0-3-1.346-3-3V5c0-1.654 1.346-3 3-3h13c1.654 0 3 1.3 3 3V18z"/><path fill="currentColor" d="M12.36 6.175H8.25v10.649h1.935V13.15h2.176c1.994 0 3.39-1.44 3.39-3.51S14.354 6.2 12.4 6.175z M12 11.47h-1.815V7.84 h1.846c1.095 0 1.8 0.7 1.8 1.8C13.785 10.8 13.1 11.5 12 11.47z"/></g></svg>
            </span>
            Parking Included
          </li>
        @endif

        @if ($property->rent->attributes->washer_dryer)
          <li class="unit-feature">
            <span class="icon-in-unit">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" width="19px" height="24px" viewBox="0 0 19 24" enable-background="new 0 0 19 24" xml:space="preserve"><path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M4.979 24H2.118v-0.83H0.737H0v-0.723V0.722V0h0.737h17.526H19v0.722v21.726v0.723 h-0.736h-1.382V24h-2.86v-0.83H4.979V24L4.979 24z M16.002 3.251V2.168h-1.459v1.083H16.002L16.002 3.251z M6.634 3.251V2.168H2.999 v1.083H6.634L6.634 3.251z M13.705 3.251V2.168h-1.458v1.083H13.705L13.705 3.251z M9.5 7.301c-3.017 0-5.466 2.399-5.466 5.4 c0 3 2.4 5.4 5.5 5.353c3.016 0 5.466-2.4 5.466-5.353C14.966 9.7 12.5 7.3 9.5 7.301L9.5 7.301z M12.975 14.6 c-0.625-0.422-1.034-1.127-1.034-1.927s0.409-1.506 1.034-1.929C12.288 9.5 11 8.7 9.5 8.7 c-2.206 0-3.991 1.748-3.991 3.91c0 2.2 1.8 3.9 4 3.909C10.991 16.6 12.3 15.8 13 14.582L12.975 14.582z M17.525 1.444H1.475v2.498h16.051V1.444L17.525 1.444z M1.475 5.386v16.339h16.051V5.386H1.475z"/></svg>
            </span>
            Washer/Dryer
          </li>
        @endif
          <li class="unit-feature"></li>
          <li class="unit-feature"></li>
        </ul>
      @endif

      <h3 class="section-title">Contact Information</h3>
      <div class="listing-contact-info">
        @if (!empty($property->agent->name))
          <span class="listing-contact-name">{{ $property->agent->name }}</span>
        @endif
        @if (!empty($property->agent->phone))
          <span class="listing-contact-phone">t: <a href="tel:{{ $property->agent->phone }}">{{ $property->agent->phone }}</a></span>
        @endif
        @if ($property->agent->email)
          <span class="listing-contact-email">e: <a href="mailto:{{ $property->agent->email }}">{{ $property->agent->email }}</a></span>
        @endif
        {{-- <span class="listing-contact-website">w: <a href="">smithandsmith.com</a></span> --}}
      </div>
    </div>
  </div>
</div>