import React, {useEffect} from "react"
import {Header} from "./Header";
import {Recommended} from "./Recommended";
import {GMap} from "./Gmap";
import {RestaurantComponent} from "../Restaurants";
import {connect} from "react-redux";
import {getAllRestaurants, getRestaurantByRestaurantId} from "../../shared/actions";

const HomeComponent = ({restaurants, getAllRestaurants}) => {

	useEffect(() => {
		getAllRestaurants()
	}, [getAllRestaurants]);

	console.log(restaurants);

	return (
		<>
			<Header/>
			<GMap
				googleMapURL="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=geometry,drawing,places&key=AIzaSyCp8aJ6-c7UwVvh-tVeXsWQ3nYQrQ4c3r4"
				loadingElement={<div style={{height: `100%`}}/>}
				containerElement={<div style={{height: `400px`}}/>}
				mapElement={<div style={{height: `100%`}}/>}
				restaurants={restaurants}
			/>
			<Recommended/>
		</>
	)
};

const mapStateToProps = ({restaurants}) => {
	return {restaurants};
};

// export const Home = (HomeComponent);
export const Home = connect(mapStateToProps,{getAllRestaurants})(HomeComponent);