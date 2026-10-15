SET @s = (SELECT IF(COUNT(*) > 0, 'ALTER TABLE hos__rental DROP INDEX idx_sale_code_id', 'SELECT 1')
          FROM information_schema.statistics
          WHERE table_schema = DATABASE() AND table_name = 'hos__rental' AND index_name = 'idx_sale_code_id');
PREPARE st FROM @s; EXECUTE st; DEALLOCATE PREPARE st;
