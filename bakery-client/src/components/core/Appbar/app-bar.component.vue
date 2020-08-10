<template>
  <v-app-bar app color="#f8f8ff" elevate-on-scroll>
    <v-app-bar-nav-icon color="primary" @click="CoreService.DrawerMode = !CoreService.DrawerMode" />
    <h2 class="text-center mt-1 no-select width-100 primary--text">{{ $route.name }}</h2>
    <v-spacer />
    <base-tooltip msg="Cart" direction="bottom" #default="{ on }">
      <v-badge
        color="error"
        offset-y="25"
        offset-x="25"
        :value="CartItemsCount !== '0'"
        :content="CartItemsCount"
      >
        <base-btn icon v-on="on" class="mr-1" :to="{name: 'Cart'}">
          <v-icon>mdi-cart-outline</v-icon>
        </base-btn>
      </v-badge>
    </base-tooltip>
  </v-app-bar>
</template>

<script lang="ts" src="./app-bar.component.ts" />
