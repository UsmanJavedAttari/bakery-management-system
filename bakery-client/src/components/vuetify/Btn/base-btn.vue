<template>
  <v-btn :color="color" v-bind="$attrs" v-on="$listeners" class="font-weight-bold">
    <slot />
  </v-btn>
</template>

<script lang="ts" src="./base-btn.ts" />
