SELECT TABLE_NAME, COUNT(*) AS num_columns
        FROM information_schema.columns
        WHERE TABLE_SCHEMA = 'scontrol2019'
        GROUP BY TABLE_NAME