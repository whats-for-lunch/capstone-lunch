import {httpConfig} from "../misc/http-config";

export const getAllRestaurants = () => async dispatch => {
	const {data} = await httpConfig(`/apis/restaurant/`);
	dispatch({type: "GET_ALL_RESTAURANTS", payload: data})
};

export const getRestaurantByRestaurantId = () => async dispatch => {
	const {data} = await httpConfig(`/apis/restaurant/${id}/`);
	dispatch({type: "GET_RESTAURANT_BY_RESTAURANTS_ID", payload: data})
};

export const getProfileByProfileId = () => async dispatch => {
	const {data} = await httpConfig(`/apis/profile/${id}/`);
	dispatch({type: "GET_PROFILE_BY_PROFILE_ID", payload: data})
};

export const getProfileByProfileEmail = () => async dispatch => {
	const {data} = await httpConfig(`/apis/profile/`);
	dispatch({type: "GET_PROFILE_BY_PROFILE_EMAIL", payload: data})
};

export const getPictureByPictureId = () => async dispatch => {
	const {data} = await httpConfig(`/apis/picture/${id}/`);
	dispatch({type: "GET_PICTURE_BY_PICTURE_ID", payload: data})
};

export const getPictureByPictureRestaurantId = () => async dispatch => {
	const {data} = await httpConfig(`/apis/picture/${id}/`);
	dispatch({type: "GET_PICTURE_BY_PICTURE_RESTAURANT_ID", payload: data})
};

export const getFavoriteByFavoriteProfileIdAndFavoriteRestaurantId = () => async dispatch => {
	const {data} = await httpConfig(`/apis/favorite/${id}/`);
	dispatch({type: "GET_FAVORITE_BY_FAVORITE_PROFILE_ID_AND_FAVORITE_RESTAURANT_ID", payload: data})
};

export const getFavoriteByFavoriteProfileId = () => async dispatch => {
	const {data} = await httpConfig(`/apis/favorite/${id}/`);
	dispatch({type: "GET_FAVORITE_BY_FAVORITE_PROFILE_ID", payload: data})
};

export const getFavoriteByFavoriteRestaurantId = () => async dispatch => {
	const {data} = await httpConfig(`/apis/favorite/${id}/`);
	dispatch({type: "GET_FAVORITE_BY_FAVORITE_RESTAURANT_ID", payload: data})
};