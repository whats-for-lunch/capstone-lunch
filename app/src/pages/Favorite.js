import React from "react";


export const Favorite = () => (
	<body className="Favorite" id="Favorite">
		<div className="jumbotron jumbotron-fluid bg-dark text-warning justify-content-center py-0 mb-0">
			<div className="container">
				<div className="row justify-content-center">
					<h1 className="display-4">Favorites</h1>
				</div>
			</div>
		</div>


		<div className="card-deck bg-dark">
			<div className="card bg-warning p-1">
				<img className="img-fluid rounded " src="https://s3-media2.fl.yelpcdn.com/bphoto/UDHrDaDc96XzdwbDIEP3gQ/o.jpg" alt="prop"/>
				<div className="card-body">
					<h5 className="card-title">Artichoke Cafe</h5>
					<p className="card-text">424 Central Ave SE
						Albuquerque, NM 87102

					</p>
				</div>
				<div className="card-footer">
					<a href="https://www.yelp.com/biz/artichoke-cafe-albuquerque-3"
					   target="_blank">Artichoke Cafe</a>
				</div>
			</div>

			<div className="card bg-warning p-1">
				<img className="img-fluid rounded " src="https://s3-media4.fl.yelpcdn.com/bphoto/xaPRwhSswSxYpCnSwnwyGQ/o.jpg"  alt="prop"/>
				<div className="card-body">
					<h5 className="card-title">Lulu’s Kitchen</h5>
					<p className="card-text">315 Gold Ave SW
						Albuquerque, NM 87102

					</p>
				</div>
				<div className="card-footer">
					<a href="https://www.yelp.com/biz/lulus-kitchen-albuquerque-2"
					   target="_blank">Lulu’s Kitchen</a>
				</div>
			</div>

			<div className="card bg-warning p-1">
				<img className="img-fluid  rounded" src="https://s3-media3.fl.yelpcdn.com/bphoto/8scPGxPpkztjo_u8ChnLXw/o.jpg" alt="prop"/>
				<div className="card-body">
					<h5 className="card-title">MAS - Tapas Y Vino</h5>
					<p className="card-text">125 2nd St NW
						Andaluz Hotel
						Albuquerque, NM 87102

					</p>
				</div>
				<div className="card-footer">
					<a href="https://www.yelp.com/biz/mas-tapas-y-vino-albuquerque"
					   target="_blank">MAS - Tapas Y Vino</a>
				</div>
			</div>

			<div className="card bg-warning p-1">
				<img className="img-fluid  rounded" src="https://s3-media1.fl.yelpcdn.com/bphoto/7MQ9uetuHmZTniMWqx7R3A/o.jpg" alt="prop"/>
				<div className="card-body">
					<h5 className="card-title">Tucanos Brazilian Grill</h5>
					<p className="card-text">110 Central Ave SW
						Albuquerque, NM 87102
					</p>
				</div>
				<div className="card-footer">
					<a href="https://www.yelp.com/biz/tucanos-brazilian-grill-albuquerque"
					   target="_blank">Tucanos Brazilian Grill</a>
				</div>
			</div>
		</div>

	</body>
	)