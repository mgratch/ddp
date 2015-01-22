var geocoder, map, gmarkers, infoBox, infoBoxArray;// = new google.maps.Geocoder();

var marker_files = [];
marker_files['Attractions'] = 'pushpin-attractions.png';
marker_files['Lighthouse'] = 'pushpin-lighthouse.png';
marker_files['Shopping'] = 'pushpin-shopping.png';
marker_files['FoodBars'] = 'pushpin-foodbars.png';

infoBoxArray = [];

function initialize(plugin_url, zoomval) {
	//console.log(plugin_url);
	var mapOptions = {
    	zoom: zoomval,
    	scrollwheel: false,
    	//draggable: false,
    };
    gmarkers = [];
    map = new google.maps.Map(document.getElementById("map-canvas"),
        mapOptions);
	geocoder = new google.maps.Geocoder();
	geocoder.geocode( { 'address': '48226'}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        //Got result, center the map and put it out there
        map.setCenter(results[0].geometry.location);
        var i = 0;
        var currentWindow;
        
        for(var key in dataObj){
        	var nextLocation = dataObj[key];
        	//console.log(nextLocation);

        	var infowindow = new google.maps.InfoWindow();
					
        	var markerImage = new google.maps.MarkerImage(plugin_url+"images/"+marker_files[nextLocation.slug],
		      // This marker is 20 pixels wide by 34 pixels tall.
		      new google.maps.Size(18, 27),
		      // The origin for this image is 0,0.
		      new google.maps.Point(0,0),
		      // The anchor for this image is at 6,20.
		      new google.maps.Point(9, 27));


    		var marker = new google.maps.Marker({
	            map: map,
	            position: new google.maps.LatLng(nextLocation.lat, nextLocation.lon),
	            icon: markerImage
	        });

	        marker.category = nextLocation.slug;
	        marker.infoBoxIndex = i;

	        var subcat = (nextLocation.subcat.length > 0) ? "<li>Sub-category: "+nextLocation.subcat+"</li>" : "";
					
						
						if (nextLocation.url != undefined && nextLocation.url.length > 1) {
							var blank = '';
						} else {
							var blank = 'onclick="return false;"';	
						}
						
						url = "<a href='http://"+nextLocation.url+"' target='_blank' "+blank+">"+nextLocation.name+"</a>";
						
		        var info = "<div class='infobox-wrapper "+nextLocation.slug+"'>"+url+"<ul><li>"+nextLocation.address+"</li><li>Category: "+nextLocation.category+"</li>"+subcat+"<li>Phone: "+nextLocation.phone+"</li></ul></div>";
	
		        infoBoxArray[i] = new InfoBox(
	                {
	                        latlng: marker.getPosition(),
	                        map: map,
	                        content: info,
	                        pixelOffset: new google.maps.Size(-121, -239)
	                });

	        //console.log(infoBoxArray[i]);
    		

	        google.maps.event.addListener(marker, 'click', function(){
	        	if (infoBox) infoBox.close();
	        	console.log(this.infoBoxIndex);
	        	infoBox = infoBoxArray[this.infoBoxIndex];
                infoBox.open(map, this);
	        });



	       //  	(function(marker,info,infowindow) {
		      //   return function() {
		      //     infowindow.setContent(info);
		      //     infowindow.open(map, marker);
		      //     if(currentWindow){ currentWindow.close(); }
		      //     currentWindow = infowindow;
		      //   }
		      // })(marker,info,infowindow));

	        i++;

	        gmarkers.push(marker);
	        // geocoder.geocode({'address': nextLocation.address}, function(results, status){

	        // 	if(status == google.maps.GeocoderStatus.OK){
	        // 		var marker = new google.maps.Marker({
			      //       map: map,
			      //       position: results[0].geometry.location
			      //   });
	        // 	}

	        // });
	    }

      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
    
}

jQuery(document).ready(function($){

	
	

});
















