<script>
    import { useForm } from "@inertiajs/svelte";
    import { onMount, onDestroy } from "svelte";
    // import secretariaLogo from '$lib/images/logo_secretaria-circle-main.png';
    import Input from "../components/Input.svelte";
    import Modal from "../components/Modal.svelte";
    import DatePicker from "../components/DatePicker.svelte";
    import Alert from "../components/Alert.svelte";
    import { displayAlert } from "../stores/alertStore";
    let showModal = false;
    let sourceDiv;
    let width = 0;

    function updateWidth() {
        if (sourceDiv) {
            width = sourceDiv.getBoundingClientRect().width;
        }
    }
    const translateDays = {
        mon: "Lun",
        tue: "Mar",
        wed: "Mié",
        thu: "Jue",
        fri: "Vie",
        sat: "Sáb",
        sun: "Dom",
    };
    onMount(() => {
        updateWidth(); // Set the initial width
        window.addEventListener("resize", updateWidth);
    });

    onDestroy(() => {
        window.removeEventListener("resize", updateWidth);
    });

    let form = useForm({
        ci: null,
        password: null,
    });
    export let data = {
        today: "2024-09-10T04:00:00.000Z",
    };
    let frontCalendar = []
    function getNextNDays(startDate, n) {
        const result = [];
        const start = new Date(startDate);

        for (let i = 0; i <= n-1; i++) {
            const nextDate = new Date(start);
            nextDate.setDate(start.getDate() + i);
            result.push({
                date: nextDate.toISOString().split("T")[0], // Format as YYYY-MM-DD
                weekday: nextDate.toLocaleDateString("es-VE", {
                    weekday: "short",
                }),
                day: nextDate.toLocaleDateString("es-VE", {
                    day: "numeric",
                }),
            });
        }

        frontCalendar = result
        return result;
    }
    getNextNDays("2024-09-10T04:00:00.000Z", 7)
    $: console.log({frontCalendar})

</script>

<Alert />
<section class="bg-background min-h-screen">
    <header>
        <iconify-icon icon="fa6-solid:user-doctor"></iconify-icon>
    </header>

    <body class="flex">
        <div class="sticky top-1">
            <DatePicker
                on:datechange={(e) => console.log(e)}
                selected={"2024-09-10T04:00:00.000Z"}
                showDatePickerAlways={true}
                whitInput={false}
                isAllowed={(date) => {
                    const millisecs = date.getTime();
                    if (millisecs + 25 * 3600 * 1000 < Date.now()) return false;
                    if (millisecs > Date.now() + 3600 * 24 * 45 * 10000)
                        return false;
                    return true;
                }}
            />
        </div>

        <div>
            <header class=" sticky top-0 pt-1 bg-gray-100 z-30 calendarHeader">
                <div class="flex gap-4 items-center">
                    <button
                        class="text-md font-bold border border-gray-300 rounded-md p-2 px-6 hover:bg-gray-200"
                        >Hoy</button
                    >
                    <div class="mx-5 flex gap-2">
                        <button
                            class="text-2xl text-gray-900 rounded-full aspect-square hover:bg-gray-200 flex items-center w-10"
                        >
                            <iconify-icon
                                icon="iconamoon:arrow-left-2-bold"
                                class="relative left-2"
                            ></iconify-icon></button
                        >
                        <button
                            class="text-2xl text-gray-900 rounded-full aspect-square hover:bg-gray-200 flex items-center w-10"
                        >
                            <iconify-icon
                                icon="iconamoon:arrow-right-2-bold"
                                class="relative left-2"
                            ></iconify-icon></button
                        >
                    </div>
                    <!-- <h2 class="text-2xl">{data.headerInfo.month_year}</h2> -->
                </div>

                <div
                    class="py-5 w-max pt-10 flex"
                    bind:this={sourceDiv}
                    on:resize={updateWidth}
                >
                    <div class="w-10 max-w-[40px]"></div>
                    <ul class="flex listCalendarHeader">
                        {#each frontCalendar as obj (day)}
                            <li
                                class="flex flex-col justify-center text-center w-28"
                            >
                                <p
                                    class={` ${values.current_date == data.headerInfo.today ? "text-color1 " : ""}`}
                                >
                                    {translateDays[day].toUpperCase()}
                                </p>
                                <p
                                    class={`text-2xl mx-auto w-12 aspect-square rounded-full flex items-center justify-center ${values.current_date == data.headerInfo.today ? "bg-color1 text-gray-50 " : ""}`}
                                >
                                    {new Date(values.current_date).getUTCDate()}
                                </p>
                            </li>
                        {/each}
                    </ul>
                </div>
            </header>
        </div>
    </body>
</section>

<style>
    * {
        box-sizing: border-box;
    }
</style>
