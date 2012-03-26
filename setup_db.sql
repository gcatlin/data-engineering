PRAGMA foreign_keys = 1;

DROP TABLE IF EXISTS purchaser;
CREATE TABLE purchaser (
    purchaser_id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT
);

DROP TABLE IF EXISTS merchant;
CREATE TABLE merchant (
    merchant_id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    address TEXT
);

DROP TABLE IF EXISTS item;
CREATE TABLE item (
    item_id INTEGER PRIMARY KEY AUTOINCREMENT,
    merchant_id INTEGER,
    price REAL,
    description TEXT,
    FOREIGN KEY(merchant_id) REFERENCES merchant(merchant_id)
);

DROP TABLE IF EXISTS purchase;
CREATE TABLE purchase (
    purchase_id INTEGER PRIMARY KEY AUTOINCREMENT,
    purchaser_id INTEGER,
    item_id INTEGER,
    quantity INTEGER,
    FOREIGN KEY(purchaser_id) REFERENCES purchaser(purchaser_id),
    FOREIGN KEY(item_id) REFERENCES item(item_id)
);
