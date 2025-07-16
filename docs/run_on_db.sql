# agregar campos a la tabla detalleventas
ALTER TABLE `boticajose`.`detalleventas`
    ADD `preciocompraunidadv`  FLOAT(12, 2) NULL AFTER `codigo`,
    ADD `precioventablisterv`  FLOAT(12, 2) NULL AFTER `preciocompraunidadv`,
    ADD `preciocomprablisterv` FLOAT(12, 2) NULL AFTER `precioventablisterv`;

update `boticajose`.`detalleventas`
set preciocompraunidadv  = (select productos.preciocompraunidad
                            from productos
                            where productos.codproducto = detalleventas.codproductov),
    precioventablisterv  = (select productos.precioventablister
                            from productos
                            where productos.codproducto = detalleventas.codproductov),
    preciocomprablisterv = (select productos.preciocomprablister
                            from productos
                            where productos.codproducto = detalleventas.codproductov);

# agregar campo para el correo
ALTER TABLE `ventas` ADD `correo_to_send` VARCHAR(60) NULL AFTER `codigo`;
