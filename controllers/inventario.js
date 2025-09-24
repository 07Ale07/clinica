const express = require('express');
const router = express.Router();
const db = require('../config/db'); // Asume que tienes un archivo de configuración de DB (mysql pool/connection)

router.get('/inventario', (req, res) => {
  const query = `
    SELECT m.id_material AS id, m.nombre, m.descripcion, m.stock_minimo AS quantity, 
           c.categoria AS category
    FROM materiales m
    LEFT JOIN categorias_material c ON m.id_categoria = c.id_categoria
    WHERE m.activo = 1
    ORDER BY m.id_material DESC
  `;
  
  db.query(query, (err, results) => {
    if (err) {
      console.error('Error al consultar inventario:', err);
      return res.status(500).json({ error: 'Error al obtener el inventario' });
    }
    res.json(results);
  });
});

module.exports = router;
