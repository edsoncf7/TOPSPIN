const User = require('../models/user');
const bcrypt = require('bcrypt');

// Renderiza login.ejs
const renderLogin = (req, res) => {
  res.render('login', {
    error: null,
    notificacion: null
  });
};

// Procesa el formulario
const loginUser = async (req, res) => {
  const { correo, contraseña, rol } = req.body;

  try {
    const user = await User.findOne({ where: { correo } });

    if (!user) {
      return res.render('login', {
        notificacion: { tipo: 'error', mensaje: 'Correo no encontrado.' }
      });
    }

    if (user.rol !== rol) {
      return res.render('login', {
        notificacion: { tipo: 'error', mensaje: 'Rol incorrecto para este usuario.' }
      });
    }

    const match = await bcrypt.compare(contraseña, user.contraseña);
    if (!match) {
      return res.render('login', {
        notificacion: { tipo: 'error', mensaje: 'Contraseña incorrecta.' }
      });
    }

    // ✅ ahora sí puedes usar user
    req.session.usuario = {
      id: user.id,
      nombre: user.nombre,
      rol: user.rol
    };

    res.redirect('/catalogo');

  } catch (error) {
    console.error('Error al iniciar sesión:', error);
    res.status(500).send('Error al iniciar sesión: ' + error.message);
  }
};


const registerUser = async (req, res) => {
  const { nombre, correo, contraseña, telefono, direccion, rol, fecha_nacimiento } = req.body;
  const rolesValidos = ['cliente', 'tecnico', 'admin'];

  try {
    console.log('📥 Datos recibidos:', req.body);

    // Validar rol
    if (!rolesValidos.includes(rol)) {
      return res.render('register', {
        notificacion: { tipo: 'error', mensaje: 'Rol inválido. Debe ser cliente, tecnico o admin.' },
        maxDate: new Date().toISOString().split('T')[0]
      });
    }

    // Verificar si ya existe un usuario con ese correo
    const existingUser = await User.findOne({ where: { correo } });
    if (existingUser) {
      return res.render('register', {
        notificacion: { tipo: 'error', mensaje: 'Ya existe un usuario registrado con ese correo.' },
        maxDate: new Date().toISOString().split('T')[0]
      });
    }

    const hashedPassword = await bcrypt.hash(contraseña, 10);

    const nuevoUsuario = await User.create({
      nombre,
      correo,
      contraseña: hashedPassword,
      telefono,
      direccion,
      rol,
      fecha_nacimiento
    });

    console.log('✅ Usuario registrado correctamente:', nuevoUsuario.toJSON());

    // Redirige al login tras registro exitoso
    res.redirect('/login');

  } catch (error) {
    console.error('❌ Error al registrar usuario:', error);
    res.status(500).send('Error al registrar usuario: ' + error.message);
  }
};



const renderRegister = (req, res) => {
  const today = new Date().toISOString().split('T')[0];
  res.render('register', {
    maxDate: today,
    notificacion: null // 💥 Esta línea es esencial
  });
};




module.exports = {
  renderLogin,
  loginUser,
  renderRegister,
  registerUser
};
