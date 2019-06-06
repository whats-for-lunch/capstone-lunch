import React, {useEffect} from "react"
import {connect} from "react-redux";
import {getAllrestaurants, getrestaurantByrestaurantId} from "../shared/actions";

const restaurantComponent = ({restaurants, getAllrestaurants}) => {

	useEffect(() => {
		getAllrestaurants()

	}, [getAllrestaurants]);

	console.log(restaurants);
	return (
		<>
			<main className="my-5">
				<div className="container-fluid text-center text-sm-left">

					<div className="row mb-3">
						<div className="col">
							<h1></h1>
						</div>
					</div>
					<div className="card-columns">
						{restaurants.map(restaurant => (
							<div className="card" key={restaurant.restaurantId}>
								<div className="card-body">
									<h4 className="card-title">{restaurant.restaurantTitle}</h4>
									<p className="card-text">{restaurant.restaurantContent}</p>
								</div>
							</div>
						))}
					</div>
				</div>
			</main>
		</>
	)
};


const mapStateToProps = (reduxState) => {
	return {restaurants: reduxState.restaurants}

};
export const restaurants = connect(mapStateToProps, {getAllrestaurants, getrestaurantByrestaurantId})(restaurantComponent);