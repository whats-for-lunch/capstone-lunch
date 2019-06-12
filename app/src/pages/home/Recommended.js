import React from "react";


export const Recommended = () => (
	<>
		<div className="jumbotron jumbotron-fluid bg-dark text-warning justify-content-center py-0 mb-0">
			<div className="container">
				<div className="row justify-content-center">
					<h1 className="display-4">Our Recommendations</h1>
				</div>
			</div>
		</div>

		<div className="card-deck bg-dark">
			<div className="card bg-warning p-1">
				<img className="img-fluid rounded " src="https://s3-media4.fl.yelpcdn.com/bphoto/p6KReaIl7NYHuzTmfLqk-A/o.jpg" alt="prop"/>
				<div className="card-body">
					<h5 className="card-title">JEFF'S RECOMMENDED</h5>
					<p className="card-text"><a href="https://www.yelp.com/biz/asian-noodle-bar-albuquerque?osq=asian+noodle+bar" target="_blank">
						Asian Noodle Bar</a> is a great place to try out not only for the awesome food but also a
						stellar atmosphere with a bar inside and patio to sit at out front. They have amazing pad thai, spicy
						sesame noodles, and different types of pho with large portions that are great for the price!

					</p>
				</div>
				<div className="card-footer">
				</div>
			</div>

			<div className="card bg-warning p-1">
				<img className="img-fluid rounded " src="https://s3-media2.fl.yelpcdn.com/bphoto/bTNqHFZyefA7upTLnpc1yQ/o.jpg"  alt="prop"/>
				<div className="card-body">
					<h5 className="card-title">JAMIE'S RECOMMENDED</h5>
					<p className="card-text"> In the mood for sea food? <a href="https://www.yelp.com/biz/sushi-king-albuquerque-5?osq=Sushi+King" target="_blank">Sushi
						King</a> has an amazing Shrimp Tempura Roll! The Philadelphia roll is also super tasty with a side of fresh edamame and a Lucky Buddha beer. YUM!
						</p>
				</div>
				<div className="card-footer">
				</div>
			</div>

			<div className="card bg-warning p-1">
				<img className="img-fluid  rounded" src="https://s3-media2.fl.yelpcdn.com/bphoto/ADpx7FGxjJ8uXQ3MOfAzlg/o.jpg" alt="prop"/>
				<div className="card-body">
					<h5 className="card-title">JESSE'S RECOMMENDED</h5>
					<p className="card-text">Bocadillos was brought to my attention by word of mouth. I've been to sandwich shops before but nothing like this one. I've had three items off their menu and every one of them was so delicious. The nachos, reuben and the Cubano. These items were all unique in style and flavor. The service is is very friendly and your always greeted with a smile. If you want a delicious sandwich I would always recommend Bocadillos as a place to eat.
						<a href="https://www.yelp.com/biz/slow-roasted-bocadillos-albuquerque-2"
							target="_blank">Bocadillos</a></p>
				</div>
				<div className="card-footer">
				</div>
			</div>
		</div>
	</>
)