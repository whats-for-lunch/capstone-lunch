import React, {useState} from 'react';
import {GoogleMap, Marker, withGoogleMap, withScriptjs} from "react-google-maps";
import {Modal} from "react-bootstrap";



export const GMap = withScriptjs(withGoogleMap(({restaurants}) => {

	const [show, setShow] = useState(false);
	const [selectedRestaurant, setSelectedRestaurant] = useState(null);

	const open = () => {
		setShow(true);
	};

	const close = () => {
		setShow(false);

	};
	return (
		<>

			{
				(selectedRestaurant) && (
					<Modal show={show} onHide={close}>
						<Modal.Header closeButton>
							<Modal.Title>Modal heading</Modal.Title>
						</Modal.Header>
						<Modal.Body>{}
						</Modal.Body>
					</Modal>
				)
			}
			<GoogleMap
				defaultZoom={14}
				defaultCenter={{lat: 35.0856197, lng: -106.64924}}
			>
				<Marker position={{lat:35.0859, lng:106.6499}}/>
				{restaurants.map(restaurant => (
				<Marker
					position={{lat:restaurant.restaurantLat, lng:restaurant.restaurantLng}}
					defaultPosition={{lat:35.0859, lng:106.6499}}
					onClick={() => {
						open();
						setSelectedRestaurant(restaurant)
					}}
				/>
			))}
			</GoogleMap>
		</>
		)
	}
));
