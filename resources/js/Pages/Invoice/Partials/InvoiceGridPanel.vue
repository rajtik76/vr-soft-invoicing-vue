<script lang="ts" setup>

defineProps<{
    background?: string,
}>()

</script>

<template>
    <div class="border-4 rounded-xl">

        <div :class="background" class="uppercase px-4 py-1">
            <slot name="title"/>
        </div>

        <div class="py-2">
            <slot/>
        </div>

        <div
            v-if="$slots.footer"
            :class="background"
            class="uppercase px-4 py-1">
            <slot name="footer"/>
        </div>
    </div>
</template>
