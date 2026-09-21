-- Add the customer province / district / postcode fields to Sample Request (SMP) documents.
-- Compatible with older MySQL versions that do not support ADD COLUMN IF NOT EXISTS.
-- Step 1: run the SHOW COLUMNS query. If it returns no rows, run the ALTER TABLE query.
-- Run this BEFORE deploying the matching PHP code: saving an SMP document writes these columns.

SHOW COLUMNS FROM `hos__smp` WHERE Field IN ('customer_province', 'customer_ampher', 'customer_postcode');

ALTER TABLE `hos__smp`
  ADD COLUMN `customer_province` VARCHAR(150) NOT NULL DEFAULT '' AFTER `address_name`,
  ADD COLUMN `customer_ampher` VARCHAR(150) NOT NULL DEFAULT '' AFTER `customer_province`,
  ADD COLUMN `customer_postcode` VARCHAR(10) NOT NULL DEFAULT '' AFTER `customer_ampher`;
