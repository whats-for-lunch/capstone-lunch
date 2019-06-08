import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import {Route, BrowserRouter, Switch} from "react-router-dom";
import {Home} from "./pages/Home.js";
import {NavBar} from "./shared/components/NavBar";
import {Footer} from "./shared/components/Footer";
import {AboutUs} from "./shared/components/AboutUs";


const Routing = () => (
	<>
		<BrowserRouter>
			<NavBar/>
			<AboutUs/>
			<Switch>
				<Route exact path = "/" component = {Home}/>
			</Switch>
			<Footer/>
		</BrowserRouter>
	</>
);

ReactDOM.render(Routing(), document.querySelector('#root'));