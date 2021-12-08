<template>
    <modal name="project-members" classes="p-10 bg-card rounded-lg" height="auto">
        <div>
            <h1 class="text-3xl">Uczestnicy projektu:</h1>
            <hr class="my-4">

            <div v-if="project.members.length > 0" class="overflow-auto h-96">
                <div  v-for="user in project.members" class="my-3 hover:bg-gray-200" >
                        <div class="flex justify-between items-center ml-3 p-2">
                            <div class="flex items-center">
                                <img :src=user.avatar class="rounded-full w-12 h-12 mr-2 border-2 border-blue-300">
                                <span>{{user.name}}</span>
                            </div>
                            <label for="user" class="button">
                                Usuń
                            <input
                                :key="user.id"
                                type="radio"
                                class="form-radio"
                                id="user"
                                name="user"
                                :value=user.email
                                v-model="form.email"
                                v-on:change="detachUser"
                            />
                            </label>
                        </div>
                </div>
            </div>
            <div v-else>
                <span>Jesteś jedynym uczestnikiem projektu</span>
            </div>
        </div>
    </modal>
</template>

<script>
import BirdboardForm from './BirdboardForm';

export default {
    props: ['project'],

    data() {
        return {
            form: new BirdboardForm({
                email: '',
            }),
        };
    },
    methods: {
        detachUser: function (event) {
            this.submit();
        },

         async submit() {
            this.form.submit( this.project.id + '/invitations/delete');
             location.reload();
             alert("Użytkownik został usunięty");
        },

    }
}
</script>

<style scoped>

</style>
