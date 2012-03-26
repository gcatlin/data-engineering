.mode tabs
.headers on

SELECT
    purchaser.name as 'purchaser name',
    item.description as 'item description',
    item.price as 'item price',
    purchase.quantity as 'purchase count',
    merchant.address as 'merchant address',
    merchant.name as 'merchant name'
FROM
    purchase JOIN purchaser USING (purchaser_id),
    purchase p2 JOIN item USING (item_id),
    item i2 JOIN merchant USING (merchant_id)
GROUP BY
    purchase.purchase_id;
