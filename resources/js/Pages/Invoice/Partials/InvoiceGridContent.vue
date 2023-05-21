<script setup lang="ts">

import InvoiceGridItem from "@/Pages/Invoice/Partials/InvoiceGridItem.vue";

</script>

<template>
    <InvoiceGridItem>
        <div class="grid grid-cols-12">
            <div class="col-span-9">
                <slot name="item" />
            </div>

            <div class="px-1 border-x text-center">
                <slot name="price" />
            </div>

            <div class="px-1 border-r text-center">
                <slot name="quantity" />
            </div>

            <div class="text-right">
                <slot name="subTotal" />
            </div>
        </div>
    </InvoiceGridItem>
</template>
