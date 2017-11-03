var map;
var markers = [];

// We initialize the map
function initMap() {

    // Map styling
    var style = [
        {
            "stylers": [
                {
                    "saturation": -100
                },
                {
                    "gamma": 1
                }
            ]
        },
        {
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi.business",
            "elementType": "labels.text",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi.business",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi.place_of_worship",
            "elementType": "labels.text",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "poi.place_of_worship",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
                {
                    "visibility": "simplified"
                }
            ]
        },
        {
            "featureType": "water",
            "stylers": [
                {
                    "visibility": "on"
                },
                {
                    "saturation": 50
                },
                {
                    "gamma": 0
                },
                {
                    "hue": "#50a5d1"
                }
            ]
        },
        {
            "featureType": "administrative.neighborhood",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#333333"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "labels.text",
            "stylers": [
                {
                    "weight": 0.5
                },
                {
                    "color": "#333333"
                }
            ]
        },
        {
            "featureType": "transit.station",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "gamma": 1
                },
                {
                    "saturation": 50
                }
            ]
        }
    ];

    // Constructor creates a new map - only center and zoom are required.
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 48.834016, lng: 2.236963},
        zoom: 17,
        styles : style,
        mapTypeControl : false
    });

    var tbwa = {lat: 48.834016, lng: 2.236963};
    new google.maps.Marker({
        position : tbwa,
        map : map,
        title : 'TBWA'
    });


    var largeInfoWindow = new google.maps.InfoWindow();


    var url = Routing.generate('all_places_to_eat');
    //  AJAX call
    $.get(url, function(data) {
        // We curl around the places to eat
        data.allPlaces.forEach(function(item, index) {

            var marker = new google.maps.Marker({
                position : {lat: parseFloat(item.positionLatitude), lng: parseFloat(item.positionLongitude)},
                map : map,
                title : item.denomination,
                animation : google.maps.Animation.DROP,
                id : index
            });

            var description = {
                "nom" : item.denomination,
                "adresse" : item.adresse,
                "ville" : item.codePostal
            };

            markers.push(marker);

            marker.addListener('click', function() {
                populateInfoWindow(this, largeInfoWindow);
                $('#description').html(
                    '<h3>' + description.nom + '</h3>' +
                    '<p>' + description.adresse + ', ' + description.ville + '</p>'
                ).show();
            });

        })
    })
}
// Init map end of function

function populateInfoWindow(marker, infoWindow) {
    if(infoWindow.marker != marker) {
        infoWindow.marker = marker;
        infoWindow.setContent('<div>' + marker.title + '</div>');
        infoWindow.open(map, marker);
        infoWindow.addListener('closeclick', function() {
            infoWindow.setMarker = null;
            $('#description').html(description).hide();
        });
    }
}