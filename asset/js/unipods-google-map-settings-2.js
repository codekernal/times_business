jQuery(function ($) {
  /* You can safely use $ in this code block to reference jQuery */

$(document).ready(function() {



                  function initialize() {                



                    // Create an array of styles
                    // Use http://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html
                    var unipodsStyles = [
                  {
                    stylers: [
                      { lightness: 5 },
                      { gamma: 1.18 },
                      { saturation: -87 }
                    ]
                  },{
                    featureType: "road",
                    stylers: [
                      { hue: "#ff0008" },
                      { saturation: -17 },
                      { lightness: -9 }
                    ]
                  },{
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                      { saturation: 35 },
                      { hue: "#0099ff" },
                      { lightness: -15 }
                    ]
                  },{
                    featureType: "administrative.country",
                    stylers: [
                      { hue: "#ff0022" },
                      { saturation: -40 },
                      { lightness: 10 }
                    ]
                  },{
                    featureType: "road.highway",
                    stylers: [
                      { hue: "#ffc300" },
                      { saturation: -75 },
                      { gamma: 1.58 },
                      { lightness: -10 }
                    ]
                  },{
                    featureType: "road.highway",
                    elementType: "labels",
                    stylers: [
                      { saturation: -64 },
                      { lightness: 24 }
                    ]
                  },{
                    featureType: "road.highway",
                    elementType: "geometry",
                    stylers: [
                      { saturation: 20 }
                    ]
                  },{
                    featureType: "road.arterial",
                    elementType: "labels",
                    stylers: [
                      { lightness: 59 },
                      { saturation: -63 },
                      { gamma: 0.82 }
                    ]
                  },{
                  }
                ];

                    // Unipods Location
                    var unipodsMapType = new google.maps.StyledMapType(unipodsStyles,
                      {name: "Romeo"});

                    // Unipods Location
                    var myLatlng = new google.maps.LatLng(25.40436,55.980234);

                    var mapOptions = {
                      zoom: 10,
                      center: new google.maps.LatLng(25.39242,55.736389),
                      mapTypeControlOptions: {
                        mapTypeIds: ['unipods_menu'] 
                        // add this back in before 'unipods_menu' to restore google styles google.maps.MapTypeId.ROADMAP, 
                    }};



                    var map = new google.maps.Map(document.getElementById('map'),
                      mapOptions);

                    map.mapTypes.set('unipods_menu', unipodsMapType);
                    map.setMapTypeId('unipods_menu');


                    // Add Unipods Location marker
                    var image = 'http://www.romeo-interiors.com/wp-content/uploads/2013/03/romeo_map.jpg';
                    var marker = new google.maps.Marker({
                        position: myLatlng, 
                        map: map,
                        icon: image
                    });  
                                          google.maps.event.addDomListener(window, 'load', initialize);


                }



                initialize();


});

/* You can safely use $ in this code block to reference jQuery */
});