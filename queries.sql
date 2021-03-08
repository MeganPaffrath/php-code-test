SELECT * FROM sweetwater_test
WHERE comments REGEXP 'candy|sweets|smarties|taffy|tootsie|bit o honey|fireball|fire ball|mint';

SELECT * FROM sweetwater_test
WHERE comments REGEXP 'call |call.';
-- The shiping address is a company called CostaCourier. Expected Ship Date: 01/07/18 sweetwater_test
-- " recall ", " called ", "Call ...", "...call"

SELECT * FROM sweetwater_test
WHERE comments REGEXP 'referred';

SELECT * FROM sweetwater_test
WHERE comments REGEXP 'signature';
-- "signature series"

SELECT * FROM sweetwater_test
WHERE NOT comments REGEXP 'candy|sweets|smarties|taffy|tootsie|bit o honey|fireball|fire ball|mint|call |call.|referred|signature';