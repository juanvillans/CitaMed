<script>
    import Table from "../../components/Table.svelte";
    import Modal from "../../components/Modal.svelte";
    import Input from "../../components/Input.svelte";
    import axios from "axios";
    import debounce from "lodash/debounce";

    import Alert from "../../components/Alert.svelte";
    import { displayAlert } from "../../stores/alertStore";
    import { useForm, router, page } from "@inertiajs/svelte";
    export let data = [];
    $: console.log(data);

    const emptyDataForm = {
        ci: "30847627",
        name: "Juan",
        last_name: "Donquis",
        email: "juandonquis07@gmail.com",
        phone_number: "04125800610",
        role: "doctor",
        specialties: [],
    };

    let formCreate = useForm({
        ...emptyDataForm,
    });

    let formEdit = useForm({
        ...emptyDataForm,
    });

    let showModal = false;
    $: showModalFormEdit = false;
    let selectedRow = { status: false, id: 0 };

    document.addEventListener("keydown", ({ key }) => {
        if (key === "Escape") {
            selectedRow = { status: false, id: 0 };
        }
    });

    function handleSubmit(event) {
        event.preventDefault();
        $formCreate.clearErrors();
        $formCreate.post("/admin/usuarios", {
            onError: (errors) => {
                if (errors.data) {
                    displayAlert({ type: "error", message: errors.data });
                }
            },
            onSuccess: (mensaje) => {
                $formCreate.reset();
                displayAlert({
                    type: "success",
                    message: "Ok todo salió bien",
                });
                showModal = false;
            },
        });
    }

    function handleEdit(event) {
        event.preventDefault();
        $formEdit.clearErrors();
        $formEdit.put(`/admin/usuarios/${$formEdit.student_id}`, {
            onError: (errors) => {
                if (errors.data) {
                    displayAlert({ type: "error", message: errors.data });
                }
            },
            onSuccess: (mensaje) => {
                $formEdit.reset();
                displayAlert({
                    type: "success",
                    message: "Ok todo salió bien",
                });
                showModalFormEdit = false;
                selectedRow = { status: false, id: 0, row: {} };
            },
        });
    }

    function handleDelete(id) {
        $formCreate.delete(`/admin/usuarios/${id}`, {
            onBefore: () => confirm(`¿Está seguro de eliminar a este usuario?`),
        });
    }

    function fillFormToEdit() {
        submitStatus = "Editar";
        $formCreate.reset();
        showModal = true;
    }

    let submitStatus = "Crear";
    let selectSpecialityModal = false;
    let filteredSpecialities = [];

    $: if ($formCreate.specialties) {
        filteredSpecialities = data.specialties.filter(
            (obj) =>
                !$formCreate.specialties.some((speci) => speci.id == obj.id),
        );
    }
</script>

<svelte:head>
    <title>Usuarios</title>
</svelte:head>

<Alert />
<Modal
    showModal={selectSpecialityModal}
    onClose={() => {
        selectSpecialityModal = false;
    }}
