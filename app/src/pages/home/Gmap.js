import React from 'react';
import {GoogleMap, Marker, withGoogleMap, withScriptjs} from "react-google-maps";


export const GMap = withScriptjs(withGoogleMap(() =>
	<GoogleMap
		defaultZoom={8}
		defaultCenter={{lat: 35.0856197, lng: -106.64924}}
	>
		<Marker
			position={{lat: 34.397, lng: -106.7}}
		/>
	</GoogleMap>
));