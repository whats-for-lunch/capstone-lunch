import React from "react";
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";


export const NavBar = () => (
	<>

		{/*<!-- Font Awesome -->*/}
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
				integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay"
				crossOrigin="anonymous"/>


		{/*<!--Navbar beginning -->*/}

		<nav className="navbar navbar-expand-lg navbar-dark bg-dark text-monospace btn-outline-warning">
			<a className="navbar-brand btn btn-outline-warning" href="http://localhost:3000">Home</a>
			<form className="form-inline"/>
			<button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
					  aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span className="navbar-toggler-icon"></span>
			</button>
			<div className="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div className="navbar">
					<SignUpModal/>
					<SignInModal/>
					<a className="nav-item btn btn-outline-warning" href="favorite">Favorite</a>
					<a className="nav-item btn btn-outline-warning" href="about-us">About-Us</a>
				</div>
			</div>
		</nav>
	</>
);