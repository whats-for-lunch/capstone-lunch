import React from 'react';
import {GoogleMap, Marker, withGoogleMap, withScriptjs} from "react-google-maps";


export const GMap = withScriptjs(withGoogleMap(({restaurants}) => {
	(console.log(restaurants));
	return (
			<GoogleMap
				defaultZoom={14}
				defaultCenter={{lat: 35.0856197, lng: -106.64924}}
			>
				{restaurants.map(restaurant => (
				<Marker
					position={{lat:restaurant.restaurantLat, lng:restaurant.restaurantLng}}
				/>
			))}
			</GoogleMap>
		)
	}
));
