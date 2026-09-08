-- Add executive approval routing flag for BR HOS booth-loan flow.
-- Compatible with older MySQL versions that do not support ADD COLUMN IF NOT EXISTS.
-- Step 1: run the SHOW COLUMNS query. If it returns no rows, run the ALTER TABLE query.

SHOW COLUMNS FROM `hos__br` LIKE 'send_dm';

ALTER TABLE `hos__br`
  ADD COLUMN `send_dm` VARCHAR(1) NOT NULL DEFAULT '0' AFTER `send_sup`;
