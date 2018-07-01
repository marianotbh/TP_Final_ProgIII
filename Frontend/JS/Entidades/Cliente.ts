namespace Facultad{
    export class Cliente extends Persona{
        private edad:number;
        private sexo:string;

        constructor(id:number,nombre:string,apellido:string,edad:number,sexo:string) {
            super(id,nombre,apellido);
            this.edad = edad;
            this.sexo = sexo;
        }

        public getEdad():number{
            return this.edad;
        }

        public setEdad(edad:number):void{
            this.edad = edad;
        }

        public getSexo():string{
            return this.sexo;
        }

        public setSexo(sexo:string):void{
            this.sexo = sexo;
        }

        public toJSON():string{
            return '{"id":'+this.getID()+',"nombre":"'+this.getNombre()+'","apellido":"'+this.getApellido()+'","edad":'+this.getEdad()+',"sexo":"'+this.getSexo()+'"}';
        }
    }
}