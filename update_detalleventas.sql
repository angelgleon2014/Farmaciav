drop database farmaciass; create database farmaciass ; use farmaciass ; source C:/xampp/htdocs/BOTICA/bd_estructura/farmaciass.sql ;

ALTER TABLE detalleventas ADD COLUMN tipocantidad VARCHAR(50);

UPDATE detalleventas
SET tipocantidad =
IF(productov LIKE "%(Unidad)%" OR productov LIKE "%(UNIDAD)%" , 'unidad',
    IF(productov LIKE "%(UnidadDescuento)%" OR productov LIKE "%(UNIDADDESCUENTO)%", 'unidaddescuento',
        IF(productov LIKE "%(Blister)%" OR productov LIKE "%(BLISTER)%", 'blister',
            IF(productov LIKE "%(BlisterDescuento)%" OR productov LIKE "%(BLISTERDESCUENTO)%", 'blisterdescuento',
                IF(productov LIKE "%(Caja)%" OR productov LIKE "%(CAJA)%", 'caja',
                    IF(productov LIKE "%(Caja)%" OR productov LIKE "%(CAJADESCUENTO)%", 'cajadescuento', NULL)
                )
            )
        )
    )
);

commit;
