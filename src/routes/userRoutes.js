const express = require('express');
const router = express.Router();
const userController = require('../controllers/userController');

router.get('/login', userController.renderLogin);
router.post('/login', userController.loginUser);

router.get('/register', userController.renderRegister);
router.post('/register', userController.registerUser);

router.get('/catalogo', (req, res) => {
  const productos = [
    { nombre: 'Raqueta A', precio: 320, imagen: 'https://via.placeholder.com/150' },
    { nombre: 'Raqueta B', precio: 280, imagen: 'https://via.placeholder.com/150' }
  ];

  res.render('catalogo', {
    productos,
    usuario: req.session.usuario || null // 👈 Esto es lo que estaba faltando
  });
});


module.exports = router;
