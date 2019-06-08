import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';
import {Route, BrowserRouter, Switch} from "react-router-dom";
import {Home} from "./pages/Home.js";
import "./index.css";
import {NavBar} from "./shared/components/NavBar";
import {Footer} from "./shared/components/Footer";
import {AboutUs} from "./shared/components/AboutUs";
import {Background} from "./shared/components/Background";
import {Map} from "./shared/components/Map";
import {Favorite} from "./shared/components/Favorite";
import {Recommended} from "./shared/components/Recommended";
import {Header} from "./shared/components/Header";

{/*library.add(fa-github, fa-yelp);*/}

const Routing = () => (
	<>
		<BrowserRouter>
			<Background/>
			<NavBar/>
			<Header/>
			<Map/>
			<AboutUs/>
			<Favorite/>
			<Recommended/>
			<Footer/>
			<Switch>
				<Route exact path = "/" component = {Home}/>
			</Switch>
		</BrowserRouter>
	</>
);

ReactDOM.render(Routing(), document.querySelector('#root'));