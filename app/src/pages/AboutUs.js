import React from "react";


export const AboutUs = () => (
	<body>

		<div className="jumbotron jumbotron-fluid bg-dark text-white justify-content-center py-0 mb-0 ">
			<div className="container">
				<div className="row justify-content-center">
					<h1 className="display-4"> ABOUT US </h1>
				</div>
			</div>
		</div>
		<div className="row justify-content-center">
						<span className="border border-warning">
						<img src="images/120190529_101042_HDR-640x480.jpg" className="img-fluid" alt="whats for lunch crew"/>
					</span>
		</div>
		<div className="container text-white">
			<div className="row justify-content-center sm mt-3">
				<h3 className="display-6">"What's for Lunch"</h3>
			</div>
		</div>
		<div className="container text-white py-3">
			<div className="container mx-auto">
				<p>
					WhatsForLunch is an Albuquerque based application created by junior web developers Jessie Silva, Jamie Amparan,
					and Jeffrey Gallegos. We are recent graduates of the CNM Deep Dive Coding Bootcamp at the Stemulus center.
					In this program we learned the basics of different coding programs, web development processes, and languages
					such as PHP, CSS, HTML5, Bash, and Javascript. We created this application with the thought of future Deep Dive
					students in mind. To hopefully be able to share our experiences of not only programming, but our experiences
					at the downtown restaurants that we had been to during our time at the bootcamp.
				</p>
			</div>
		</div>
				<div className= "container-fluid bg-warning text-dark py-4 text-center">
				<div>
					<h2><u>Contact Us!</u></h2>
				</div>
				<div>
					<div className= "col-4-sm mb-2">
					<h5>Jeffrey Gallegos</h5>
					<a className="text-white" href="https://www.linkedin.com/in/jeffrey-gallegos-b002a6181/">LinkedIn</a> or <a className="text-white" href="https://github.com/JeffreyGallegosCoding">Github</a>
					</div>
					<div className= "col-4-sm mb-2">
					<h5>Jamie Amparan</h5>
				<a className="text-white" href="https://www.linkedin.com/in/jamie-amparan/">LinkedIn</a> or <a className="text-white" href="https://github.com/jleespooks/">Github</a>
					</div>
					<div className= "col-4-sm mb-2">
					<h5>Jessie Silva</h5>
				<a className="text-white" href="https://www.linkedin.com/in/jesus-silva-287965171/">LinkedIn</a> or <a className="text-white" href="https://github.com/jsilva85">Github</a>
					</div>
				</div>
				</div>

	</body>
);