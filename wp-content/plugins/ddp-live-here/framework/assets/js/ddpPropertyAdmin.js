!function(a,b){"use strict";var c=function(c){var d=this,e={},f={},g=new b.google.maps.Geocoder,h=c||{};return h=a.extend({loaderSelector:!1,metaBoxSelector:!1},c),d.init=function(){return h.metaBoxSelector===!1?(console.warn("MetaGeocode metaBoxSelector attribute missing"),!1):(e.cacheElements(),e.bindActions(),d)},e.bindActions=function(){f.$geocodeButton.click(function(){var c=e.getAddress();c.errors===!1&&(d.clearErrors(),e.loader.activate(),d.getGeocode({address:c.address,onSuccess:function(b){var c=[];a.each(b.geocodes,function(a,b){c.push(b)}),f.$latitudeField.val(c[0]),f.$longitudeField.val(c[1]),e.loader.deactivate()},onError:function(a){e.loader.deactivate(),b.alert(a)}}))})},e.loader={activate:function(){h.loaderSelector&&a(h.loaderSelector).show()},deactivate:function(){h.loaderSelector&&a(h.loaderSelector).hide()}},e.getAddress=function(){var b=[],c=!1;return a.each(f.address,function(a,e){e.val().length<1?(d.fieldError({$el:e,message:"Field is required for geocode"}),c=!0):b.push(e.val())}),{errors:c,address:b.join(" ")}},e.cacheElements=function(){f.$metaBox=a(h.metaBoxSelector),f.$geocodeButton=f.$metaBox.find('[data-action="getGeocodes"]'),f.address={$address:f.$metaBox.find('[data-field-type="address"]'),$city:f.$metaBox.find('[data-field-type="city"]'),$state:f.$metaBox.find('[data-field-type="state"]'),$zip:f.$metaBox.find('[data-field-type="zip"]')},f.$latitudeField=f.$metaBox.find('[data-field-type="latitude"]'),f.$longitudeField=f.$metaBox.find('[data-field-type="longitude"]')},d.getGeocode=function(c){return c=c||{},c=a.extend({address:!1,onSuccess:function(){},onError:function(){}},c),c.address===!1?(c.onError({status:"Address is required and expected to be a string"}),!1):void g.geocode({address:c.address},function(a,d){d===b.google.maps.GeocoderStatus.OK?c.onSuccess({status:d,geocodes:a[0].geometry.location}):c.onError({status:d})})},d.fieldError=function(b){b=b||{},b=a.extend({$el:!1,message:!1},b),a('<div class="input-error" style="color:red;">'+b.message+"</div>").appendTo(b.$el.parent())},d.clearErrors=function(){a(".input-error").remove()},d.init()};b.MetaGeocode=c}(jQuery,window),function(a,b){"use strict";var c=function(b){b=b||{};var c=this,d={},e={},f={};c.init=function(){return e.cacheElements(),e.bindEvents(),d.$typeSelect.change(),c},e.cacheElements=function(){d.$typeSelect=a('[data-js="typeSelect"]'),d.$rentAtributes=a("#rent-attributes"),d.$saleAtributes=a("#sale-attributes")},e.bindEvents=function(){d.$typeSelect.change(function(){var b=a(this);f.typeSelect(b)})},f.typeSelect=function(a){var b=a.val();return d.$rentAtributes.hide(),d.$saleAtributes.hide(),"rent"===b&&d.$rentAtributes.show(),"sale"===b&&d.$saleAtributes.show(),b},c.init()};b.ddpPropertyAdmin=c}(jQuery,window),jQuery(function(){"use strict";new window.MetaGeocode({loaderSelector:".js-property-admin-loader",metaBoxSelector:"#property-attributes"}),new window.ddpPropertyAdmin});