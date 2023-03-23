<template>
    <!DOCTYPE html>
    <html lang="pt-br" dir="ltr">
    <head>
        <meta charset="UTF-8">
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
        <body>
            <!-- Start Information Container -->
            <div class="container">

                <!-- Menu -->
                <div class="content" style="margin-bottom: 50px;">
                    <div class="button dash-button">
                        <label class="dash"><a :href="'/'"><p class="adjust-label">Voltar</p></a></label>
                    </div>
                </div>
                
                <div class="title">Dashboard</div>
                <div class="content">

                    <!-- Information of all brands -->
                    <div class="subtitle">{{'Total de marcas disponíveis na plataforma: ' + brands.length}}</div>

                    <!-- Count the number of vehicles by gender -->
                    <div class="subtitle">{{'Total de carros na plataforma: ' + vehicles.length}}</div>
                    <div class="subtitle-topic">{{'• Homens: ' + (vehicles.length - femaleCount)}}</div>
                    <div class="subtitle-topic">{{'• Mulheres: ' + femaleCount}}</div>
                </div>
            </div>
            <!-- End Information Container -->
            <br >

            <!-- Star Filter -->
            <div class="div-filter">
                <select class="select-filter" v-model="filterSelect" @change="getVehicles()">
                    <option value="none">Sem filtro</option>
                    <option value="person">Nome de Pessoas</option>
                    <option value="car">Numero de Carros e Marca</option>
                    <option value="brand">Marca e Genero</option>
                </select>

                <select class="select-filter" v-if="filterSelect == 'brand'" v-model="genderSelect" @change="getVehicles()">
                    <option value="all">Todos</option>
                    <option value="male">Homens</option>
                    <option value="female">Mulheres</option>
                </select>
            </div>
            <!-- End Filter -->

            <!-- Start Table of vehicles -->
            <div class="container-table">
                <ul class="responsive-table">
                    <li class="table-header">
                        <div class="col col-2">Modelo</div>
                        <div class="col col-2">Marca</div>
                        <div class="col col-2">Cor</div>
                        <div class="col col-2">Placa</div>
                        <div class="col col-4">Dono</div>
                    </li>
                    <li v-for="vehicle in vehicles" :key="vehicle.id" class="table-row" >
                        <div class="col col-2" data-label="Modelo">{{vehicle.model}}</div>
                        <div class="col col-2" data-label="Marca">{{vehicle.description}}</div>
                        <div class="col col-2" data-label="Cor">{{vehicle.color}}</div>
                        <div class="col col-2" data-label="Placa">{{vehicle.license_plate}}</div>
                        <div class="col col-4" data-label="Dono">{{vehicle.name}}</div>
                    </li>
                </ul>
            </div>
            <!-- End Table of vehicles -->
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
            this.getInfos();
        },
        data() {
            return {
                brands: [],
                vehicles: [],
                femaleCount: 0,
                filterSelect: 'none',
                genderSelect: 'all'
            }
        },
        methods: {
            getBrands(){
                axios.get("http://127.0.0.1:8000/api/brand")
                .then(response => {
                    this.brands = response.data
                }).catch(errors => {
                    console.log(errors)
                })
            },
            getInfos(){
                let options = {
                    method: 'get',
                    url: 'http://127.0.0.1:8000/api/vehicle/infos'
                }

                axios(options)
                .then(response => {
                    // Saves Woman Vehicles
                    this.femaleCount = response.data[0]['count']

                }).catch(errors => {
                    console.log(errors)
                })
            },
            getVehicles() {
                let options = {
                    method: 'get',
                    url: 'http://127.0.0.1:8000/api/vehicle/' + this.filterSelect + '/' + this.genderSelect
                }
                
                axios(options)
                .then(response => {
                    // Saves vehicle list of the precious owner
                    this.vehicles = response.data

                }).catch(errors => {
                    console.log(errors)
                })
            }
        }
    }
</script>
