export default (state = [], action) => {
	switch(action.type) {
		case "GET_FAVORITE_BY_FAVORITE_PROFILE_ID_AND_FAVORITE_RESTAURANT_ID":
			return action.payload;
		case "GET_FAVORITE_BY_FAVORITE_PROFILE_ID":
			return action.payload;
		case "GET_FAVORITE_BY_FAVORITE_RESTAURANT_ID":
			return action.payload;
		default:
			return state;
	}
}