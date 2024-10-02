<script>
    import { inertia } from "@inertiajs/svelte";
    import Modal from "../../components/Modal.svelte";
    export let data = {};
    console.log(data)
    let showModal = false
</script>

<Modal {showModal}>

    <h2 slot="header">Citas de ...</h2>

    <div>
        <h3>Title of the appointment</h3>
        <div>
            <iconify-icon icon="fa6-solid:user-doctor"></iconify-icon>
            <p>Doctor Name</p>
        </div>

        <div class="description">
            
        </div>

    </div>
</Modal>
<a href="/admin/agenda/cita" use:inertia class="btn_create inline-block"
    >Crear nuevo usuario</a
>
<main>
    <div class="specialties">
        <div class="p-5 bg-color3">
            <h2>Titulo</h2>

        </div>

    </div>
</main>

<style>
    main .specialties {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(15rem, 1fr));
    }
</style>