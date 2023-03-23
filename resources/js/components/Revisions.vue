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

                <div class="column-content">
                    <!-- First part of dashboard with brand info -->
                    <div class="content">

                        <!-- Brands infos -->
                        <div class="subtitle">{{'Marcas com mais revisões '}}</div>
                        <div v-for="rBrand in brandsRev" :key="rBrand.id" class="subtitle-topic">{{'• ' + rBrand.description + ' - ' + rBrand.counted}}</div>

                    </div>

                    <!-- Second part of dashboard with people info -->
                    <div class="content">

                        <!-- People infos -->
                        <div class="subtitle">{{'Total de carros na plataforma '}}</div>
                        <div v-for="rPeople in peopleRev" :key="rPeople.id" class="subtitle-topic">{{'• ' + rPeople.name + ' - ' + rPeople.counted}}</div>
                        
                    </div>
                </div>
            </div>
            <!-- End Information Container -->
            <br >
            <!-- Start Table of vehicles -->
            <div class="container-table">
                <ul class="responsive-table">
                    <li class="table-header">
                        <div class="col col-2">Data</div>
                        <div class="col col-4">Descrição</div>
                        <div class="col col-3">Carro</div>
                        <div class="col col-3">Usuário</div>
                    </li>
                    <li v-for="revision in revisions" :key="revision.id" class="table-row" >
                        <div class="col col-2" data-label="Data">{{formatDate(revision.revision_date)}}</div>
                        <div class="col col-4" data-label="Descrição">{{revision.description}}</div>
                        <div class="col col-3" data-label="Carro">{{revision.brand + ' ' + revision.model }}</div>
                        <div class="col col-3" data-label="Usuário">{{revision.name}}</div>
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
    import dayjs from 'dayjs';

    export default {
        mounted() {
            this.getInfos();
        },
        data() {
            return {
                revisions: [],
                brandsRev: [],
                peopleRev: []
            }
        },
        methods: {
            formatDate(dateString) {
                const date = dayjs(dateString);
                    // Then specify how you want your dates to be formatted
                return date.format('HH:mm DD/MM/YYYY');
            },
            getInfos(){
                let options = {
                    method: 'get',
                    url: 'http://127.0.0.1:8000/api/revision/infos'
                }

                axios(options)
                .then(response => {
                    // Saves all revisions
                    this.revisions = response.data[0]

                    // Saves top brands count
                    this.brandsRev = response.data[1]
                    console.log(this.brandsRev)

                    // Saves top users count
                    this.peopleRev = response.data[2]
                    console.log(this.peopleRev)

                }).catch(errors => {
                    console.log(errors)
                })
            }
        }
    }
</script>
