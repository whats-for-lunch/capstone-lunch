import React from 'react';
import ReactDOM from 'react-dom'

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';

import {Route, BrowserRouter, Switch} from "react-router-dom";
import {Home} from "./pages/home/Home.js";
import "./index.css";

import {NavBar} from "./shared/components/navBar/NavBar";
import {Footer} from "./shared/components/Footer";
import {AboutUs} from "./pages/AboutUs";
import {Favorite} from "./pages/Favorite";

import {applyMiddleware, createStore} from "redux";
import {Provider} from "react-redux";
import thunk from "redux-thunk";
import reducers from "./shared/reducers";
import {Restaurants} from "./pages/Restaurants";


{/*library.add(fa-github, fa-yelp);*/}
const store = createStore(reducers,applyMiddleware(thunk));


const Routing = (store) => (
	<>
		<Provider store={store}>
		<BrowserRouter>
			<NavBar/>
			<Switch>
				<Route exact path= "/about-us" component={AboutUs}/>
				<Route exact path= "/favorite" component={Favorite}/>
				<Route exact path = "/" component = {Home}/>
			</Switch>
			<Footer/>
		</BrowserRouter>
		</Provider>
	</>
);

ReactDOM.render(Routing(store), document.querySelector('#root'));