<template>
    <modal name="project-members" classes="p-10 bg-card rounded-lg" height="auto">
        <div>
            <h1 class="text-3xl">Uczestnicy projektu:</h1>
            <hr class="my-4">

            <div v-if="members.length > 0">
                <div  v-for="user in members" class="my-3 hover:bg-gray-200" >
                    <label>
                        <div class="flex justify-between items-center ml-3 p-2">
                            <div class="flex items-center">
                                <img :src=user.avatar class="rounded-full w-12 h-12 mr-2 border-2 border-blue-300">
                                <span>{{user.name}}</span>
                            </div>
                            <input
                                :key="user.id"
                                type="radio"
                                class="form-radio"
                                name="radio"
                            />
                        </div>
                    </label>
                </div>
            </div>
            <div v-else>
                <span>Jesteś jedynym uczestnikiem projektu</span>
            </div>
        </div>
    </modal>
</template>

<script>
export default {
    props: ['members'],
}
</script>

<style scoped>

</style>
