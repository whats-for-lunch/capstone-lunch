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
					<p className="card-text">Bacon ipsum dolor amet rump shankle drumstick meatloaf cupim capicola. Ball tip
						bacon
						jowl tail, jerky cupim short loin boudin tri-tip turducken alcatra ham picanha. Chicken buffalo
						shankle
						ham hock beef ribs pork chop boudin doner swine.
						<a href="https://www.yelp.com/biz/asian-noodle-bar-albuquerque?osq=asian+noodle+bar"
							target="_blank">Asian Noodle Bar</a>
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
					<p className="card-text">Bacon ipsum dolor amet rump shankle drumstick meatloaf cupim capicola. Ball tip
						bacon
						jowl tail, jerky cupim short loin boudin tri-tip turducken alcatra ham picanha. Chicken buffalo
						shankle
						ham hock beef ribs pork chop boudin doner swine.
						<a href="https://www.yelp.com/biz/slow-roasted-bocadillos-albuquerque-2"
							target="_blank">Bocadillos</a></p>
				</div>
				<div className="card-footer">
				</div>
			</div>
		</div>
	</>
)