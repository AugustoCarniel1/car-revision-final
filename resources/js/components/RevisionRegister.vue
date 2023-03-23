<template>
    <!DOCTYPE html>
    <html lang="pt-br" dir="ltr">
    <head>
        <meta charset="UTF-8">
    
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
        <body>
        <div class="dashboard">

            <!-- Table start -->
            <div class="container-table">
                <ul class="responsive-table">
                    <li class="table-header">
                        <div class="col col-7">Descrição</div>
                        <div class="col col-3">Data</div>
                    </li>
                    <li v-for="revision in revisions" :key="revision.id" class="table-row" >
                        <div class="col col-7" data-label="Descrição">{{revision.description}}</div>
                        <div class="col col-3" data-label="Data">{{formatDate(revision.revision_date)}}</div>
                    </li>
                </ul>
            </div>
            <!-- Table end -->

            <!-- Dashboard start -->
            <div class="container" style="padding-bottom: 50px;">
                <div class="title">Dashboard</div>
                <div class="content">

                    <!-- Information about the vehicle -->
                    <div class="subtitle">{{'Veículo: ' +  vehicle.brand.description + ' ' + vehicle.model + ' - ' + vehicle.color}}</div>

                    <!-- Count the number of revisions -->
                    <div class="subtitle">{{'Número de reviões: ' +  revisions.length}}</div>

                    <!-- Get the last element and format -->
                    <div class="subtitle">{{'Próxima Revisão: ' +  nextDate}}</div>
                    
                    <!-- Average between revisions -->
                    <div class="subtitle">{{'Média entre Revisões: ' +  average}}</div>
                </div>
                <br >
                <div class="title">{{ 'Nova Revisão ' }}</div>
                <div class="content">
                    <form action="">
                        <div class="user-details">
                            <div class="input-box">
                                <span class="details">Descrição</span>
                                <input type="text" placeholder="Descrição da revisão" name="model" value="" v-model="description" required>
                            </div>
                        </div>
                        <div class="button dash-button">
                        <input class="dash" type="button" @click="registerRevision()" value="Cadastrar revisão">
                        <label class="dash"><a :href="'/car-register/' + this.vehicle_id"><p class="adjust-label">Voltar</p></a></label>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Dashboard end -->

        </div>

        </body>
    </html>

</template>

<script>
    import "../../css/style.css";
    import "../../css/table.css";
    import dayjs from 'dayjs';

    export default {
        mounted() {
            this.getRevision();
        },
        data() {
            return {
                revisions: [],
                description: '',
                vehicle: {},
                average: '',
                nextDate: '' 
            }
        },
        props: ['vehicle_id'],
        methods: {
            formatDate(dateString) {
                const date = dayjs(dateString);
                    // Then specify how you want your dates to be formatted
                return date.format('HH:mm DD/MM/YYYY');
            },
            registerRevision(){
                let options = {
                    url: "http://127.0.0.1:8000/api/revision/register",
                    method: 'post',
                    data: {
                        'description': this.description,
                        'vehicle': this.vehicle_id
                    }
                }

                axios(options)
                .then(response => {
                    this.getRevision()
                }).then(this.description = '')
            },
            getRevision() {
                let options = {
                    method: 'get',
                    url: 'http://127.0.0.1:8000/api/revision/byvehicle/' + this.vehicle_id
                }
                
                axios(options)
                .then(response => {
                    // Saves vehicle object
                    this.vehicle = response.data[0]
                    this.vehicle['brand'] = response.data[1]

                    // Saves revisions list of the precious vehicle
                    this.revisions = response.data[2]

                    // Saves the next revision date and the average between
                    this.nextDate = response.data[3] ? this.formatDate(response.data[3]['date']) : 'Revisões insuficientes para calculo'
                    this.average = response.data[4] ? response.data[4] : 'Revisões insuficientes para média'
                }).catch(errors => {
                    console.log(errors)
                })
            }
        }
    }
</script>
