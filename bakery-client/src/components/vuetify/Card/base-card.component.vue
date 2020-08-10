<template>
  <v-card class="round-15 big-shadow overflow-hidden">
    <v-progress-linear indeterminate :active="LoaderService.LinearLoader" />
    <v-overlay absolute :value="LoaderService.LinearLoader">
      <h2>{{ LoaderService.LinearLoaderMessage }}</h2>
    </v-overlay>
    <slot />
  </v-card>
</template>

<script lang="ts" src="./base-card.component.ts" />
