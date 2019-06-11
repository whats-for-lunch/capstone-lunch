import React from "react";


export const Footer = () => (
	<footer>

		{/*<!-- Sticky Footer -->*/}
			<div className="container-fluid py-5">
				<div className="sticky-footer text-center bg-dark pt-2 pb-0 m-0 fixed-bottom">
					<div className="content-center">
						<a href="https://github.com/whats-for-lunch" className="github">
							<i className="fab fa-github fa-2x"></i>
						</a>
						<a href="https://www.yelp.com/" className="ml-2 yelp">
							<i className="fab fa-yelp fa-2x"></i>
						</a>
						<br/>
					</div>
				</div>
			</div>
		</footer>
)