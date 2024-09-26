<script>
    export let data;
    console.log(data);
</script>

<main class="flex justify-between gap-8 md:gap-10">
    <div class="offered sticky top-2">
        <h1 class="mb-2">Especialidades y servicios de la institución</h1>
        <ul class="text-lg p-2">
            <li>Endocrinología</li>
            <li>Oncología</li>
            <li>Neurología</li>
            <li>Medicina Interna</li>
        </ul>
    </div>
    <div>
        <h2 class="font-bold text-lg">Selecciona otras Especialidades y/o servicios</h2>
        <ul class="text-lg p-2">
            <li><iconify-icon class="text-3xl relative t-4" icon="weui:sending-outlined"></iconify-icon> Endocrinología</li>
            <li><iconify-icon class="text-3xl relative t-4" icon="weui:sending-outlined"></iconify-icon> Endocrinología</li>
            <li><iconify-icon class="text-3xl relative t-4" icon="weui:sending-outlined"></iconify-icon> Endocrinología</li>
            <li><iconify-icon class="text-3xl relative t-4" icon="weui:sending-outlined"></iconify-icon> Endocrinología</li>
        </ul>
    </div>
</main>

<style>
.offered ul li:before {
  content: '✓';
  margin-right: 6px;
}
</style>