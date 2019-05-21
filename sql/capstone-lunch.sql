drop table if exists favorite;
drop table if exists picture;
drop table if exists restaurant;
drop table if exists profile;

create table profile (
    profileId binary (16) not null,
    profileActivationToken varchar (32) null,
    profileEmail varchar (128) not null,
    profileFirstName varchar (128) not null,
    profileLastName varchar (128) not null,
    profileHash char (97) not null,
    unique (profileEmail),
    primary key (profileId)
);

create table restaurant (
    restaurantId binary (16) not null,
    restaurantAddress varchar (256) not null,
    restaurantName varchar (128) not null,
    restaurantLat decimal (9 ,6) not null,
    restaurantLng decimal (9,6) not null,
    restaurantPrice varchar (6) not null,
    restaurantReviewRating decimal (2,1) not null,
    restaurantThumbnail varchar (255) not null,
    primary key (restaurantId)
);

create table picture (
    pictureId binary (16) not null,
    pictureRestaurantId binary (16) not null,
    pictureAlt varchar (64),
    pictureUrl varchar (255) not null,
    foreign key (pictureRestaurantId) references restaurant(restaurantId),
    primary key (pictureId)
);

create table favorite (
    favoriteProfileId binary (16),
    favoriteRestaurantId binary (16),
    foreign key (favoriteProfileId) references profile(profileId),
    foreign key (favoriteRestaurantId) references restaurant(restaurantId),
    primary key (favoriteProfileId, favoriteRestaurantId)
);
