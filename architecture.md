# Arquitectura del Portafolio Personal

## Visión General
El portafolio utiliza una arquitectura **Headless** (desacoplada). El frontend público se comunica con el backend a través de una API RESTful. La gestión de contenido se realiza mediante un panel de administración integrado en el backend.

## Stack Tecnológico

### 1. Frontend (Aplicación Cliente)
* **Tecnología:** React / Next.js
* **Estilos:** Tailwind CSS + Componentes tipo shadcn/ui.
* **Responsabilidad:** Consumir la API REST, renderizar la interfaz de usuario (UI), manejar el estado del cliente (Modo Claro/Oscuro) y capturar los datos del formulario de contacto.

### 2. Backend (API RESTful)
* **Tecnología:** Laravel
* **Responsabilidad:** Proveer endpoints seguros (JSON) para alimentar el frontend. Procesar peticiones, validar datos (ej. formulario de contacto) y gestionar la lógica de negocio.

### 3. Panel de Administración (Dashboard)
* **Tecnología:** FilamentPHP (Stack TALL: Tailwind, Alpine.js, Laravel, Livewire)
* **Responsabilidad:** Interfaz gráfica para realizar el CRUD (Crear, Leer, Actualizar, Borrar) de la información del portafolio (proyectos, habilidades, perfil, mensajes) sin tocar código.

### 4. Base de Datos
* **Tecnología:** PostgreSQL
* **Responsabilidad:** Almacenamiento persistente y relacional de toda la información dinámica del portafolio.

### 5. Infraestructura y Despliegue
* **Contenedorización:** Docker (para empaquetar la aplicación y asegurar consistencia entre entornos).
* **Servidor Web / Proxy Inverso:** Nginx.
