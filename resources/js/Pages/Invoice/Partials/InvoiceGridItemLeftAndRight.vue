<script lang="ts" setup>

import InvoiceGridItem from "@/Pages/Invoice/Partials/InvoiceGridItem.vue";

</script>

<template>
    <InvoiceGridItem class="grid grid-flow-col auto-cols-fr">
        <slot name="left" />
        <div class="text-right">
            <slot name="right" />
        </div>
    </InvoiceGridItem>
</template>
