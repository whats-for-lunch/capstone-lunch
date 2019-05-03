create table profile (
    profileId        binary(16)   not null,
    profileEmail     varchar(126) not null,
    profileFirstName varchar(126) not null,
    profileLastName  varchar(126) not null,
    profileHash      varchar(126) not null,
    unique (profileEmail),
    primary key (profileId)
);

create table restaurant (
    restaurantId binary (16) not null,
    restaurantAddress varchar(128) not null,
    restaurantName varchar(128) not null,
    restaurantLng decimal (10) not null,
    restaurantLat decimal (10) not null,
    restaurantPrice numeric (32) not null,
    restaurantReviewRating integer (5) not null,
    restaurantThumbnail varchar(255) not null,
    primary key (restaurantId)
);

create table favorite (
    favoriteProfileId binary (16),
    favoriteRestaurantId binary (16),
    foreign key (favoriteProfileId) references profile(profileId),
    foreign key (favoriteRestaurantId) references restaurant(restaurantId)


);

create table pictures (
    pictureId binary (16) not null,
    pictureRestaurantId varchar(255) not null,
    pictureUrl varchar(128)not null,
    foreign key (pictureRestaurantId) references restaurant(restaurantId),
    primary key (pictureId)
);
