-- Add return date/time range end fields for BR HOS (register_supbrhos*.php, tab "ที่อยู่การคืน").
-- Compatible with older MySQL versions that do not support ADD COLUMN IF NOT EXISTS.
-- Step 1: run each SHOW COLUMNS query. If it returns no rows, run the matching ALTER TABLE query.

SHOW COLUMNS FROM `hos__br` LIKE 'returns_date_to';

ALTER TABLE `hos__br`
  ADD COLUMN `returns_date_to` DATE NULL DEFAULT NULL AFTER `returns_date`;

SHOW COLUMNS FROM `hos__br` LIKE 'returns_time_to';

ALTER TABLE `hos__br`
  ADD COLUMN `returns_time_to` TIME NULL DEFAULT NULL AFTER `returns_time`;
