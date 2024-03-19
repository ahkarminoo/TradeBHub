CREATE TABLE auctions (
    auction_id INT(11) NOT NULL AUTO_INCREMENT,
    item_id INT(11) NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    status TINYINT(1) NOT NULL DEFAULT 1,
    winning_bid_id INT(11),
    image_url VARCHAR(255),
    PRIMARY KEY (auction_id)
);
 
CREATE TABLE bids (
    bid_id INT(11) NOT NULL AUTO_INCREMENT,
    auction_id INT(11) NOT NULL,
    bidder_id INT(11) NOT NULL,
    bid_item_name VARCHAR(255) NOT NULL,
    bid_item_description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    PRIMARY KEY (bid_id)
);

CREATE TABLE items (
    item_id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    image_url VARCHAR(255) NOT NULL,
    PRIMARY KEY (item_id)
);
 
CREATE TABLE notifications (
    notification_id INT(11) NOT NULL AUTO_INCREMENT,
    user_id INT(11) NOT NULL,
    message TEXT NOT NULL,
    read_status TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (notification_id)
);
 
CREATE TABLE users (
    user_id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id)
);
 
ALTER TABLE auctions
ADD CONSTRAINT FK_Auctions_Items
FOREIGN KEY (item_id) REFERENCES items(item_id),
ADD CONSTRAINT FK_Auctions_Bids
FOREIGN KEY (winning_bid_id) REFERENCES bids(bid_id);
 
ALTER TABLE bids
ADD CONSTRAINT FK_Bids_Auctions
FOREIGN KEY (auction_id) REFERENCES auctions(auction_id),
ADD CONSTRAINT FK_Bids_Users
FOREIGN KEY (bidder_id) REFERENCES users(user_id);
 
ALTER TABLE items
ADD CONSTRAINT FK_Items_Users
FOREIGN KEY (user_id) REFERENCES users(user_id);
 
ALTER TABLE notifications
ADD CONSTRAINT FK_Notifications_Users
FOREIGN KEY (user_id) REFERENCES users(user_id);