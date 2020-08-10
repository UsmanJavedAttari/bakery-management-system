<template>
  <v-main class="fill-height">
    <div class="px-5 py-3 fill-height">
      <v-scroll-y-reverse-transition hide-on-leave>
        <router-view />
      </v-scroll-y-reverse-transition>
    </div>
  </v-main>
</template>

<script lang="ts" src="./view.component.ts" />
