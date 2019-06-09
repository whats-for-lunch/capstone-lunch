import React from 'react';
import {Header} from "./home/Header";
import {Recommended} from "./home/Recommended";

const HomeComponent = () => {
	return (
		<>
			<Header/>
			<Recommended/>
		</>
	)
};

export const Home = (HomeComponent);