>
    <ul>
        {#each filteredSpecialities as speciality (speciality.id)}
            <li>
                <button
                    class="rounded-full mb-1 px-3 py-1 hover:bg-color3 bg-color4"
                    on:click={() => {
                        $formCreate.specialties = [
                            ...$formCreate.specialties,
                            speciality,
                        ];
                    }}>{speciality.name}</button
                >
            </li>
        {/each}
    </ul>
</Modal>
<Modal bind:showModal modalClasses={"max-w-[500px]"}>
    <h2 slot="header" class="text-sm text-center">INSCRIBIR NUEVO USUARIO</h2>

    <form
        id="a-form"
        on:submit={handleSubmit}
        action=""
        class="w-full px-5 mt-4 grid md:grid-cols-2 gap-x-5 p-6 pt-2 rounded-md"
    >
        <Input
            type="text"
            required={true}
            label={"Nombres"}
            bind:value={$formCreate.name}
            error={$formCreate.errors?.name}
        />
        <Input
            type="text"
            required={true}
            label={"Apellidos"}
            bind:value={$formCreate.last_name}
            error={$formCreate.errors?.last_name}
        />
        <Input
            type="email"
            label="correo"
            bind:value={$formCreate.email}
            error={$formCreate.errors?.email}
        />
        <Input
            type="number"
            required={true}
            label={"Cédula"}
            bind:value={$formCreate.ci}
            error={$formCreate.errors?.ci}
        />
        <Input
            type="tel"
            label={"Teléfono"}
            bind:value={$formCreate.phone_number}
            error={$formCreate.errors?.phone_number}
        />
        <Input
            type="select"
            required={true}
            label={"Tipo de Usuario"}
            bind:value={$formCreate.role}
            error={$formCreate.errors?.role}
        >
            <option value="doctor">Doctor</option>
            <option value="admin">Admin</option>
        </Input>
        <div class="mt-4 col-span-2">
            <div class="flex justify-between items-center">
                <span>Especialidades:</span>
                <button
                    type="button"
                    on:click={() => {
                        selectSpecialityModal = true;
                    }}
                    for="date1"
                    class="ml-2 inline-block cursor-pointer text-color2 font-bold py-2 px-3 rounded bg-color2 bg-opacity-10 hover:bg-opacity-20 mt-3"
                    ><iconify-icon class="mr-1 relative top-0.5" icon="gala:add"
                    ></iconify-icon> Añadir Especialidad</button
                >
            </div>
            <ul class="flex flex-wrap gap-x-2">
                {#each $formCreate.specialties as speciality (speciality.id)}
                    <li>
                        <span
                            class="rounded-full text-black inline-block px-3 py-2 mt-2 bg-color4"
                        >
                            {speciality.name}
                            <button
                                on:click={(e) => {
                                    $formCreate.specialties =
                                        $formCreate.specialties.filter(
                                            (v, i) => v.id != speciality.id,
                                        );
                                }}
                                type="button"
                                class="cursor-pointer hover:font-bold ml-1 hover:text-white aspect-square w-5 hover:bg-color1 rounded-full"
                                title="Quitar especialidad"
                            >
                                <iconify-icon
                                    class="relative top-1"
                                    icon="ic:outline-close"
                                ></iconify-icon>
                            </button>
                        </span>
                    </li>
                {/each}
            </ul>
        </div>
    </form>
    <input
        form="a-form"
        slot="btn_footer"
        type="submit"
        value={$formCreate.processing ? "Cargando..." : submitStatus}
        class="hover:bg-color3 hover:text-white duration-200 mt-auto w-full bg-color4 text-black font-bold py-3 rounded-md cursor-pointer"
    />
</Modal>

<Modal bind:showModal={showModalFormEdit}>
    <h2 slot="header" class="text-sm text-center">EDITAR ACTIVIDAD</h2>

    <form
        id="a-form"
        on:submit={handleEdit}
        action=""
        class="w-[600px] px-5 bg-gray-100 mt-4 grid grid-cols-2 gap-x-5 w-full border p-6 pt-2 rounded-md"
    >
        <Input
            type="text"
            required={true}
            label={"Nombres"}
            bind:value={$formEdit.name}
            error={$formEdit.errors?.name}
        />
        <Input
            type="text"
            required={true}
            label={"Apellidos"}
            bind:value={$formEdit.last_name}
            error={$formEdit.errors?.last_name}
        />
        <Input
            type="email"
            label="correo"
            bind:value={$formEdit.email}
            error={$formEdit.errors?.email}
        />
        <Input
            type="number"
            required={true}
            label={"Cédula"}
            bind:value={$formEdit.ci}
            error={$formEdit.errors?.ci}
        />
        <Input
            type="tel"
            label={"Teléfono"}
            bind:value={$formEdit.phone_number}
            error={$formEdit.errors?.phone_number}
        />
        <Input
            type="select"
            required={true}
            label={"Especialidad"}
            bind:value={$formEdit.speciality_id}
            error={$formEdit.errors?.speciality_id}
        >
            {#each data.specialties as speciality}
                <option value={speciality.id}>{speciality.name}</option>
            {/each}
        </Input>
    </form>
    <input
        form="a-form"
        slot="btn_footer"
        type="submit"
        value={$formEdit.processing ? "Cargando..." : "Editar"}
        class="hover:bg-color3 hover:text-white duration-200 mt-auto w-full bg-color2 text-black font-bold py-3 rounded-md cursor-pointer"
    />
</Modal>

<div class="flex justify-between items-center">
    <button
        class="btn_create inline-block"
        disabled={$formCreate.processing}
        on:click={(e) => {
            if (submitStatus == "Editar") {
                selectedRow = {
                    status: false,
                    id: 0,
                    title: "",
                };
                $formCreate.defaults();
                $formCreate.reset();
                console.log("ss");
            }
            e.preventDefault();

            showModal = true;
            submitStatus = "Crear";
        }}>Crear nuevo usario</button
    >
</div>
<Table
    {selectedRow}
    on:fillFormToEdit={fillFormToEdit}
    on:clickDeleteIcon={() => {
        handleDelete(selectedRow.id);
    }}
    pagination={false}
>
    <div slot="filterBox"></div>
    <thead slot="thead" class="sticky top-0 z-50">
        <tr>
            <th>N°</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>C.I</th>
            <th>Correo</th>
            <th>Tel</th>
            <th>Especialidad</th>
        </tr>
    </thead>

    <tbody slot="tbody">
        {#each data.users.data as row, i}
            <tr
                on:click={(e) => {
                    // let newSelectedRowStatus = !selectedRow.status;
                    if (row.id != selectedRow.id) {
                        selectedRow = {
                            status: true,
                            id: row.id,
                            title: row.title,
                        };
                        $formCreate.defaults({
                            ...row,
                        });
                    } else {
                        selectedRow = {
                            status: false,
                            id: 0,
                            title: "",
                        };
                        $formCreate.defaults({
                            ...emptyDataForm,
                        });
                    }
                }}
                class={`cursor-pointer  ${selectedRow.id == row.id ? "bg-color2 hover:bg-opacity-10 bg-opacity-10 brightness-110" : " hover:bg-gray-500 hover:bg-opacity-5"}`}
            >
                <td>{i + 1}</td>
                <td>{row.name}</td>
                <td>{row.last_name}</td>
                <td>{row.ci}</td>
                <td>{row.email}</td>
                <!-- <td>{row.sex}</td> -->
                <td>{row.phone_number}</td>
                <!-- <td>{row.rep_name} {row.rep_last_name}</td> -->
                <td>{row.specialties}</td>
            </tr>
        {/each}
    </tbody>
</Table>
