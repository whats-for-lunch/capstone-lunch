<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Conceptual Model</title>
	</head>
	<body>
<h1>Conceptual Model</h1>
		<ul>
			 <br>
			<strong>Profile</strong>
			<li>profileId (primary Key)</li>
			<li>profileEmail</li>
			<li>profileHash</li>
			 <br>
			<strong>Restaurants</strong>
			<li>restaurantId (primary Key)</li>
			<li>restaurantAddress</li>
			<li>restaurantName</li>
			<li>restaurantLng</li>
			<li>restaurantThumbnail</li>
			<li>restaurantLat</li>
			<li>restaurantPrice</li>
			<li>restaurantReviewRating</li>
			 <br>
			<strong>Favorite</strong>
			<li>favoriteId</li>
			<li>Remove button</li>
			<li>favoriteProfileId (foreign key)</li>
			<li>favoriteRestaurantId (foreign Key)</li>
			 <br>
			<strong>Pictures</strong>
			<li>pictureId</li>
			<li>pictureRestaurantId (foreign key)</li>
			<li>pictureUrl</li>
		</ul>
			<img src="revisedERD.jpg" width="700px" alt="ERD">

	</body>
</html>