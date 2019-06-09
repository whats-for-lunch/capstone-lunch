import React from "react";


export const NavBar = () => (
	<>

		{/*<!-- Font Awesome -->*/}
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
				integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"
				crossorigin="anonymous"/>


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
							<span className="navbar-toggler-icon"> </span>
						</button>
					</nav>
				</div>
			</form>
		</nav>
	</>
);