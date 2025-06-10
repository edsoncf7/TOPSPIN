const { Sequelize } = require('sequelize');
require('dotenv').config();

const sequelize = new Sequelize(
  process.env.DB_NAME,
  process.env.DB_USER,
  process.env.DB_PASS,
  {
    host: process.env.DB_HOST,
    port: process.env.DB_PORT,  // <-- Asegúrate de incluir esto si usas otro puerto como 3307
    dialect: 'mysql'
  }
);

module.exports = sequelize;

sequelize.sync({ alter: true })
  .then(() => console.log('Base de datos conectada y sincronizada'))
  .catch((err) => console.error('Error al conectar la base de datos:', err));

