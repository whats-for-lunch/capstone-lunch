import React from 'react';
import {GoogleMap, Marker, withGoogleMap, withScriptjs} from "react-google-maps";


export const GMap = withScriptjs(withGoogleMap(({restaurants}) => {
	(console.log(restaurants));
	return (
		<section>
		<div className="container-fluid">
			<div className="border-danger">
			<GoogleMap
				defaultZoom={14}
				defaultCenter={{lat: 35.0856197, lng: -106.64924}}
			>
				<Marker position={{lat:35.0859, lng:106.6499}}/>
				{restaurants.map(restaurant => (
				<Marker
					position={{lat:restaurant.restaurantLat, lng:restaurant.restaurantLng}}
					defaultPosition={{lat:35.0859, lng:106.6499}}
				/>
			))}
			</GoogleMap>
		</div>
		</div>
		</section>
		)
	}
));
