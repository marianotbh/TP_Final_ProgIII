namespace Facultad {
    export class Funciones {
        private static listaClientes: Array<Cliente> = new Array();
        private static nombreValido: boolean = false;
        private static apellidoValido: boolean = false;
        private static edadValido: boolean = false;

        public static CargarFormulario(id:number){
            for (var i = 0; i < this.listaClientes.length; i++) {
                let cliente:Cliente = this.listaClientes[i];
                if (cliente.getID() === id) {
                    $("#id").val(cliente.getID());
                    $("#nombre").val(cliente.getNombre());
                    $("#apellido").val(cliente.getApellido());
                    $("#edad").val(cliente.getEdad());
                    $("#sexo").val(cliente.getSexo());
                    break;
                }
            }
        }

        public static Borrar() {
            let id:number = Number($("#id").val());
            let flagBorro:boolean = false;
            for (var i = 0; i < this.listaClientes.length; i++) {
                let cliente = this.listaClientes[i];
                if (cliente.getID() === id) {
                    this.listaClientes.splice(i, 1);
                    flagBorro = true;
                    break;
                }
            }

            if(!flagBorro){
                alert("No se encontró coincidencia con el ID.");
            }

            localStorage.setItem("clientes", this.listaClientesToJson());
            this.llenarGrilla(this.listaClientes);
            this.LimpiarFormulario();
            this.default();
        }

        //Busca el ID más alto de la lista.
        public static BuscarIDMasAlto():number{
            let IDMasAlto: number = this.listaClientes.reduce(function (IDMasAlto, cliente, i, array) {
                if(cliente.getID() > IDMasAlto){
                    IDMasAlto = cliente.getID();
                }
                return IDMasAlto;
            }, 0);

            return IDMasAlto;
        }

        //Carga un nuevo cliente a la lista. 
        public static Alta(): void {
            let nombre: string = String($("#nombre").val());
            let apellido: string = String($("#apellido").val());
            let edad: number = Number($("#edad").val());
            let sexo: string = String($("#sexo").val());

            let cliente = new Cliente(this.BuscarIDMasAlto()+1,nombre, apellido, edad, sexo);
            this.listaClientes.push(cliente);
            localStorage.setItem("clientes", this.listaClientesToJson());
            this.llenarGrilla(this.listaClientes);
            this.LimpiarFormulario();
            this.default();
        }

        //Pasa la lista de clientes a formato JSON (string)
        private static listaClientesToJson(): string {
            if(this.listaClientes.length > 0){
                let listaJson: string = "[";
                this.listaClientes.forEach(function (cliente) {
                    listaJson += cliente.toJSON();
                    listaJson += ",";
                });
                listaJson = listaJson.slice(0, -1);
                listaJson += "]";
                return listaJson;
            }
            return "";
        }

        //Pasa el JSON almacenado en el LocalStorage y genera a lista de clientes.
        private static LocalStorageTolistaClientes(): void {
            let LSString:string = String(localStorage.getItem("clientes"));
            if(LSString != null && LSString != ""){
                let listaJson = JSON.parse(LSString);
                {
                    if(listaJson != null){
                        for (var i = 0; i < listaJson.length; i++) {
                            let id = listaJson[i].id;
                            let nombre = listaJson[i].nombre;
                            let apellido = listaJson[i].apellido;
                            let edad = listaJson[i].edad;
                            let sexo = listaJson[i].sexo;
            
                            var cliente = new Cliente(id, nombre, apellido, edad, sexo);
                            this.listaClientes.push(cliente);
                        }
                    }                    
                } 
            }                       
        }

        //Limpia el formulario
        public static LimpiarFormulario(): void {
            $("#nombre").val("");
            $("#apellido").val("");
            $("#edad").val("");
            $("#sexo").val("Masculino");
            $("#nombreGroup").removeClass("has-error has-feedback");
            $("#helpNombre").hide();
            $("#apellidoGroup").removeClass("has-error has-feedback");
            $("#helpApellido").hide();
            $("#edadGroup").removeClass("has-error has-feedback");
            $("#helpEdad").hide();
            this.nombreValido = false;
            this.apellidoValido = false;
            this.edadValido = false;
        }

        //Se llama cuando cambia el estado de los checkbox y llama a llenar grilla.
        public static Checkbox_OnChange():void{
            this.llenarGrilla(this.listaClientes);
        }

        //Dibuja la grilla y la llena de los datos correspondientes. 
        public static llenarGrilla(arrayClientes: Array<Cliente>): void {
            let mostrarID: boolean = Boolean($("#mostrarID").is(":checked"));
            let mostrarNombre: boolean = Boolean($("#mostrarNombre").is(":checked"));
            let mostrarApellido: boolean = Boolean($("#mostrarApellido").is(":checked"));
            let mostrarEdad: boolean = Boolean($("#mostrarEdad").is(":checked"));
            let mostrarSexo: boolean = Boolean($("#mostrarSexo").is(":checked"));
            let html = "<thead>" +
                "<tr>";
            if (mostrarID) {
                html += "<th>ID</th>";
            }
            if (mostrarNombre) {
                html += "<th>Nombre</th>";
            }
            if (mostrarApellido) {
                html += "<th>Apellido</th>";
            }
            if (mostrarEdad) {
                html += "<th>Edad</th>";
            }
            if (mostrarSexo) {
                html += "<th>Sexo</th>";
            }
            html += "</tr>" +
                "</thead>" +
                "<tbody>";


            arrayClientes.forEach(function (cliente) {
                html += "<tr class='trSeleccionable' onclick='Facultad.Funciones.CargarFormulario("+cliente.getID()+")'>";
                if (mostrarID) {
                    html += "<td>" + cliente.getID() + "</td>";
                }
                if (mostrarNombre) {
                    html += "<td>" + cliente.getNombre() + "</td>";
                }
                if (mostrarApellido) {
                    html += "<td>" + cliente.getApellido() + "</td>";
                }
                if (mostrarEdad) {
                    html += "<td>" + cliente.getEdad() + "</td>";
                }
                if (mostrarSexo) {
                    html += "<td>" + cliente.getSexo() + "</td>";
                }
                html += "</tr>";
            });

            html += "</tbody>";

            $("#tabla").html(html);
        }

        //Filtra por nombre la grilla.
        public static FiltrarNombre(): void {
            let filtro: String = String($("#txtFiltroNombre").val());
            let arrayFiltrado: Array<Cliente> = this.listaClientes.filter(function (Cliente: Cliente, i: Number, array: Array<Cliente>) {
                if (Cliente.getNombre().match("^" + filtro + "[a-zA-Z\s]*")) {
                    return true;
                }
                return false;
            });
            this.llenarGrilla(arrayFiltrado);
        }

        public static OnLoad(): void {
            this.default();
            this.LocalStorageTolistaClientes();
            this.llenarGrilla(this.listaClientes);
        }

        public static default(): void {
            $("#helpNombre").hide();
            $("#helpApellido").hide();
            $("#helpEdad").hide();
        }

        //Valida que se haya ingresado un apellido correcto.
        public static ValidarNombre(): void {
            let nombre: string = String($("#nombre").val());

            if (nombre === "" || !nombre.match("^[a-zA-Z]*$")) {
                $("#nombreGroup").addClass("has-error has-feedback");
                $("#helpNombre").show();
                this.nombreValido = false;
            }
            else {
                $("#nombreGroup").removeClass("has-error has-feedback");
                $("#helpNombre").hide();
                this.nombreValido = true;
            }
        }

        //Valida que se haya ingresado un apellido correcto.
        public static ValidarApellido(): void {
            let apellido: string = String($("#apellido").val());

            if (apellido === "" || !apellido.match("^[a-zA-Z]*$")) {
                $("#apellidoGroup").addClass("has-error has-feedback");
                $("#helpApellido").show();
                this.apellidoValido = false;
            }
            else {
                $("#apellidoGroup").removeClass("has-error has-feedback");
                $("#helpApellido").hide();
                this.apellidoValido = true;
            }
        }

        //Valida que se haya ingresado una edad correcta.
        public static ValidarEdad(): void {
            let edad: number = Number($("#edad").val());

            if (edad < 1 || edad > 99) {
                $("#edadGroup").addClass("has-error has-feedback");
                this.edadValido = false;
                $("#helpEdad").show();
            }
            else {
                $("#edadGroup").removeClass("has-error has-feedback");
                this.edadValido = true;
                $("#helpEdad").hide();
            }
        }

        //No deja dar de alta si no están todos los datos válidos
        public static ValidarBotonAlta(): void {
            this.ValidarEdad();
            this.ValidarNombre();
            this.ValidarApellido();
            if (this.nombreValido && this.apellidoValido && this.edadValido) {
                this.Alta();
            }
        }

        //Calcula el promedio de edades y lo muestra.
        public static GenerarEstadisticas(): void{
            let sumaNotas:number = this.listaClientes.reduce(function(total,cliente,i,array){
                return total += cliente.getEdad();
            },0);
            let promedio:number = sumaNotas / this.listaClientes.length;
            $("#txtPromedio").val(String(promedio));
        }

        //Limpia el localstorage. ATENCION: Si se vuelve a cargar un cliente se volverá a llenar el LS con toda la lista.
        public static LimpiarLocalStorage(){
            localStorage.setItem("clientes", "");
        }
    }
}