
-- Atualiza o campo Autenticado_Em quando o Admin autoriza o usuario

Tentativa 1:
ALTER TABLE usuarios ADD COLUMN Autenticado_Em DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP;

Tentativa 2:    FUNCIONA
DELIMITER //
CREATE TRIGGER atualiza_autenticado_em 
    BEFORE UPDATE ON usuarios
    FOR EACH ROW
        BEGIN
            IF (OLD.Autenticado <> NEW.Autenticado) AND (NEW.Autenticado = 1) THEN
                SET NEW.Autenticado_Em = CURRENT_TIMESTAMP;
            ELSE
                SET NEW.Autenticado_Em = NULL;
        END IF;
    END //
DELIMITER ;