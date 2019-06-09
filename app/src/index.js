import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import {Route, BrowserRouter, Switch} from "react-router-dom";
import {Home} from "./pages/Home.js";
import "./index.css";

import {NavBar} from "./shared/components/navBar/NavBar";
import {Footer} from "./shared/components/Footer";
import {AboutUs} from "./pages/AboutUs";
// import {GMap} from "./shared/components/GMap";
import {Favorite} from "./pages/Favorite";


{/*library.add(fa-github, fa-yelp);*/}

const Routing = () => (
	<>
		<BrowserRouter>
			<NavBar/>
			<Switch>
				<Route exact path= "/about-us" component={AboutUs}/>
				<Route exact path= "/favorite" component={Favorite}/>
				<Route exact path = "/" component = {Home}/>
			</Switch>
			<Footer/>
		</BrowserRouter>
	</>
);

ReactDOM.render(Routing(), document.querySelector('#root'));