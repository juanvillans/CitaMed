<script>
    import { useForm } from "@inertiajs/svelte";
    import clickOutside from "../../components/ClickOutside";
    import { inertia, router } from "@inertiajs/svelte";
    import ColorsPayMethods from "../../components/ColorsPayMethods";
    import Input from "../../components/Input.svelte";
    import Modal from "../../components/Modal.svelte";

    import Alert from "../../components/Alert.svelte";
    import { displayAlert } from "../../stores/alertStore";
    export let data;
    let acordion = { franja: false, ajustesCitasReservadas: false };
    console.log({ data });
    let showModal = false;

    let form = useForm({
        title: "",
        allow_max_reservation_time_before_appointment: true,
        allow_min_reservation_time_before_appointment: true,
        allow_max_appointment_per_day: false,
        allow_time_between_appointment: false,
        duration_per_appointment: "",
        prev_value_duration_per_appointment: "",
        duration_per_appointment_type: "",
        max_reservation_time_before_appointment: 60,
        min_reservation_time_before_appointment: 40,
        time_between_appointment_type: "minutes",
        time_between_appointment: 30,
        max_appointment_per_day: 4,
        availability: {
            mon: [{ start: "7:00am", end: "4pm" }],
            tue: [
                { start: "8am", end: "12pm" },
                { start: "2pm", end: "6pm" },
            ],
            wed: [{ start: "8am", end: "4pm" }],
            thu: [{ start: "8am", end: "4pm" }],
            fri: [{ start: "8am", end: "4pm" }],
            sat: [],
            sun: [],
        },
        time_available_type: 1,
    });
    $: {
        console.log($form);
        
    }
    const customTimePerAppointment = {
        time: "3",
        type: "horas",
    };
    const translateDays = {
        mon: "Lun",
        tue: "Mar",
        wed: "Mié",
        thu: "Jue",
        fri: "Vie",
        sat: "Sáb",
        sun: "Dom",
    };
    let showPaymentOptions = false;
    function handleCloseCustomTime() {
        console.log($form.prev_value_duration_per_appointment);
        $form.duration_per_appointment =
            $form.prev_value_duration_per_appointment;
    }
    let durationOptions = [
        { value: "15", label: "15 minutos" },
        { value: "30", label: "30 minutos" },
        { value: "45", label: "45 minutos" },
        { value: "60", label: "1 hora" },
        { value: "90", label: "1,5 horas" },
        { value: "120", label: "2 horas" },
        { value: "999999", label: "personalizar..." },
    ];
</script>

