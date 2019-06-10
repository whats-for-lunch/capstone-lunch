import React from 'react';
import {Header} from "./Header";
import {Recommended} from "./Recommended";
import {GMap} from "./Gmap";
import {RestaurantComponent} from "../Restaurants";


const HomeComponent = () => {
	return (
		<>
			<Header/>
			<GMap
				googleMapURL="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=geometry,drawing,places&key=AIzaSyCp8aJ6-c7UwVvh-tVeXsWQ3nYQrQ4c3r4"
				loadingElement={<div style={{height: `100%`}}/>}
				containerElement={<div style={{height: `400px`}}/>}
				mapElement={<div style={{height: `100%`}}/>}
			/>
			<Recommended/>
		</>
	)
};

export const Home = (HomeComponent);


