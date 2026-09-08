-- Add executive (DM) approval fields for BR HOS booth-loan flow.
-- Compatible with older MySQL versions that do not support ADD COLUMN IF NOT EXISTS.
-- Step 1: run each SHOW COLUMNS query. If it returns no rows, run the matching ALTER TABLE query.

SHOW COLUMNS FROM `hos__br` LIKE 'dm_name';

ALTER TABLE `hos__br`
  ADD COLUMN `dm_name` VARCHAR(255) NOT NULL DEFAULT '' AFTER `send_dm`;

SHOW COLUMNS FROM `hos__br` LIKE 'dm_date';

ALTER TABLE `hos__br`
  ADD COLUMN `dm_date` DATETIME NULL DEFAULT NULL AFTER `dm_name`;
