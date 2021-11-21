<div class="card flex flex-col mt-3 w-72 md:w-96 ">
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-light pl-4">
        Zaproś do kolaboracji nad projektem
    </h3>

    <form method="POST" action="{{ $project->path() . '/invitations' }}">
        @csrf

        <div class="mb-3">
            <input type="email" name="email" class="border border-grey-light rounded w-full py-2 px-3" placeholder="Email address">
        </div>

        <button type="submit" class="button">Zaproś</button>
    </form>

    @include ('errors', ['bag' => 'invitations'])
</div>
