<template>
    <!DOCTYPE html>
    <html lang="pt-br" dir="ltr">
    <head>
        <meta charset="UTF-8">
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
        <body>
        <div class="container">
            <div class="title">{{ 'Carros de ' + owner.name }}</div>
            <div class="content">
            <form action="">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Marca</span>
                        <select name="brand_id" class="details" v-model="selectBrand">
                            <option value="main" disabled> Selecione uma marca...</option>
                            <option v-for="brand in brands" :key="brand.id" :value="brand.description">{{ brand.description }}</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Modelo</span>
                        <input type="text" placeholder="Insira o modelo do veículo" name="model" value="" v-model="model" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Cor</span>
                        <input type="text" placeholder="Insira a cor do veículo" name="color" value="" v-model="color" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Placa</span>
                        <input type="text" placeholder="Insira a placa do veículo" name="plate" value="" v-model="plate" required>
                    </div>
                </div>
                <div class="button">
                <input type="button" @click="registerNewCar()" value="Cadastrar novo veículo">
                <label class="return-button"><a href="/"><p class="adjust-label">Voltar</p></a></label>
                </div>
            </form>
            </div>
        </div>

        <br >
        <div class="container-table">
            <ul class="responsive-table">
                <li class="table-header">
                    <div class="col col-3">Modelo</div>
                    <div class="col col-3">Marca</div>
                    <div class="col col-2">Cor</div>
                    <div class="col col-2" >Placa</div>
                    <div class="col col-1">Revisões</div>
                </li>
                <li v-for="vehicle in vehicles" :key="vehicle.id" class="table-row" >
                    <div class="col col-3" data-label="Modelo">{{vehicle.model}}</div>
                    <div class="col col-3" data-label="Marca">{{vehicle.description}}</div>
                    <div class="col col-2" data-label="Cor">{{vehicle.color}}</div>
                    <div class="col col-2" data-label="Placa">{{vehicle.license_plate}}</div>
                    <div class="col col-1" data-label="Revisões" ><a :href="'/revision-register/' + vehicle.id">Reviões</a></div>
                </li>
            </ul>
        </div>

        </body>
    </html>

</template>

<script>
    import "../../css/style.css";
    import "../../css/table.css";
    export default {
        mounted() {
            this.getBrands();
            this.getVehicles();
        },
        data() {
            return {
                brands: [],
                owner: {name: '...'},
                vehicles: [],
                model: '',
                color: '',
                plate: '',
                selectBrand: 'main'
            }
        },
        props: ['owner_id'],
        methods: {
            registerNewCar(){
                let options = {
                    url: "http://127.0.0.1:8000/api/vehicle/register",
                    method: 'post',
                    data: {
                        'brand': this.selectBrand,
                        'model': this.model,
                        'color': this.color,
                        'license_plate': this.plate,
                        'owner': this.owner_id
                    }
                }

                axios(options)
                .then(response => {
                    this.getVehicles()
                })
            },
            getBrands(){
                axios.get("http://127.0.0.1:8000/api/brand")
                .then(response => {
                    this.brands = response.data
                }).catch(errors => {
                    console.log(errors)
                })
            },
            getVehicles() {
                let options = {
                    method: 'get',
                    url: 'http://127.0.0.1:8000/api/vehicles/byowner/' + this.owner_id
                }
                
                axios(options)
                .then(response => {
                    // Saves owner object
                    this.owner = response.data[0]

                    // Saves vehicle list of the precious owner
                    this.vehicles = response.data[1]
                }).catch(errors => {
                    console.log(errors)
                })
            }
        }
    }
</script>
