import React from "react";


export const Favorite = () => (
	<body>
		<div className="jumbotron jumbotron-fluid bg-dark text-warning justify-content-center py-0 mb-0">
			<div className="container">
				<div className="row justify-content-center">
					<h1 className="display-4">Favorites</h1>
				</div>
			</div>
		</div>


		<section id="card decks ">
			<div className="container-fluid bg-dark text-dark">
				<div className="container my-8">
					<div className="card-deck">
						<div className="card bg-warning">
							<img className="card-img-top"
								  src="https://s3-media2.fl.yelpcdn.com/bphoto/UEnfWw0AdsVhMzmvLswgzg/o.jpg"
								  alt="Card image cap" className="rounded"/>
								<div className="card-body">
									<h5 className="card-title">Artichoke Cafe</h5>
									<p className="card-text">American (New), Cafes</p>
									<p><strong>424 Central Ave SE
										Albuquerque, NM 87102</strong></p>
									<i className="far fa-window-close"></i>
								</div>

						</div>
						<div className="card bg-warning">
							<img className="card-img-top"
								  src="https://s3-media3.fl.yelpcdn.com/bphoto/-odb7y2_GxASimUqXtNn4Q/o.jpg"
								  alt="Card image cap" className="rounded"/>
								<div className="card-body">
									<h5 className="card-title">Cocina Azul</h5>
									<p className="card-text">New Mexican Cuisine </p>
									<p><strong>1134 Mountain Rd NW
										Albuquerque, NM 87102</strong></p>
								</div>
						</div>
						<div className="card bg-warning">
							<img className="card-img-top"
								  src="https://s3-media3.fl.yelpcdn.com/bphoto/-odb7y2_GxASimUqXtNn4Q/o.jpg"
								  alt="Card image cap" className="rounded"/>
								<div className="card-body">
									<h5 className="card-title">The Grove Cafe & Market</h5>
									<p className="card-text">Coffee & Tea, American (New), Cafes </p>
									<p><strong>600 Central Ave SE
										Ste A
										Albuquerque, NM 87102</strong></p>
								</div>
						</div>
						<div className="card bg-warning">
							<img className="card-img-top"
								  src="https://s3-media2.fl.yelpcdn.com/bphoto/UEnfWw0AdsVhMzmvLswgzg/o.jpg"
								  alt="Card image cap" className="rounded"/>
								<div className="card-body">
									<h5 className="card-title">Sophia’s</h5>
									<p className="card-text">American (New), Breakfast & Brunch, Latin American</p>
									<p><strong> Park Ave SW
										Ste 102
										Albuquerque, NM 87102</strong></p>
								</div>
						</div>
					</div>
				</div>
			</div>
		</section>

	</body>
	)