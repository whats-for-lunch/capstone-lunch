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
	<section id="card-decks">
		<div className="card-group">
			<div className="card">
				<img src="./image/artichoke.jpg" className="card-img-top" alt="...">
					<div className="card-body">
						<h5 className="card-title">Card title</h5>
						<p className="card-text">This is a wider card with supporting text below as a natural lead-in to
							additional content. This content is a little bit longer.</p>
						<p className="card-text">
							<small className="text-muted">Last updated 3 mins ago</small>
						</p>
					</div>
			</div>
			<div className="card">
				<img src="./image/lulucafe.jpg" className="card-img-top" alt="...">
					<div className="card-body">
						<h5 className="card-title">Card title</h5>
						<p className="card-text">This card has supporting text below as a natural lead-in to additional
							content.</p>
						<p className="card-text">
							<small className="text-muted">Last updated 3 mins ago</small>
						</p>
					</div>
			</div>
			<div className="card">
				<img src="./image/mastapas.jpg" className="card-img-top" alt="...">
					<div className="card-body">
						<h5 className="card-title">Card title</h5>
						<p className="card-text">This is a wider card with supporting text below as a natural lead-in to
							additional content. This card has even longer content than the first to show that equal
							height action.</p>
						<p className="card-text">
							<small className="text-muted">Last updated 3 mins ago</small>
						</p>
					</div>
			</div>
		</div>
	</section>


	</body>
	)