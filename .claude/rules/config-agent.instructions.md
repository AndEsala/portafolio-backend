---
description: Describe when these instructions should be loaded
paths:
. - "src/**/*.ts"
---

<!-- Tip: Use /create-instructions in chat to generate content with agent assistance -->

Eres un asistente de desarrollo de software experto y riguroso. Para cualquier tarea, generación de código o refactorización en este proyecto, DEBES adherirte estrictamente a las siguientes directrices:

1. **Estructura y Arquitectura (Fuente de la Verdad):**
   - Utiliza SIEMPRE el archivo `documentation.md` o `architecture.md` como la base fundamental para el manejo de la estructura del proyecto.
   - Toda nueva funcionalidad, módulo o componente DEBE implementarse respetando al 100% los patrones y la estructura definida en ese documento. No inventes arquitecturas ajenas al proyecto.

2. **Lógica de Negocio y Datos:**
   - Para entender el dominio del problema, DEBES analizar y basar tu código en los modelos definidos en `modelo.conceptual.puml` y `modelo-er.puml`. Esto solo aplica si esos archivos existen en el proyecto. Si no existen, pide confirmación sobre dónde encontrar la información de dominio relevante o cómo proceder.
   - Garantiza que la creación de entidades, migraciones, relaciones y lógica de negocio reflejen exactamente la estructura de datos plasmada en esos diagramas.

3. **Convenciones de Nomenclatura e Idioma:**
   - **Código en INGLÉS:** Todos los nombres de clases, interfaces, métodos, variables y propiedades DEBEN escribirse en inglés (por ejemplo: `UserController`, `paymentStatus`). No mezcles idiomas en el código fuente.
   - **Base de Datos en INGLÉS y PLURAL:** Los nombres de las tablas en la base de datos DEBEN estar en inglés y estrictamente en PLURAL (por ejemplo: `users`, `certificates`, `meeting_minutes`).
   - **Salida al Cliente en ESPAÑOL:** Todos los mensajes de validación, respuestas de error de la API, excepciones manejadas y cualquier texto de retroalimentación destinado al cliente final DEBEN redactarse en español claro y profesional (por ejemplo: "El campo documento es obligatorio").

4. **Manejo de Conflictos:**
   - Si una solicitud requiere implementar algo que contradice `documentation.md` o los diagramas `.puml`, NO asumas la solución ni rompas las reglas. Detente y pídeme confirmación sobre cómo proceder o cómo actualizar la documentación primero.
