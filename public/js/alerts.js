// alerts.js

// Función para mostrar una alerta Toastify
function showToast(message, backgroundColor = "#4CAF50") {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: backgroundColor,
    }).showToast();
}

// Detectar si hay un mensaje de éxito o error desde la sesión de Laravel
document.addEventListener("DOMContentLoaded", function() {
    const successMessage = document.querySelector('meta[name="toast-success"]')?.content;
    const errorMessage = document.querySelector('meta[name="toast-error"]')?.content;

    if (successMessage) showToast(successMessage, "#4CAF50");
    if (errorMessage) showToast(errorMessage, "#f44336");
});
