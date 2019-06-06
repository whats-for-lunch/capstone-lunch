export default (state = [], action) => {
	switch(action.type) {
		case "GET_PICTURE_BY_PICTURE_ID":
			return action.payload;
		case "GET_PICTURE_BY_PICTURE_RESTAURANT_ID":
			return action.payload;

		default:
			return state;
	}
}