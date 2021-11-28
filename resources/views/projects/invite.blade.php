<div class="card flex flex-col mt-3 w-72 md:w-96">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4">
        Zaproś do kolaboracji nad projektem
    </h3>
    <a class="button float-right text-center" @click.prevent="$modal.show('search-user')">Zaproś</a>
    <search-user-modal :project = "{{ $project }}" ></search-user-modal>
    @include ('errors', ['bag' => 'invitations'])
</div>
