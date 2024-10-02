<script>
    import { inertia } from "@inertiajs/svelte";
    export let data = {};
    console.log(data)
</script>

<a href="/admin/agenda/cita" use:inertia class="btn_create inline-block"
    >Crear nuevo usuario</a
>
<main>

</main>

<style>
    main {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(15rem, 1fr));
    }
</style>