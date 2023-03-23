

<template>
    <!DOCTYPE html>
    <html lang="pt-br" dir="ltr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
        </head>
        <body>
            <div class="container">

                <!-- Menu -->
                <div class="content" style="margin-bottom: 50px; margin-left: 30px;">
                    <div class="button dash-button">
                        <label class="dash"><a :href="'/cars'"><p class="adjust-label">Carros</p></a></label>
                        <label class="dash"><a :href="'/revisions'"><p class="adjust-label">Revisões</p></a></label>
                    </div>
                </div>

                <!-- Register new user -->
                <div class="title">Cadastrar Novo Usuário</div>
                <div class="content">
                    <form action="">
                        <input type="hidden" name="_token" :value="token">
                        <div class="user-details">
                            <div class="input-box">
                                <span class="details">Nome Completo</span>
                                <input type="text" placeholder="Insira o nome completo" name="name" value="" v-model="name" required>
                                <div v-if="'name' in errors" class="div-error">{{ errors['name'] }}</div>
                            </div>
                            <div class="input-box">
                                <span class="details">CPF</span>
                                <input type="text" placeholder="Insira o CPF" name="cpf" value="" v-model="cpf" required>
                                <div v-if="'cpf' in errors" class="div-error">{{ errors['cpf'] }}</div>
                            </div>
                            <div class="input-box">
                                <span class="details">Email</span>
                                <input type="text" placeholder="Insira o email" name="email" value="" v-model="email" required>
                                <div v-if="'email' in errors" class="div-error">{{ errors['email'] }}</div>
                            </div>
                            <div class="input-box">
                                <span class="details">Número de Telefone</span>
                                <input type="text" placeholder="Insira o telefone" name="phone" value="" v-model="phone" required>
                                <div v-if="'phone' in errors" class="div-error">{{ errors['phone'] }}</div>
                            </div>
                            <div class="input-box">
                                <span class="details">Data de Nascimento</span>
                                <input type="date" placeholder="Insira a Data de Nascimento" name="birth" value="" v-model="birth" required>
                                <div v-if="'birth' in errors" class="div-error">{{ errors['birth'] }}</div>
                            </div>
                        
                            <div class="input-box">
                                <input type="radio" name="Male" id="dot-1" v-model="genderC" value="Male">
                                <input type="radio" name="Female" id="dot-2" v-model="genderC" value="Female">
                                <span class="details">Gender</span>
                                <div class="category">
                                    <label for="dot-1">
                                        <span class="dot one"></span>
                                        <span class="gender">Male</span>
                                    </label>
                                    <label for="dot-2">
                                        <span class="dot two"></span>
                                        <span class="gender">Female</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="button">
                        <input type="button" @click="register()" value="Cadastrar">
                        </div>
                    </form>
                </div>
            </div>

            <!-- User table -->
            <div class="div-filter">
                <select class="select-filter" v-model="genderSelect" @change="getOwners()">
                    <option value="all">Todos</option>
                    <option value="Male">Homens</option>
                    <option value="Female">Mulheres</option>
                </select>
            </div>
            <br >
            <div class="container-table">
                <ul class="responsive-table">
                    <li class="table-header">
                        <div class="col col-4">Nome Completo</div>
                        <div class="col col-2">CPF</div>
                        <div class="col col-2">Telefone</div>
                        <div class="col col-2">Gênero</div>
                        <div class="col col-2">Carros</div>
                    </li>
                    <li v-for="owner in owners" :key="owner.id" class="table-row" >
                        <div class="col col-4" data-label="Nome Completo">{{owner.name}}</div>
                        <div class="col col-2" data-label="CPF">{{owner.cpf}}</div>
                        <div class="col col-2" data-label="Telefone">{{owner.phone}}</div>
                        <div class="col col-2" data-label="Gênero">{{owner.gender == 'Male' ? 'Masculino' : 'Feminino'}}</div>
                        <div class="col col-2" data-label="Redirect" ><a :href="'/car-register/' + owner.id">Info</a></div>
                    </li>
                </ul>
            </div>
        </body>
    </html>

</template>

<script>
    import "../../css/style.css";
    import "../../css/table.css";

    import {cpfValidator} from "../../helpers/cpfValidator.js"

    export default {
        data() {
            return {
                name: "",
                cpf: "",
                email: "",
                phone: "",
                genderC: "Male",
                birth: "",
                baseUrl: "http://127.0.0.1:8000/",
                redirectUrl: "",
                owners: [],
                genderSelect: 'all',

                errors: []
            }
        },
        props: [
            'token', 
        ],
        mounted() {
            this.getOwners()
        },
        methods: {
            getOwners(){

                axios.get(this.baseUrl + "api/owner/bygender/" + this.genderSelect)
                .then(response => {
                    this.owners = response.data
                }).catch(errors => {
                    console.log(errors)
                })
            },
            register() {

                // if(!cpfValidator(this.cpf)){
                //     this.cpfError = true
                //     return
                // }

                let options = {
                    url: this.baseUrl + "api/owner",
                    method: 'post',
                    data: new URLSearchParams({
                        'name': this.name,
                        'cpf': this.cpf,
                        'email': this.email,
                        'phone': this.phone,
                        'gender': this.genderC,
                        'birth': this.birth,
                    })
                }

                axios(options)
                .then(response => {
                    this.getOwners()
                }).catch(errors => {
                    this.errors = errors.response.data.errors
                })
            }
        }
        
    }
</script>
