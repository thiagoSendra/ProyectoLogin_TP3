document.addEventListener("DOMContentLoaded", () => {
    const formLogin = document.getElementById("formLogin");
    const formRegistro = document.getElementById("formRegistro");

    if (formLogin) {
        formLogin.addEventListener("submit", (e) => {
            let valido = true;
            const correo = document.getElementById("correo").value.trim();
            const password = document.getElementById("password").value;

            document.getElementById("errorCorreo").textContent = "";
            document.getElementById("errorPassword").textContent = "";

            if (correo === "") {
                document.getElementById("errorCorreo").textContent = "El correo es obligatorio.";
                valido = false;
            }

            if (password === "") {
                document.getElementById("errorPassword").textContent = "La contraseña es obligatoria.";
                valido = false;
            } else if (password.length < 8) {
                document.getElementById("errorPassword").textContent = "Debe tener al menos 8 caracteres.";
                valido = false;
            }

            if (!valido) e.preventDefault();
        });
    }

    if (formRegistro) {
        formRegistro.addEventListener("submit", (e) => {
            let valido = true;
            const nombre = document.getElementById("nombre").value.trim();
            const apellido = document.getElementById("apellido").value.trim();
            const correo = document.getElementById("correo").value.trim();
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;

            ["errorNombre", "errorApellido", "errorCorreo", "errorPassword", "errorConfirmPassword"].forEach(id => {
                document.getElementById(id).textContent = "";
            });

            if (nombre === "") {
                document.getElementById("errorNombre").textContent = "El nombre es obligatorio.";
                valido = false;
            }

            if (apellido === "") {
                document.getElementById("errorApellido").textContent = "El apellido es obligatorio.";
                valido = false;
            }

            if (correo === "") {
                document.getElementById("errorCorreo").textContent = "El correo es obligatorio.";
                valido = false;
            }

            const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (password === "") {
                document.getElementById("errorPassword").textContent = "La contraseña es obligatoria.";
                valido = false;
            } else if (!regexPassword.test(password)) {
                document.getElementById("errorPassword").textContent = "Debe tener mín 8 caracteres, mayúscula, minúscula, número y símbolo.";
                valido = false;
            }

            if (confirmPassword === "") {
                document.getElementById("errorConfirmPassword").textContent = "Debes confirmar la contraseña.";
                valido = false;
            } else if (password !== confirmPassword) {
                document.getElementById("errorConfirmPassword").textContent = "Las contraseñas no coinciden.";
                valido = false;
            }

            if (!valido) e.preventDefault();
        });
    }
});
