<template>
    <modal name="search-user" classes="p-10 bg-card rounded-lg" height="auto">
        <div>
            <form @submit.prevent="submit">
                <footer class="flex justify-end mb-5">
                    <button type="button" class="button is-outlined mr-4" @click="$modal.hide('search-user')">Anuluj</button>
                    <button type="submit" class="button float-right">Zaproś</button>
                </footer>

                <div class="relative text-gray-700 mb-5">
                    <input v-model="keyword" type="email" name="email" class="w-full h-10 pl-8 pr-3 text-base placeholder-gray-600 border rounded-lg focus:shadow-outline" placeholder="Adres Email"/>

                    <div class="absolute inset-y-0 left-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                    </div>

                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                    </div>
                </div>

                <div class="overflow-auto h-96">
                    <div v-for="user in filteredUsers">
                        <label class="flex p-4 justify-between items-center hover:bg-gray-100">
                            <div class="flex items-center">
                                <img :src=user.avatar class="rounded-full w-12 h-12 mr-2 border-2 border-blue-300">
                                <span>{{user.name}} | {{user.email}}</span>
                            </div>
                            <input
                                :key="user.id"
                                type="radio"
                                class="form-radio"
                                name="radio"
                                v-model="form.email"
                                :value=user.email
                                v-on:click="addEmail"
                            />
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </modal>
</template>

<script>
import BirdboardForm from "./BirdboardForm";

export default {
    props: ['project'],
    data() {
        return {
            keyword: null,
            users: [],
            form: new BirdboardForm({
                email: '',
            }),
        };
    },
    watch: {
        keyword(after, before) {
            this.getResults();
        }
    },
    methods: {
        getResults(item) {
            axios.get('/users', { params: { keyword: this.keyword ? this.keyword : item  } })
                .then(res => this.users = res.data)
                .catch(error => {});
        },
        async submit() {
            if(this.userExistsinMembers(this.keyword)){
                alert("Użytkownik został już dodany do tego projektu!");
            } else if(!this.userExistsinUsers(this.keyword)){
                alert("Użytkownik o podanym adresie email nie istnieje!");
            } else {
                this.form.submit( this.project.id + '/invitations');
                this.keyword = '';
                location.reload();
                alert("Użytkownik został dodany");
            }
        },

        addEmail(event) {
            this.keyword = event.target.value;
        },

        userExistsinMembers(email) {
            return this.project.members.some(function(el) {
                return el.email === email;
            });
        },

        userExistsinUsers(email) {
            return this.users.some(function(el) {
                return el.email === email;
            });
        }
    },
    mounted: function() {
        this.getResults('a')
    },

    computed: {
        filteredUsers(){
            const emailsMembers = this.project.members.map(user => {
                return {
                    'email': user.email,
                    'avatar':user.avatar,
                    'name': user.name
                }
            })

            const usersEmails = this.users.map(user => {
                return {
                    'email': user.email,
                    'avatar':user.avatar,
                    'name': user.name
                }
            })

            return  usersEmails.filter(function(objFromA) {
                return !emailsMembers.find(function(objFromB) {
                    return objFromA.email === objFromB.email
                })
            })
        }
    }
}
</script>
