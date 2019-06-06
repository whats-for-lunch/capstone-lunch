export default (state = [], action) => {
	switch(action.type) {
		case "GET_RESTAURANT_BY_RESTAURANT_ID":
			return action.payload;
		case "GET_ALL_RESTAURANTS":
			return action.payload;
		default:
			return state;
	}
}