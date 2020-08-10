<template>
  <v-app>
    <v-overlay z-index="10" :value="LoaderService.FullScreenLoader">
      <h1>{{ LoaderService.FullScreenLoaderMessage }}</h1>
    </v-overlay>
    <v-progress-linear
      indeterminate
      fixed
      height="5px"
      style="top: 0; z-index: 8; margin-left: 300px;"
      :active="LoaderService.FullScreenLoader"
    />
    <v-slide-x-transition hide-on-leave>
      <router-view />
    </v-slide-x-transition>
    <v-snackbar v-model="CoreService.AlertMode" :color="CoreService.AlertColor" timeout="3000">
      {{ CoreService.AlertText }}
      <template #action="{ attrs }" v-if="CoreService.AlertClose">
        <base-btn
          small
          icon
          :color="CoreService.AlertColor ? 'white' : 'error'"
          text
          v-bind="attrs"
          @click="CoreService.AlertMode = false"
        >
          <v-icon>mdi-close</v-icon>
        </base-btn>
      </template>
    </v-snackbar>
  </v-app>
</template>

<script lang="ts" src="./app.component.ts" />

<style lang="scss" src="./styles/index.scss" />
