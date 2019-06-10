import React from 'react';
import {Header} from "./Header";
import {Recommended} from "./Recommended";

const HomeComponent = () => {
	return (
		<>
			<Header/>
			<Recommended/>
		</>
	)
};

export const Home = (HomeComponent);
