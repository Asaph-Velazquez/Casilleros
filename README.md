# 🗄️ ESCOM Casilleros

<div align="center">

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

*Sistema de asignación de casilleros para estudiantes - Proyecto de aprendizaje*

</div>

---

## 📋 Descripción

ESCOM Casilleros es una plataforma web diseñada para la **gestión de casilleros** en la Escuela Superior de Cómputo (ESCOM-IPN). Permite a los estudiantes solicitar, renovar y gestionar sus casilleros de manera digital, eliminando el proceso y centralizando la administración.

> 🎓 *Proyecto académico de desarrollo web*

---

## 🧠 Habilidades y Tecnologías Aprendidas

### 🖥️ Frontend

| Tecnología | Nivel | Aplicación |
|------------|-------|------------|
| **HTML5** | 🟡 Intermedio | Estructura semántica de todas las páginas |
| **CSS3** | 🟡 Intermedio | Estilos personalizados, diseño responsivo |
| **Bootstrap 5** | 🟡 Intermedio | Componentes UI, grid system, modales |
| **JavaScript** | 🟡 Intermedio | DOM manipulation, eventos, validaciones |

### ⚙️ Backend

| Tecnología | Nivel | Aplicación |
|------------|-------|------------|
| **PHP** | 🟡 Intermedio | Lógica del servidor, sesiones, APIs |
| **MySQL** | 🟡 Intermedio | Diseño de base de datos relacional |
| **FPDF** | 🔵 Básico | Generación de PDFs (constancias) |

### ✅ Conceptos Implementados

- 🔐 **Sistema de autenticación** con sesiones PHP (estudiantes y administradores)
- 📝 **CRUD completo** de solicitudes de casilleros
- 📤 **Subida de archivos** (credencial escolar, horario de clases)
- 📱 **Diseño responsivo** (mobile-first approach)
- 📄 **Generación de documentos PDF** (acuse de solicitud)
- 🔔 **Gestión de estatus** de solicitudes (Pendiente, Asignado, Lista de espera)
- 👥 **Panel de administración** para gestionar casilleros y solicitudes

---

## 🏗️ Arquitectura y Estructura

```
Casilleros/
├── css/                    # Estilos personalizados
│   ├── app.css
│   ├── login.css
│   ├── admon.css
│   └── ...
├── html/                   # Páginas del frontend
│   ├── PagPrincipal.html   # Página principal
│   ├── Solicitud.html      # Formulario de solicitud
│   ├── login.html          # Login de estudiantes
│   ├── admon.php           # Panel de administración
│   └── ...
├── imgs/                   # Recursos gráficos
│   ├── logoIPN.png
│   ├── logoEscom.png
│   └── ...
├── js/                     # JavaScript del cliente
│   ├── login/
│   ├── Solicitud_html/
│   └── vistaAdmin/
├── php/                    # Backend
│   ├── Admin/              # Endpoints de administración
│   │   ├── casilleros.php
│   │   ├── verDatos.php
│   │   └── ...
│   ├── Php_Html_estudiante/
│   ├── fpdf186/            # Biblioteca para PDFs
│   ├── uploads/            # Archivos subidos
│   ├── EstudianteValidarLogin.php
│   ├── AdminValidarLogin.php
│   ├── ProcesarForm.php
│   └── genPDF.php
├── sql/
│   └── Casilleros.sql      # Esquema de base de datos
└── README.md
```

### 🗄️ Base de Datos (4 tablas)

```
┌─────────────┐     ┌─────────────┐
│ estudiantes │────▶│ solicitudes │
└─────────────┘     └─────────────┘
                           │
                           ▼
┌─────────────┐     ┌─────────────┐
│administradores│     │ casilleros │
└─────────────┘     └─────────────┘
```

**Relaciones aprendidas:**
- 📊 **One-to-Many** (estudiante → solicitudes)
- 📊 **One-to-Many** (casillero → solicitudes)

---

## 📂 Páginas Implementadas

| Página | Funcionalidad | Lo Aprendido |
|--------|---------------|--------------|
| `PagPrincipal.html` | Home con noticias e información | HTML + CSS |
| `login.html` | Autenticación de estudiantes | Sesiones PHP |
| `Solicitud.html` | Solicitar/renovar casillero | Formularios + validaciones |
| `admon.php` | Panel de administración | CRUD completo |
| `acceso1.php`, `acceso2.php`, `acceso3.php` | Vistas de estado de solicitud | Consultas SQL |
| `genPDF.php` | Generar acuse en PDF | FPDF + PHP |
| `noticia*.html` | Noticias del instituto | HTML básico |

---

## 🚀 Desafíos Técnicos Resueltos

| # | Desafío | Solución |
|---|---------|----------|
| 1 | **Gestión de sesiones** | Implementé autenticación separada para estudiantes y administradores |
| 2 | **Subida de archivos** | Validación de PDFs (credencial, horario) con PHP |
| 3 | **Relaciones estudiante-casillero** | Diseñé esquema con tablas de solicitudes intermedias |
| 4 | **Generación de PDFs** | Integré FPDF para generar constancias de solicitud |
| 5 | **Diseño responsivo** | Bootstrap + CSS custom para móvil y escritorio |
| 6 | **Validaciones en cliente y servidor** | JavaScript para feedback inmediato + PHP para validación final |

---

## 💻 Instalación

### Requisitos Previos

- 🟠 XAMPP (Apache + MySQL + PHP)
- 🟠 Navegador web moderno

### Pasos

1. **Instala XAMPP** y ejecuta Apache + MySQL

2. **Crea la base de datos**
   - Accede a `http://localhost/phpmyadmin/`
   - Crea una BD llamada `casilleros`
   - Importa el archivo `sql/Casilleros.sql`

3. **Copia el proyecto** a tu servidor
   - Copia la carpeta `Casilleros` a `C:\xampp\htdocs\`

4. **¡Listo!** Accede a `http://localhost/Casilleros/html/PagPrincipal.html`

### Credenciales de prueba

**Administrador:**
- Usuario: `admin1`
- Contraseña: `admin123`

**Estudiante:**
- Boleta: `2023630284`
- Contraseña: `12345678`

---

## 🎯 Lo que aprendí con este proyecto

> *"Este proyecto fue mi primer enfoque serio al desarrollo full-stack"*

- 🗃️ **Planeación de base de datos**: Diseñé el esquema relacional antes de programar
- 🎯 **Separación de responsabilidades**: PHP para lógica, HTML/CSS para presentación
- 🐛 **Debugging**: Aprendí a leer errores de PHP y MySQL
- 🎨 **UX básico**: Cómo hacer una interfaz intuitiva para usuarios
- 📤 **Manejo de archivos**: Validar y almacenar archivos subidos por usuarios
- 📄 **Generación de PDFs**: Crear documentos dinámicos desde el servidor

---

## 📜 Licencia

<div align="center">

*Proyecto educativo - Uso personal y de aprendizaje*

---
</div>
