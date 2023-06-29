<script lang="ts" setup>
import imgUrl from "../../img/invoice-logo-128.png"
import {ref} from "vue";

const img = ref(imgUrl)
</script>

<template>
  <img :src="img">
</template>
