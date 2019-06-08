import React from 'react';
const HomeComponent = () => {
	return (
		<main className="container">
			<head>
				{/*<!--Navbar beginning -->*/}
				<nav className="navbar navbar-dark bg-dark fluid d-flex justify-content-end text-monospace">
					<form className="form-inline">
						<button className="btn btn-outline-warning" type="button">Sign Up</button>
						<button className="btn btn-outline-warning" type="button">Sign In</button>
						<button className="btn btn-outline-warning" type="button">About Us</button>
						<button className="btn btn-outline-warning" type="button">Favorites</button>

						{/*<!-- Added a toggle tab to navbar -->*/}
						<div className="pos-f-t">
							<div className="collapse" id="navbarToggleExternalContent">
								<div className="bg-dark p-4">
									<h5 className="text-white h4">Collapsed content</h5>
									<span className="text-muted">Toggleable via the navbar brand.</span>
								</div>
							</div>
							<nav className="navbar navbar-dark bg-dark">
								<button className="navbar-toggler" type="button" data-toggle="collapse"
										  data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
										  aria-expanded="false" aria-label="Toggle navigation">
									<span className="navbar-toggler-icon"></span>
								</button>
							</nav>
						</div>
					</form>
				</nav>
			</head>

			{/*<!-- Sticky Footer -->*/}
			<footer>
				<div class="container-fluid py-5">
					<div class="sticky-footer text-center bg-dark pt-2 pb-0 m-0 fixed-bottom">
						<div class="content-center">
							<a href="https://github.com/whats-for-lunch" class="github">
								<i class="fab fa-github fa-2x"></i>
							</a>
							<a href="https://www.yelp.com/" class="ml-2 yelp">
								<i class="fab fa-yelp fa-2x"></i>
							</a>
							<br/>
						</div>
					</div>
				</div>
			</footer>
		</main>
	)
};

export const Home = (HomeComponent);