<section>
    <Modal
        bind:showModal
        onClose={() => {
            handleCloseCustomTime();

            // $form.duration_per_appointment=  $form.prev_value_duration_per_appointmen
        }}
    >
        <p slot="header" class="font-bold text-lg text-gray-500">
            Duración personalizada
        </p>
        <div class="flex gap-3">
            <Input
                type="number"
                classes={"mt-0 border-none w-24"}
                inputClasses={"bg-gray-200 p-3 border-none  appearance-none"}
                bind:value={customTimePerAppointment.time}
            />

            <Input
                type="select"
                classes={"mt-0 w-36  border-none"}
                inputClasses={"p-3  bg-gray-200 "}
                bind:value={customTimePerAppointment.type}
            >
                <option value="minutos">minutos</option>
                <option value="horas">horas</option>
            </Input>
        </div>
        <button
            on:click={() => {
                console.log(customTimePerAppointment.type);
                let valueFixed =
                    customTimePerAppointment.type == "horas"
                        ? customTimePerAppointment.time * 60
                        : customTimePerAppointment.time;
                if (!durationOptions.some((obj) => obj.value == valueFixed)) {
                    let copyDurations = [...durationOptions];
                    (copyDurations[7] = {
                        value: valueFixed,

                        label: `${customTimePerAppointment.time} ${customTimePerAppointment.type} `,
                    }),
                        (durationOptions = copyDurations);
                }
                // if (customTimePerAppointment.)

                ($form.prev_value_duration_per_appointment = valueFixed),
                    ($form.duration_per_appointment = valueFixed),
                    console.log(durationOptions, $form);
                showModal = false;
            }}
            slot="btn_footer"
            type="button"
            class="text-color2 font-bold hover:bg-color2 p-2 hover:font-extrabold px-4 rounded-xl hover:bg-opacity-10"
            >Hecho</button
        >
    </Modal>
    <form
        class="max-w-[410px] bg-gray-100 p-3 rounded pt-5"
        action=""
        on:submit={(e) => {
            e.preventDefault();
        }}
    >
        <fieldset class="border-b border-gray-300 items-center pl-8 pb-4">
            <h2>CONFIGURAR CITAS DISPONIBLES</h2>

            <Input
                type="text"
                required={true}
                label={"Titulo"}
                labelClasses={"font-bold"}
                inputClasses={"text-2xl  p-1 px-3"}
                bind:value={$form.title}
                error={$form.errors?.title}
            />
        </fieldset>

        <fieldset class="border-b border-gray-300 flex gap-4 pb-4">
            <iconify-icon icon="lets-icons:time-atack" class="mt-4"
            ></iconify-icon>
            <Input
                type="select"
                required={true}
                labelClasses={"font-bold"}
                label={"Duración de cada cita"}
                classes={"mt-3 w-auto"}
                on:change={(e) => {
                    if (e.target.value == "999999") {
                        $form.prev_value_duration_per_appointment =
                            $form.duration_per_appointment;
                        showModal = true;
                        $form.duration_per_appointment = "";
                    }
                }}
                bind:value={$form.duration_per_appointment}
                error={$form.errors?.duration_per_appointment}
            >
                {#each durationOptions.slice().sort((a, b) => {
                    return parseInt(a.value) - parseInt(b.value);
                }) as { value, label }}
                    <option {value}>{label}</option>
                {/each}
            </Input>
        </fieldset>

        <fieldset class="mt-6 border-b border-gray-300 pb-5 flex gap-4">
            <span>
                <iconify-icon icon="icon-park-outline:time"></iconify-icon>
            </span>
            <section>
                <legend class="font-bold">Disponibilidad general</legend>
                <small>Indica qué disponibilidad sueles tener para citas</small>
                <ul class=" flex flex-col space-y-2 mt-4 gap-y-1 ">
                    <!-- svelte-ignore empty-block -->
                    {#each Object.entries($form.availability) as [day, shifts]}
                        <li class="flex gap-4 justify-between">
                            <span class="w-9">{translateDays[day]}</span>
                            {#if shifts.length >= 1}
                                <div class="gap-2 flex flex-col">
                                    {#each shifts as shift, indx}
                                        <div class="flex gap-3">
                                            <span
                                                class="flex w-48 items-center justify-between bg-gray-200"
                                            >
                                                <Input
                                                    type="select"
                                                    classes={"mt-0 border-none"}
                                                    inputClasses={"bg-gray-200 p-3 border-none appearance-none"}
                                                    bind:value={$form
                                                        .availability[day][indx]
                                                        .start}
                                                    error={$form.errors
                                                        ?.start_schedulte}
                                                >
                                                    <option value="7:00am"
                                                        >7:00am</option
                                                    >
                                                    <option value="8:00am"
                                                        >8:00am</option
                                                    >
                                                </Input>
                                                <span
                                                    class="p-1 px-2 font-bold"
                                                >
                                                    -
                                                </span>
                                                <Input
                                                    type="select"
                                                    classes={"mt-0"}
                                                    inputClasses={"bg-gray-200 p-3 border-none appearance-none"}
                                                    bind:value={$form
                                                        .availability[day][indx]
                                                        .end}
                                                    error={$form.errors
                                                        ?.start_schedulte}
                                                >
                                                    <option value="7:00am"
                                                        >7:00am</option
                                                    >
                                                    <option value="8:00am"
                                                        >8:00am</option
                                                    >
                                                </Input>
                                            </span>
                                            <span
                                                class="grid grid-cols-3 items-center gap-3 text-xl flex-auto"
                                            >
                                                <button
                                                    on:click={(e) => {
                                                        $form.availability[
                                                            day
                                                        ] = [
                                                            ...$form.availability[
                                                                day
                                                            ].filter(
                                                                (v, i) =>
                                                                    i != indx,
                                                            ),
                                                        ];
                                                    }}
                                                    type="button"
                                                    class="cursor-pointer hover:font-bold hover:bg-gray-200 rounded-full"
                                                    title="No disponible"
                                                >
                                                    <iconify-icon
                                                        icon="mdi:remove"
                                                    ></iconify-icon>
                                                </button>
                                                {#if indx == 0}
                                                    <button
                                                        on:click={(e) => {
                                                            $form.availability[
                                                                day
                                                            ] = [
                                                                ...$form
                                                                    .availability[
                                                                    day
                                                                ],
                                                                {
                                                                    start: "7:00am",
                                                                    end: "8:00am",
                                                                },
                                                            ];
                                                        }}
                                                        type="button"
                                                        class="cursor-pointer hover:font-bold hover:bg-gray-200 rounded-full"
                                                        title="Añadir otro turno a este día"
                                                    >
                                                        <iconify-icon
                                                            icon="gala:add"
                                                        ></iconify-icon>
                                                    </button>
                                                    <button
                                                        on:click={(e) => {
                                                            let copyDay = [
                                                                ...$form
                                                                    .availability[
                                                                    day
                                                                ],
                                                            ]; // Shallow copy for array of objects
                                                            Object.keys(
                                                                $form.availability,
                                                            ).forEach(
                                                                (days) => {
                                                                    $form.availability[
                                                                        days
                                                                    ] =
                                                                        copyDay.map(
                                                                            (
                                                                                shift,
                                                                            ) => ({
                                                                                ...shift,
                                                                            }),
                                                                        ); // Create a new object for each shift
                                                                },
                                                            );
                                                        }}
                                                        type="button"
                                                        class="cursor-pointer hover:font-bold hover:bg-gray-200 rounded-full"
                                                        title="Copiar este horario en todos"
                                                    >
                                                        <iconify-icon
                                                            class="text-2xl"
                                                            icon="material-symbols-light:content-copy-outline"
                                                        ></iconify-icon>
                                                    </button>
                                                {/if}
                                            </span>
                                        </div>
                                    {/each}
                                </div>
                            {:else}
                                <p class="opacity-60 w-48">No disponible</p>
                                <span
                                    class="grid grid-cols-3 items-center gap-3 text-xl"
                                >
                                    <span> </span>

                                    <button
                                        on:click={(e) => {
                                            $form.availability[day] = [
                                                ...$form.availability[day],
                                                {
                                                    start: "7:00am",
                                                    end: "8:00am",
                                                },
                                            ];
                                            console.log($form.availability);
                                        }}
                                        type="button"
                                        class="relative -left-1.5 cursor-pointer hover:font-bold hover:bg-gray-200 rounded-full"
                                        title="Añadir otro turno a este día"
                                    >
                                        <iconify-icon icon="gala:add"
                                        ></iconify-icon>
                                    </button>
                                    <span> </span>
                                </span>
                            {/if}
                        </li>
                    {/each}
                </ul>
            </section>
        </fieldset>

        <fieldset class="mt-2 border-b border-gray-300 pb-4 flex gap-4">
            <span>
                <iconify-icon icon="fa-solid:exchange-alt" class="pt-2"
                ></iconify-icon>
            </span>
            <section class="w-full">
                <!-- svelte-ignore a11y-click-events-have-key-events -->
                <div
                    class="p-2 flex justify-between hover:bg-gray-200 cursor-pointer w-full"
                    on:click={(e) => {
                        acordion.franja = !acordion.franja;
                    }}
                >
                    <div>
                        <legend class="font-bold">Franja de programación</legend
                        >
                        <small class="inline-block"
                            >Desde 60 días de antelación hasta 4 horas antes</small
                        >
                    </div>
                    <iconify-icon icon="iconamoon:arrow-down-2-duotone"
                    ></iconify-icon>
                </div>
                {#if acordion.franja}
                    <div class="p-2 mt-1">
                        <label class="flex gap-3 items-center mb-3">
                            <input
                                bind:group={$form.time_available_type}
                                type="radio"
                                class="w-5 h-5"
                                name="time_available_type"
                                value={1}
                            />
                            <span>Ya disponible</span>
                        </label>
                        <label class="flex gap-3 items-center mb-3">
                            <input
                                bind:group={$form.time_available_type}
                                type="radio"
                                class="w-5 h-5"
                                name="time_available_type"
                                value={2}
                            />
                            <div class="leading-4">
                                <p>Fechas de inicio y finalización</p>
                                <small
                                    >Limita el intervalo de fechas en todas las
                                    citas</small
                                >
                            </div>
                        </label>

                        <small class="mt-4 mb-2 inline-block"
                            >Tiempo máximo antes de la cita con el que se puede
                            reservar
                        </small>
                        <span
                            class={`${!$form.allow_max_reservation_time_before_appointment ? "opacity-80" : ""} flex items-center gap-3`}
                        >
                            <input
                                type="checkbox"
                                class="w-6 h-6"
                                bind:checked={$form.allow_max_reservation_time_before_appointment}
                            />
                            <Input
                                type="number"
                                disabled={!$form.allow_max_reservation_time_before_appointment}
                                classes={"w-16 mt-0"}
                                bind:value={$form.max_reservation_time_before_appointment}
                                error={$form.errors
                                    ?.max_reservation_time_before_appointment}
                            /> <span> días </span>
                        </span>
                        <small class="mt-4 mb-2 inline-block"
                            >Tiempo máximo antes de la cita con el que se puede
                            reservar
                        </small>
                        <span
                            class={`${!$form.allow_min_reservation_time_before_appointment ? "opacity-80" : ""} flex items-center gap-3`}
                        >
                            <input
                                type="checkbox"
                                class="w-6 h-6"
                                bind:checked={$form.allow_min_reservation_time_before_appointment}
                            />
                            <Input
                                type="number"
                                classes={"w-16 mt-0"}
                                bind:value={$form.min_reservation_time_before_appointment}
                                error={$form.errors
                                    ?.min_reservation_time_before_appointment}
                            /> <span> horas </span>
                        </span>
                    </div>
                {/if}
            </section>
        </fieldset>

        <fieldset class="mt-2 border-b border-gray-300 pb-4 flex gap-4">
            <span class="pt-2">
                <iconify-icon icon="ant-design:reload-time-outline"
                ></iconify-icon>
            </span>
            <section class="p-2">
                <legend class="font-bold">Disponibilidad ajustada</legend>
                <small class="mb-5 inline-block"
                    >Indica a qué horas estás disponible en fechas concretas</small
                >
                <ul class="hidden flex flex-col space-y-2 mt-2 gap-y-1 relative -left-10">
                    <li class="flex gap-4 justify-between">
                        <input
                            type="date"
                            name=""
                            id="date1"
                            class="px-2 p-1"
                        />

                        <!-- {#if shifts.length >= 1} -->
                        <div class="gap-2 flex flex-col">
                            <!-- {#each shifts as shift, indx} -->
                            <div class="flex gap-3">
                                <span
                                    class="flex w-48 items-center justify-between bg-gray-200"
                                >
                                    <Input
                                        type="select"
                                        classes={"mt-0 border-none"}
                                        inputClasses={"bg-gray-200 p-3 border-none appearance-none"}
                                    >
                                        <option value="7:00am">7:00am</option>
                                        <option value="8:00am">8:00am</option>
                                    </Input>
                                    <span class="p-1 px-2 font-bold"> - </span>
                                    <Input
                                        type="select"
                                        classes={"mt-0"}
                                        inputClasses={"bg-gray-200 p-3 border-none appearance-none"}
                                    >
                                        <option value="7:00am">7:00am</option>
                                        <option value="8:00am">8:00am</option>
                                    </Input>
                                </span>
                                <span
                                    class="grid grid-cols-3 items-center gap-3 text-xl flex-auto"
                                >
                                    <button
                                        on:click={(e) => {
                                            $form.availability[day] = [
                                                ...$form.availability[
                                                    day
                                                ].filter((v, i) => i != indx),
                                            ];
                                        }}
                                        type="button"
                                        class="cursor-pointer hover:font-bold hover:bg-gray-200 rounded-full"
                                        title="No disponible"
                                    >
                                        <iconify-icon icon="mdi:remove"
                                        ></iconify-icon>
                                    </button>
                                    <button
                                        on:click={(e) => {
                                            $form.availability[day] = [
                                                ...$form.availability[day],
                                                {
                                                    start: "7:00am",
                                                    end: "8:00am",
                                                },
                                            ];
                                        }}
                                        type="button"
                                        class="cursor-pointer hover:font-bold hover:bg-gray-200 rounded-full"
                                        title="Añadir otro turno a este día"
                                    >
                                        <iconify-icon icon="gala:add"
                                        ></iconify-icon>
                                    </button>
                                    <button
                                        on:click={(e) => {
                                            let copyDay = [
                                                ...$form.availability[day],
                                            ]; // Shallow copy for array of objects
                                            Object.keys(
                                                $form.availability,
                                            ).forEach((days) => {
                                                $form.availability[days] =
                                                    copyDay.map((shift) => ({
                                                        ...shift,
                                                    })); // Create a new object for each shift
                                            });
                                        }}
                                        type="button"
                                        class="cursor-pointer hover:font-bold hover:bg-gray-200 rounded-full"
                                        title="Copiar este horario en todos"
                                    >
                                        <iconify-icon
                                            class="text-2xl"
                                            icon="material-symbols-light:content-copy-outline"
                                        ></iconify-icon>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </li>
                </ul>
                <label
                    for="date1"
                    class="text-color2 font-bold p-1 px-3 rounded hover:bg-color2 hover:bg-opacity-10"
                    >Cambiar la diponibilidad en una fecha</label
                >
            </section>
        </fieldset>

        <fieldset class="mt-2 pb-4 flex gap-4">
            <span>
                <iconify-icon class="pt-2" icon="mdi:calendar-check"
                ></iconify-icon>
            </span>
            <section>
                <!-- svelte-ignore a11y-click-events-have-key-events -->
                <div
                    class="p-2 flex  justify-between hover:bg-gray-200 cursor-pointer w-full"
                    on:click={(e) => {
                        acordion.ajustesCitasReservadas =
                            !acordion.ajustesCitasReservadas;
                    }}
                >
                    <div>
                        <legend class="font-bold"
                            >Ajustes de citas reservadas</legend
                        >
                        <small class="leading-4 inline-block">
                            Gestionar las citas reservadas que aparecerán en tu calendario</small
                        >
                    </div>
                    {#if acordion.ajustesCitasReservadas}
                        <iconify-icon icon="iconamoon:arrow-up-2-duotone"
                        ></iconify-icon>
                    {:else}
                        <iconify-icon icon="iconamoon:arrow-down-2-duotone"
                        ></iconify-icon>
                    {/if}
                </div>
                {#if acordion.ajustesCitasReservadas}
                    <div class="p-2 mt-1">
                        <div>
                            <div class="leading-5 mb-1">
                                <p class="mt-2 inline-block font-bold">
                                    Duración del periodo entre citas
                                </p>
                                <small class="inline-block">
                                    Añade tiempo entre una cita y otra
                                </small>
                            </div>

                            <span class={`${!$form.allow_time_between_appointment ? "opacity-80" : ""} flex items-center gap-3`}>

                                <input
                                    type="checkbox"
                                    class="w-6 h-6"
                                    name=""
                                    id=""
                                    bind:checked={$form.allow_time_between_appointment}

                                />
                                <Input
                                    type="number"
                                    classes={"w-16 mt-0"}
                                    disabled={!$form.allow_time_between_appointment}
                                    inputClasses={"p-3ray-50 w-16"}
                                    bind:value={$form.time_between_appointment}
                                    error={$form.errors
                                        ?.time_between_appointment}
                                />
                                <Input
                                    type="select"
                                    classes={"mt-0 w-36  border-none"}
                                    inputClasses={"p-3er-none"}
                                    bind:value={$form.time_between_appointment_type}
                                    error={$form.errors
                                        ?.time_between_appointment_type}
                                >
                                    <option value="minutes">minutos</option>
                                    <option value="hours">horas</option>
                                </Input>
                            </span>
                        </div>

                        <div>
                            <div class="leading-5 mb-1 mt-1">
                                <p class="mt-4 inline-block font-bold">
                                    Máximo de reservas por día
                                </p>
                                <small class="inline-block">
                                    Limitar cuántas citas reservadas se pueden
                                    aceptar en un día
                                </small>
                            </div>

                            <span class={`${!$form.allow_max_appointment_per_day ? "opacity-80" : ""} flex items-center gap-3`}
                            >
                                <input
                                    type="checkbox"
                                    class="w-6 h-6"
                                    bind:checked={$form.allow_max_appointment_per_day}
                                    
                                    />
                                    <Input
                                    type="number"
                                    disabled={!$form.allow_max_appointment_per_day}
                                    classes={"w-16 mt-0"}
                                    inputClasses={"p-3ray-50 w-16"}
                                    bind:value={$form.max_appointment_per_day}
                                    error={$form.errors
                                        ?.max_appointment_per_day}
                                />
                            </span>
                        </div>
                    </div>
                {/if}
            </section>
        </fieldset>
    </form>
</section>

<style>
</style>
