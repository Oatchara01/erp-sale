-- Add the "ออเดอร์ฝาก" flag to Sample Request (SMP) documents.
-- Compatible with older MySQL versions that do not support ADD COLUMN IF NOT EXISTS.
-- Step 1: run the SHOW COLUMNS query. If it returns no rows, run the ALTER TABLE query.

SHOW COLUMNS FROM `hos__smp` LIKE 'have_order';

ALTER TABLE `hos__smp`
  ADD COLUMN `have_order` TINYINT(1) NOT NULL DEFAULT 0 AFTER `crm_ref`;
