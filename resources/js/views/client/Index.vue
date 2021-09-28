<template>
  <div class="mixin-components-container">
    <el-row>
      <el-card class="box-card">
        <div slot="header" class="clearfix">
          <span>Cliente</span>
        </div>
        <div style="margin-bottom: 50px">
          <div class="filter-container">
            <el-input
              v-model="listQuery.name"
              placeholder="Nombre"
              style="width: 200px"
              class="filter-item"
              @keyup.enter.native="handleFilter"
            />

            <el-button
              v-waves
              class="filter-item"
              type="primary"
              icon="el-icon-search"
              @click="handleFilter"
            >
              {{ $t('table.search') }}
            </el-button>
            <el-button
              class="filter-item"
              style="margin-left: 10px"
              type="primary"
              icon="el-icon-plus"
              @click="handleCreate"
            >
              {{ $t('table.add') }}
            </el-button>
          </div>
        </div>
        <el-table
          :key="tableKey"
          v-loading="listLoading"
          :data="list"
          border
          fit
          highlight-current-row
          style="width: 100%"
          @sort-change="sortChange"
        >
          <el-table-column
            label="Nombre"
            prop="name"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.first_name }} {{ scope.row.last_name }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Tipo documento"
            prop="document_type"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.document_type }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Numero de documento"
            prop="document_number"
            align="center"
            width="180px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.document_number }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Direccion"
            prop="direction"
            align="center"
            min-width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.direction }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Correo"
            prop="email"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.email }}</span>
            </template>
          </el-table-column>
          <el-table-column
            label="Telefono"
            prop="phone"
            align="center"
            width="150px"
          >
            <template slot-scope="scope">
              <span>{{ scope.row.phone }}</span>
            </template>
          </el-table-column>
          <el-table-column label="Estado" class-name="status-col" width="100">
            <template slot-scope="{row}">
              <div v-if="row.status == 1">
                <el-tag type="success" class="tag-item el-tag el-tag--medium el-tag--light">
                  <i class="el-icon-open" /> Activo
                </el-tag>
              </div>
              <div v-else>
                <el-tag type="danger">
                  <i class="el-icon-turn-off" /> Inactivo
                </el-tag>
              </div>
            </template>
          </el-table-column>
          <el-table-column label="Acciones" align="center" width="330" class-name="small-padding fixed-width">
            <template slot-scope="{row}">
              <el-button type="primary" icon="el-icon-edit-outline" size="small" @click="handleUpdate(row)" />
              <el-button v-if="row.status==1" icon="el-icon-turn-off" size="small" type="danger" @click="handleModifyStatus(row, 0)">
                Inactivar
              </el-button>
              <el-button v-if="row.status==0" icon="el-icon-open" size="small" type="success" @click="handleModifyStatus(row, 1)">
                Activar
              </el-button>
              <el-button :v-if="true" size="small" type="success" @click="modalPet(row)">
                Mascotas
              </el-button>
            </template>
          </el-table-column>
        </el-table>

        <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" />

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" style="min-width:50vh;">

          <el-form ref="dataForm" :rules="rules" :model="temp" style="padding:0px 30px;">
            <el-form-item label="Tipo:" prop="document_type">
              <el-select v-model="temp.document_type" placeholder="Seleccionar" id="document_type" style="width:100%">
                <el-option
                  v-for="item in options"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
            <el-form-item label="Número:" prop="document_number">
              <el-input v-model="temp.document_number" />
            </el-form-item>
            <el-form-item label="Nombre:" prop="first_name">
              <el-input v-model="temp.first_name" />
            </el-form-item>
            <el-form-item label="Apellido:" prop="last_name">
              <el-input v-model="temp.last_name" />
            </el-form-item>
            <el-form-item label="Dirección" prop="direction">
              <el-input v-model="temp.direction" />
            </el-form-item>
            <el-form-item label="Correo" prop="email">
              <el-input v-model="temp.email" />
            </el-form-item>
            <el-form-item label="Teléfono" prop="phone">
              <el-input v-model="temp.phone" />
            </el-form-item>
          </el-form>
          <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisible = false">
              {{ $t('table.cancel') }}
            </el-button>
            <el-button type="primary" @click="dialogStatus==='create'?createData():updateData()">
              {{ $t('table.confirm') }}
            </el-button>
          </div>

        </el-dialog>

        <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisiblePet">
          <div>
            <el-table
              :key="table1Key"
              v-loading="listLoading"
              :data="listPets"
              border
              fit
              highlight-current-row
              style="width: 100%"
              @sort-change="sortChange"
            >
              <el-table-column
                label="Nombre"
                prop="name"
                align="center"
                min-width="150px"
              >
                <template slot-scope="scope">
                  <span>{{ scope.row.name }}</span>
                </template>
              </el-table-column>
              <el-table-column
                label="Tipo Mascota"
                prop="specie"
                align="center"
                min-width="80px"
              >
                <template slot-scope="scope">
                  <span>{{ scope.row.specie }}</span>
                </template>
              </el-table-column>
              <el-table-column
                label="Sexo"
                prop="sex"
                align="center"
                width="105px"
              >
                <template slot-scope="scope">
                  <span>{{ scope.row.sex }}</span>
                </template>
              </el-table-column>
            </el-table>
          </div>
          <div slot="footer" class="dialog-footer">
            <el-button @click="dialogFormVisiblePet = false">
              {{ $t('table.cancel') }}
            </el-button>
          </div>
        </el-dialog>
      </el-card>
    </el-row>
  </div>
