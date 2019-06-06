import {httpConfig} from "../misc/http-config";

export const getAllRestaurants = () => async dispatch => {
	const {data} = await httpConfig("/apis/post/");
	dispatch({type: "Get_ALL_Restaurants", payload: data})
};

export const getRestaurantByRestaurantId = (id) => async dispatch => {
	const {data} = await httpConfig(`/apis/post/${id}`);
	dispatch({type: "Get_Restaurant", payload: data})
};