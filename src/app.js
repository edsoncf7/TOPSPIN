const express = require('express');
const path = require('path');
const session = require('express-session');

const app = express();

// Configuración del motor de vistas
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Middleware para servir archivos públicos
app.use(express.static(path.join(__dirname, '../public')));

// Middleware para procesar formularios
app.use(express.urlencoded({ extended: false }));

// ✅ Middleware de sesión DEBE IR ANTES de usar rutas
app.use(session({
  secret: 'topspin_secreto123',
  resave: false,
  saveUninitialized: false
}));

// Importar rutas y base de datos
const userRoutes = require('./routes/userRoutes');
const sequelize = require('./config/database');

// Usar rutas
app.use('/', userRoutes);

// Ruta por defecto
app.get('/', (req, res) => {
  res.render('index', { title: 'Bienvenido a TopSpin' });
});

// Conectar a base de datos
sequelize.sync()
  .then(() => console.log('Base de datos conectada y sincronizada'))
  .catch(err => console.error('Error al conectar la base de datos', err));

// Iniciar servidor
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Servidor corriendo en http://localhost:${PORT}`);
});
