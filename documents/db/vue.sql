CREATE VIEW v_monster_average AS
SELECT 
    monster_id,
    ROUND(AVG(notation) * 2) / 2 AS average_note
FROM 
    notations
GROUP BY 
    monster_id;