</template>
<script>
import { fetchList, createClient, updateClient, listPet } from '@/api/Client';
import waves from '@/directive/waves'; // Waves directive
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination

export default {
  components: { Pagination },
  directives: { waves },
  data() {
    var validateDocumentType = (rule, value, callback) => {
      let select = document.getElementById('document_type').value;
      if(select === "Cedula"){
        let valCedula = this.verificarCedula(value);
        if (valCedula !== true && value.length == 10) {
          callback(new Error('Número de cédula es inválido'));
        } else if(value.length > 10){
          callback(new Error('La Cédula requiere de 10 digitos'));
        }else {
          if (this.dialogStatus === "create"){
            
            Object.entries(this.list).forEach(([key, valor]) => {
              if (value === valor.document_number){
                console.log("Numero registrado");
                  callback(new Error('Número de cédula ya está registrado'));
              }else{
                callback();
              }
            });
          }else {
            callback();
          }
        }
      }else{
        let valRuc = this.verificacionRuc(value);
        if (valRuc !== true && value.length == 13) {
          callback(new Error('Número de RUC es inválido'));
        } else if(value.length >= 10 && value.length < 13){
          callback(new Error('El RUC requiere de 13 digitos'));
        } else {
          if (this.dialogStatus === "create"){
            Object.entries(this.list).forEach(([key, valor]) => {
              if (value === valor.document_number){
                 console.log("Numero RUC");
                  callback(new Error('Número de RUC ya está registrado'));
              }else{
                callback();
              }
            });
          }else {
            callback();
          }
        }
      }
      
    };
    return {
      tableKey: 0,
      table1Key: 0,
      listQuery: {
        page: 1,
        limit: 20,
        importance: undefined,
        name: undefined,
        type: undefined,
        sort: '+id',
      },
      listLoading: false,
      list: null,
      listPets: null,
      showReviewer: false,
      dialogFormVisible: false,
      dialogFormVisiblePet: false,
      dialogStatus: '',
      total: 0,
      textMap: {
        update: 'Editar',
        create: 'Agregar nuevo cliente',
        datos_mascotas: 'Lista Mascota',
      },
      rules: {
        name: [{ required: true, message: 'Campo requerido', trigger: 'change' }],
        document_type: [{ required: true, message: 'Campo requerido', trigger: 'change' }],
        document_number: [
          { required: true, message: 'Campo requerido', trigger: 'change' },
          { min: 10, message: 'El campo requiere de 10 digitos', trigger: ['blur', 'change']},
          { max: 13, message: 'Este campo acepta máximo 13 digitos', trigger: ['blur', 'change']},
          { validator: validateDocumentType, trigger: 'blur' }],
        first_name: [{ required: true, message: 'Campo requerido', trigger: 'change' },
                     { pattern: /^[A-Z]+$/i, message: 'Solo se puede ingresar letras', trigger: 'blur'}],
        last_name: [{ required: true, message: 'Campo requerido', trigger: 'change' },
                    { pattern: /^[A-Z]+$/i, message: 'Solo se puede ingresar letras', trigger: 'blur'}],
        direction: [{ required: true, message: 'Campo requerido', trigger: 'change' }],
        email: [
          { required: true, message: 'Campo requerido', trigger: 'blur' },
          { type: 'email', message: 'Por favor, ingrese una direccion de correo válida', trigger: ['blur', 'change'] },
        ],
        phone: [{ required: true, message: 'Campo requerido', trigger: 'change' },
                { min: 7, message: 'El campo requiere de 7 digitos', trigger: ['blur', 'change']},
                { max: 10, message: 'Este campo acepta máximo 10 digitos', trigger: ['blur', 'change']},
                { pattern: /^\d*$/, message: 'Solo se puede ingresar número', trigger: 'blur'}],
      },
      temp: {
        id: undefined,
        name: '',
        observation: '',
      },
      options: [
        {
          value: 'Cedula',
          label: 'Cedula',
        },
        {
          value: 'RUC',
          label: 'RUC',
        }],
    };
  },
  created() {
    this.getList();
  },
  methods: {
    handleFilter() {
      this.listQuery.page = 1;
      this.getList();
    },

    async getList() {
      this.listLoading = true;
      const { data } = await fetchList(this.listQuery);
      this.list = data.items;
      this.total = data.total;

      // Just to simulate the time of the request
      this.listLoading = false;
    },
    async getListPet() {
      this.listLoading = true;
      const { data } = await listPet(this.temp);
      this.listPets = data.items;

      // Just to simulate the time of the request
      this.listLoading = false;
      // console.log('datos_mascota', data.items);
    },
    sortChange(data) {
      const { prop, order } = data;
      if (prop === 'id') {
        this.sortByID(order);
      }
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        name: '',
        observation: '',
      };
    },
    handleCreate() {
      this.resetTemp();
      this.dialogStatus = 'create';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    createData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          this.temp.id = this.list[this.list.length - 1].id + 1;
          this.temp.status = 1;
          createClient(this.temp).then((response) => {
            this.list.push(this.temp);
            this.dialogFormVisible = false;

            this.$notify({
              title: 'Success',
              message: 'Created successfully',
              type: 'success',
              duration: 2000,
            });
          });
        }
      });
    },
    updateData() {
      this.$refs['dataForm'].validate((valid) => {
        if (valid) {
          updateClient(this.temp).then(() => {
            for (const v of this.list) {
              if (v.id === this.temp.id) {
                const index = this.list.indexOf(v);
                this.list.splice(index, 1, this.temp);
                break;
              }
            }
            this.dialogFormVisible = false;
            this.$notify({
              title: 'Success',
              message: 'Updated successfully',
              type: 'success',
              duration: 2000,
            });
          });
        }
      });
    },
    async handleModifyStatus(row, status) {
      this.listLoading = true;
      row.status = status;
      await updateClient(row);

      this.$message({
        message: 'Successful operation',
        type: 'success',
      });
      this.listLoading = false;
    },

    handleUpdate(row) {
      this.temp = Object.assign({}, row); // copy obj
      this.temp.timestamp = new Date(this.temp.timestamp);
      this.dialogStatus = 'update';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    modalPet(row) {
      this.temp = Object.assign({}, row); // copy obj
      this.dialogStatus = 'datos_mascotas';
      this.dialogFormVisiblePet = true;
      this.getListPet();
    },
    validacionCedula(cedula){

     //Preguntamos si la cedula consta de 10 digitos
     if(cedula.length == 10){
        
        //Obtenemos el digito de la region que sonlos dos primeros digitos
        var digito_region = cedula.substring(0,2);
        
        //Pregunto si la region existe ecuador se divide en 24 regiones
        if( digito_region >= 1 && digito_region <=24 ){
          
          // Extraigo el ultimo digito
          var ultimo_digito   = cedula.substring(9,10);

          //Agrupo todos los pares y los sumo
          var pares = parseInt(cedula.substring(1,2)) + parseInt(cedula.substring(3,4)) + parseInt(cedula.substring(5,6)) + parseInt(cedula.substring(7,8));

          //Agrupo los impares, los multiplico por un factor de 2, si la resultante es > que 9 le restamos el 9 a la resultante
          var numero1 = cedula.substring(0,1);
          var numero1 = (numero1 * 2);
          if( numero1 > 9 ){ var numero1 = (numero1 - 9); }

          var numero3 = cedula.substring(2,3);
          var numero3 = (numero3 * 2);
          if( numero3 > 9 ){ var numero3 = (numero3 - 9); }

          var numero5 = cedula.substring(4,5);
          var numero5 = (numero5 * 2);
          if( numero5 > 9 ){ var numero5 = (numero5 - 9); }

          var numero7 = cedula.substring(6,7);
          var numero7 = (numero7 * 2);
          if( numero7 > 9 ){ var numero7 = (numero7 - 9); }

          var numero9 = cedula.substring(8,9);
          var numero9 = (numero9 * 2);
          if( numero9 > 9 ){ var numero9 = (numero9 - 9); }

          var impares = numero1 + numero3 + numero5 + numero7 + numero9;

          //Suma total
          var suma_total = (pares + impares);

          //extraemos el primero digito
          var primer_digito_suma = String(suma_total).substring(0,1);

          //Obtenemos la decena inmediata
          var decena = (parseInt(primer_digito_suma) + 1)  * 10;

          //Obtenemos la resta de la decena inmediata - la suma_total esto nos da el digito validador
          var digito_validador = decena - suma_total;

          //Si el digito validador es = a 10 toma el valor de 0
          if(digito_validador == 10)
            var digito_validador = 0;

          //Validamos que el digito validador sea igual al de la cedula
          if(digito_validador == ultimo_digito){
            console.log('la cedula:' + cedula + ' es correcta');
          }else{
            console.log('la cedula:' + cedula + ' es incorrecta');
          }
          
        }else{
          // imprimimos en consola si la region no pertenece
          console.log('Esta cedula no pertenece a ninguna region');
        }
     }else{
        //imprimimos en consola si la cedula tiene mas o menos de 10 digitos
        console.log('Esta cedula tiene menos de 10 Digitos');
     }
    },
    verificarCedula(cedula) {
      if (typeof(cedula) == 'string' && cedula.length == 10 && /^\d+$/.test(cedula)) {
        var digitos = cedula.split('').map(Number);
        var codigo_provincia = digitos[0] * 10 + digitos[1];

        //if (codigo_provincia >= 1 && (codigo_provincia <= 24 || codigo_provincia == 30) && digitos[2] < 6) {

        if (codigo_provincia >= 1 && (codigo_provincia <= 24 || codigo_provincia == 30)) {
          var digito_verificador = digitos.pop();

          var digito_calculado = digitos.reduce(
            function (valorPrevio, valorActual, indice) {
              return valorPrevio - (valorActual * (2 - indice % 2)) % 9 - (valorActual == 9) * 9;
            }, 1000) % 10;
          return digito_calculado === digito_verificador;
        }
      }
      return false;
    },
    verificacionRuc(numero){
        var suma = 0;      
        var residuo = 0;      
        var pri = false;      
        var pub = false;            
        var nat = false;      
        var numeroProvincias = 24;                  
        var modulo = 11;
                    
        /* Verifico que el campo no contenga letras */                  
        var ok=1;
        for (let i=0; i<numero.length && ok==1 ; i++){
          var n = parseInt(numero.charAt(i));
          if (isNaN(n)) ok=0;
        }
        if (ok==0){
          //alert("No puede ingresar caracteres en el número");         
          return false;
        }
                    
        if (numero.length < 10 ){              
          //alert('El número ingresado no es válido');                  
          return false;
        }
      
        /* Los primeros dos digitos corresponden al codigo de la provincia */
        let provincia = numero.substr(0,2);      
        if (provincia < 1 || provincia > numeroProvincias){           
          //alert('El código de la provincia (dos primeros dígitos) es inválido');
          return false;       
        }

        /* Aqui almacenamos los digitos de la cedula en variables. */
        var d1  = numero.substr(0,1);         
        var d2  = numero.substr(1,1);         
        var d3  = numero.substr(2,1);         
        var d4  = numero.substr(3,1);         
        var d5  = numero.substr(4,1);         
        var d6  = numero.substr(5,1);         
        var d7  = numero.substr(6,1);         
        var d8  = numero.substr(7,1);         
        var d9  = numero.substr(8,1);         
        var d10 = numero.substr(9,1);                
          
        /* El tercer digito es: */                           
        /* 9 para sociedades privadas y extranjeros   */         
        /* 6 para sociedades publicas */         
        /* menor que 6 (0,1,2,3,4,5) para personas naturales */ 

        if (d3==7 || d3==8){           
          //alert('El tercer dígito ingresado es inválido');                     
          return false;
        }         
          
        /* Solo para personas naturales (modulo 10) */         
        if (d3 < 6){           
          nat = true;            
          var p1 = d1 * 2;  if (p1 >= 10) p1 -= 9;
          var p2 = d2 * 1;  if (p2 >= 10) p2 -= 9;
          var p3 = d3 * 2;  if (p3 >= 10) p3 -= 9;
          var p4 = d4 * 1;  if (p4 >= 10) p4 -= 9;
          var p5 = d5 * 2;  if (p5 >= 10) p5 -= 9;
          var p6 = d6 * 1;  if (p6 >= 10) p6 -= 9; 
          var p7 = d7 * 2;  if (p7 >= 10) p7 -= 9;
          var p8 = d8 * 1;  if (p8 >= 10) p8 -= 9;
          var p9 = d9 * 2;  if (p9 >= 10) p9 -= 9;             
          modulo = 10;
        }         

        /* Solo para sociedades publicas (modulo 11) */                  
        /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
        else if(d3 == 6){           
          pub = true;             
          var p1 = d1 * 3;
          var p2 = d2 * 2;
          var p3 = d3 * 7;
          var p4 = d4 * 6;
          var p5 = d5 * 5;
          var p6 = d6 * 4;
          var p7 = d7 * 3;
          var p8 = d8 * 2;            
          var p9 = 0;            
        }         
          
        /* Solo para entidades privadas (modulo 11) */         
        else if(d3 == 9) {           
          pri = true;                                   
          p1 = d1 * 4;
          p2 = d2 * 3;
          p3 = d3 * 2;
          p4 = d4 * 7;
          p5 = d5 * 6;
          p6 = d6 * 5;
          p7 = d7 * 4;
          p8 = d8 * 3;
          p9 = d9 * 2;            
        }
                  
        suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;                
        residuo = suma % modulo;                                         

        /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
        var digitoVerificador = residuo==0 ? 0: modulo - residuo;                

        /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/                         
        if (pub==true){           
          if (digitoVerificador != d9){                          
              //alert('El ruc de la empresa del sector público es incorrecto.');
              console.log('publica');            
              return false;
          }                  
          /* El ruc de las empresas del sector publico terminan con 0001*/         
          if ( numero.substr(9,4) != '0001' ){    
              console.log('publica');                
              //alert('El ruc de la empresa del sector público debe terminar con 0001');
              return false;
          }
        }         
        else if(pri == true){         
          if (digitoVerificador != d10){                          
              //alert('El ruc de la empresa del sector privado es incorrecto.');
              console.log('sector privado');
              return false;
          }         
          if ( numero.substr(10,3) != '001' ){      
            console.log('sector privado');              
              //alert('El ruc de la empresa del sector privado debe terminar con 001');
              return false;
          }
        }      

        else if(nat == true){         
          if (digitoVerificador != d10){      
              console.log('persona natural es incorrecto');                  
              //alert('El número de cédula de la persona natural es incorrecto.');
              return false;
          }         
          if (numero.length >10 && numero.substr(10,3) != '001' ){                    
              //alert('El ruc de la persona natural debe terminar con 001');
              console.log('persona natural');
              return false;
          }
        }      
        return true;   
   },         
  },
};
</script>
<style scoped>
.mixin-components-container {
  background-color: #f0f2f5;
  padding: 30px;
  min-height: calc(100vh - 84px);
}
.component-item {
  min-height: 100px;
}

</style>

<style>

</style>
