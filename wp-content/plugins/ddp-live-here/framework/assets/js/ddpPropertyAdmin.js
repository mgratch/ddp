!function(a,b){"use strict";b.PropertyAdmin=function(c){var d=this,e={},f={},g=new b.google.maps.Geocoder,h=c||{};return h=a.extend({loaderSelector:!1},c),d.init=function(){return e.cacheElements(),e.bindActions(),d},e.bindActions=function(){f.$geocodeButton.click(function(){var a=e.getAddress();a.errors===!1&&(d.clearErrors(),e.loader.activate(),d.getGeocode({address:a.address,onSuccess:function(a){f.$latitudeField.val(a.geocodes.k),f.$longitudeField.val(a.geocodes.D),e.loader.deactivate()},onError:function(a){e.loader.deactivate(),b.alert(a)}}))})},e.loader={activate:function(){h.loaderSelector&&a(h.loaderSelector).show()},deactivate:function(){h.loaderSelector&&a(h.loaderSelector).hide()}},e.getAddress=function(){var b=[],c=!1;return a.each(f.address,function(a,e){e.val().length<1?(d.fieldError({$el:e,message:"Field is required for geocode"}),c=!0):b.push(e.val())}),{errors:c,address:b.join(" ")}},e.cacheElements=function(){f.$geocodeButton=a('[data-action="getGeocodes"]'),f.address={$address:a('[data-field-type="address"]'),$city:a('[data-field-type="city"]'),$state:a('[data-field-type="state"]'),$zip:a('[data-field-type="zip"]')},f.$latitudeField=a('[data-field-type="latitude"]'),f.$longitudeField=a('[data-field-type="longitude"]')},d.getGeocode=function(c){return c=c||{},c=a.extend({address:!1,onSuccess:function(){},onError:function(){}},c),c.address===!1?(c.onError({status:"Address is required and expected to be a string"}),!1):void g.geocode({address:c.address},function(a,d){d===b.google.maps.GeocoderStatus.OK?c.onSuccess({status:d,geocodes:a[0].geometry.location}):c.onError({status:d})})},d.fieldError=function(b){b=b||{},b=a.extend({$el:!1,message:!1},b),a('<div class="input-error" style="color:red;">'+b.message+"</div>").appendTo(b.$el.parent())},d.clearErrors=function(){a(".input-error").remove()},d.init()},a(function(){new b.PropertyAdmin({loaderSelector:".js-property-admin-loader"})})}(jQuery,window);