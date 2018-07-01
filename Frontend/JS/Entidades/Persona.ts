namespace Facultad{
    export class Persona{
        private id:number;
        private nombre:string;
        private apellido:string;
    
        constructor(id:number,nombre:string,apellido:string) {
            this.id = id;
            this.nombre = nombre;
            this.apellido = apellido;
        }
                
        public getID():number{
            return this.id;
        }

        public setID(id:number):void{
            this.id = id;
        }

        public getNombre():string{
            return this.nombre;
        }

        public setNombre(nombre:string):void{
            this.nombre = nombre;
        }

        public getApellido():string{
            return this.apellido;
        }

        public setApellido(apellido:string):void{
            this.apellido = apellido;
        }
    }
}